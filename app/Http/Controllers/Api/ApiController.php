<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use App\Mail\SendOtpMail;
use App\Models\BookingService;
use App\Models\WebsiteSetting;
use App\Models\OrderProduct;
use App\Models\UserAddress;
use App\Models\UserRequest;
use App\Models\SubCategory;
use App\Models\ServiceCart;
use App\Models\WebsiteInfo;
use App\Models\Wishlist;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use DB;

class ApiController extends Controller
{

    public function getState()
    {
        $states = DB::table('states')->get();

        return response()->json([
            'status' => 200,
            'message' => 'get states successfully.',
            'data' => $states, 
        ]);
    }


    public function getCities($state)
    {
        $state = DB::table('states')->where('id', $state)->first();
        $cities = DB::table('cities')->where('state_id', $state->id??'-1')->get();
        return response()->json([
            'status' => 200,
            'message' => 'get cities successfully.',
            'data' => $cities
        ]);
    }




    public function websiteSettings(Request $request){
        
        $websiteSettings = WebsiteSetting::all();

        $settings = collect($websiteSettings??[])->pluck('value', 'key')->toArray();

        return response()->json([
            'status'  => 200,
            'message' => 'App Config fetched successfully',
            'data'    => $settings
        ]);
    }


    public function appWebsiteInfo($type, Request $request){

        $request->merge(['type' => $type]);

        $validated = Validator::make($request->all(), [
            'type' => 'required|in:about-us,term-and-condition,disclaimer,privacy-policy',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status'  => 400,
                'message' => $validated->errors()->first(),
                'errors' => $validated->errors()
            ]);
        }

        $websiteInfo = WebsiteInfo::where('type',$type)->first();

        return response()->json([
            'status'  => 200,
            'message' => 'Wishlist fetched successfully',
            'data'    => $websiteInfo
        ]);
        
    }




    public function placeOrder(Request $request)
    {
        // Prevent multiple pending orders
        $lastOrder = Order::where('user_id', $request->user_id)
            ->whereNotIn('order_status', ['Packed', 'Shipped', 'Delivered', 'Cancelled'])
            ->latest()
            ->first();

        if ($lastOrder) {
            return response()->json([
                'status'  => false,
                'message' => 'You cannot place a new order until your previous order is packed'
            ]);
        }

        // Common variables
        $user       = User::findOrFail($request->user_id);
        $cartItems  = Cart::where('user_id', $request->user_id)->with('product')->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Your cart is empty']);
        }

        $deliveryCharge = Setting::where('setting_name', 'delivery_charge')->value('setting_value') ?? 0;
        $order_unique_id = 'OD' . time();
        $orderDate   = now();
        $deliveryDate = now()->addDays(3)->toDateString();

        // Calculate total
        $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // User address
        $userAddress = UserAddress::where([
            'id' => $request->address,
            'user_id' => $request->user_id
        ])->firstOrFail();

        $deliveryAddress = trim(
            "{$userAddress->address} {$userAddress->locality} {$userAddress->landmark} " .
            "{$userAddress->city} {$userAddress->state} {$userAddress->pincode}"
        );

        // Handle coupon
        $discount = 0;
        if ($request->couponCodeApplied && $request->coupon) {
            $coupon = Coupon::where('code', $request->coupon)->first();
            if ($coupon) {
                $discount = $coupon->type === 'percentage'
                    ? ($totalAmount * ($coupon->discount / 100))
                    : $coupon->discount;
            }
        }

        // Payment Verification for Online
        $paymentId = null;
        if ($request->paymentMethod === 'Online') {
            try {
                $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                $payment = $api->payment->fetch($request->razorpay_payment_id);

                if ($payment->status !== 'captured') {
                    return response()->json(['success' => false, 'message' => 'Payment verification failed']);
                }

                $paymentId = $request->razorpay_payment_id;
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'message' => 'Something went wrong']);
            }
        } else {
            // COD payment id
            $paymentId = 'cod' . uniqid();
        }

        // Prepare order data
        $orderData = [
            "user_id"           => $request->user_id,
            "order_unique_id"   => $order_unique_id,
            "total_amount"      => max(0, ($totalAmount - $discount) + (!$request->couponCodeApplied ? $deliveryCharge : 0)),
            "order_date"        => $orderDate,
            "payment_method"    => $request->paymentMethod,
            "payment_id"        => $paymentId,
            "delivery_address"  => $deliveryAddress,
            "address_type"      => $userAddress->address_type,
            "is_coupon_applied" => $discount > 0 ? 1 : 0,
            "coupon_code"       => $request->coupon ?? null,
            "coupon_discount"   => $discount,
        ];

        // Insert order
        $orderId = Order::insertGetId($orderData);

        // Insert products
        foreach ($cartItems as $item) {
            OrderProduct::insert([
                "order_id"              => $orderId,
                "user_id"               => $request->user_id,
                "name"                  => $userAddress->name,
                "mobile"                => $userAddress->mobile,
                "product_id"            => $item->product->id,
                "product_name"          => $item->product->name,
                "product_quantity"      => $item->quantity,
                "product_strike_price"  => $item->product->strike_price,
                "product_price"         => $item->product->price,
                "total_amount"          => $item->product->price * $item->quantity,
                "delivery_address"      => $deliveryAddress,
                "address_type"          => $userAddress->address_type,
                "order_date"            => $orderDate,
                "delivery_date"         => $deliveryDate,
            ]);
        }

        // Clear cart
        Cart::where('user_id', $request->user_id)->delete();

        // Send email
        $mailData = [
            'status'          => 'Order Placed 🛍️',
            'name'            => $user->name,
            'orderId'         => $order_unique_id,
            'orderAmount'     => $orderData['total_amount'],
            'deliveryAddress' => $deliveryAddress,
            'paymentMethod'   => $request->paymentMethod,
            'trackingId'      => '',
            'trackingLink'    => ''
        ];
        $mailSubject = 'Order Confirmation. Order Id: ' . $order_unique_id;

        // $this->sendMail($mailData, $mailSubject, $user->email);

        return response()->json(['status' => 200, 'message' => 'Order Placed', 'orderid' => $order_unique_id]);
    }


    public function createRazorpayOrder(Request $request)
    {
        // ✅ Validate request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount'  => 'required|numeric|min:1',
        ]);

        // ✅ Check if user has pending order
        $hasPendingOrder = Order::where('user_id', $request->user_id)
            ->whereNotIn('order_status', ['Packed', 'Shipped', 'Delivered', 'Cancelled'])
            ->exists();

        if ($hasPendingOrder) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot place a new order until your previous order is packed'
            ], 400);
        }

        try {
            // ✅ Razorpay API Init
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            // ✅ Create order (only in Razorpay, not DB yet)
            $razorpayOrder = $api->order->create([
                'amount'          => $request->amount * 100, // in paise
                'currency'        => 'INR',
                'payment_capture' => 1
            ]);

            return response()->json([
                'success'   => true,
                'order_id'  => $razorpayOrder->id,
                'amount'    => $request->amount,
                'currency'  => 'INR'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create Razorpay order',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function orderList(Request $request)
    {
        $userId = 430;//$request->user()->id;

        $orders = Order::where('user_id', $userId)
                ->addSelect([
                    'user_name' => OrderProduct::select('name')
                        ->whereColumn('order_id', 'orders.id')
                        ->limit(1),
                    'user_mobile' => OrderProduct::select('mobile')
                        ->whereColumn('order_id', 'orders.id')
                        ->limit(1),
                ])
                ->with(['orderProduct' => function ($q) {
                    $q->select(
                        'id',
                        'order_id',
                        'product_id',
                        'product_name',
                        'product_quantity',
                        'product_strike_price',
                        'product_price',
                        'total_amount',
                        'order_status'
                    );
                }])
                ->get();

        return response()->json([
            'status'  => 200,
            'message' => 'orders fetched successfully',
            'data'    => $orders
        ]);
    }
    
    public function orderDetail($orderid)
    {
        $userId = 430;//$request->user()->id;
        $order = Order::where('user_id', $userId)
            ->where('id', $orderid)
            ->addSelect([
                'user_name' => OrderProduct::select('name')
                    ->whereColumn('order_id', 'orders.id')
                    ->limit(1),
                'user_mobile' => OrderProduct::select('mobile')
                    ->whereColumn('order_id', 'orders.id')
                    ->limit(1),
            ])
            ->with(['orderProduct' => function ($q) {
                $q->select(
                    'id',
                    'order_id',
                    'product_id',
                    'product_name',
                    'product_quantity',
                    'product_strike_price',
                    'product_price',
                    'total_amount',
                    'order_status'
                )->with('product');
            }])
            ->first();

        // $orderProducts = OrderProduct::where('order_id', $orderid)->with(['product', 'order'])->latest()->get();
        // $firstOrder = Order::where('user_id', $request->user->id)->where('order_id', $orderid)->with('orderProduct')->first();
    
        return response()->json([
            'status'  => 200,
            'message' => 'orders fetched successfully',
            'data'    => $order
        ]);
    }

    public function cancelOrder(Request $request)
    {
        $cancelData = [
            'cancel_reason' => $request->cancelReason,
            'cancel_by'     => 'Cancel By User'
        ];

        Order::where('id', $request->orderId)->update($cancelData);

        return response()->json(['status' => true, 'cancelData' => $cancelData]);
    }


}
