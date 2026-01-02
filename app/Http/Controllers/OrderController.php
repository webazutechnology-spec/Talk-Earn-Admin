<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;
use App\Models\OrderStatusTxn;
use Illuminate\Http\Request;
use App\Models\PaymentStatus;
use App\Models\OrderPayment;
use App\Models\OrderStatus;
use App\Models\BankDetail;
use App\Models\Countrie;
use App\Models\Address;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\Price;
use App\Models\Citie;
use App\Models\State;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\Kyc;

use Carbon\Carbon;
use App\Helpers\Helper;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orderes(Request $request)
    {
        $role_type = auth()->user()->roles->type;
        $user = auth()->user();

        $defaultFrom = request('from_date') ?? now()->subMonths(3)->format('Y-m-d');
        $defaultTo   = request('to_date') ?? now()->format('Y-m-d');

        $query = Order::with(['status', 'payment'])->latest();

        if ($request->filled('from_date') && $request->filled('to_date')) {

            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);

        } else {
            $query->where('created_at', '>=', now()->subMonths(3));
        }


        if ($role_type !== "Admin") {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                ->orWhere('order_by_id', $user->id);
            });
        } else {
            if ($request->filled('phone_number')) {
                $phone = $request->phone_number;

                $query->where(function ($q) use ($phone) {
                    $q->whereHas('users', function ($u) use ($phone) {
                        $u->where('phone_number', $phone);
                    })->orWhereHas('orderBy', function ($r) use ($phone) {
                        $r->where('phone_number', $phone);
                    });
                });
            }
        }

        $data = $query->get();

        $paymentstatus = PaymentStatus::get();

        return view('admin.order.list', compact('data','defaultFrom','defaultTo','paymentstatus'));
    }


    public function showInvoice($code)
    {
        $order = Order::where('code', $code)->first();
        return view('admin.order.invoice', compact('order'));
    }
        
    public function ordereAdd(Request $request)
    {
        $user = auth()->user();
        $category = ProductCategory::get();
        if(empty($request->category)) {
            $request->merge(['category' => ($category[0]->id??'0')]);
        }

        $products =  Product::where('category_id', $request->category)->get();


        
        $cart = Cart::where('user_id', $user->id)->first();

        $countrie = Countrie::orderBy('name', 'asc')->get();
        $country_id = '101';
        $states = [];
        $cities = [];
        if(!empty($country_id)) {
            $states = State::where(['country_id' => $country_id])->orderBy('name', 'asc')->get();
        }
        if(!empty($request->state_id)) {
            $cities = Citie::where(['state_id' => $request->state_id])->orderBy('name', 'asc')->get();
        }

        $iac =  Price::where('type', 'I&C')->get();
        $nm =  Price::where('type', 'Net Metering')->get();

        return view('admin.order.add',compact('category','products','cart','countrie','country_id','states','cities','iac','nm'));
    }

    public function ordereStore(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'is_new_client'    => 'required|in:Yes,No',
            'client_name'      => 'required|string|max:255',
            'client_email'     => 'required|email|max:255',
            'client_phone'     => 'required|digits_between:8,15',
            'total_amount'     => 'required|numeric|min:0',
            'a_and_c_charges'       => 'required|integer|exists:pricings,id',
            'net_metering_charges' => 'required|integer|exists:pricings,id',
            'other_charges'        => 'required|numeric|min:0',
            'advance_payment'  => 'required|numeric|min:0', //|lte:total_amount
            'remaining_amount' => 'required|numeric|min:0',
            'payment_mode'     => 'required|string|max:50',
            'utr_no'           => 'nullable|string|max:100',
            'utr_img'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description'      => 'nullable|string|max:500',
            'full_address' => 'required|string|max:500',
            'country' => 'required|integer|exists:countries,id',
            'state' => 'required|integer|exists:states,id',
            'city' => 'required|integer|exists:cities,id',
            'zip' => 'required|integer|digits:6',
        ]);

        $ancChargesInfo = Price::where('id', $request->a_and_c_charges)->first();
        $netMeteringChargesInfo =  Price::where('id', $request->net_metering_charges)->first();

        DB::beginTransaction();

        try {

            if ($request->is_new_client == 'No') {

                $client = User::where('phone_number', $request->client_phone)->first();

                if (!$client) {
                    return back()->withErrors(['client_phone' => 'Client not found with this phone number'])->withInput();
                }

                Address::where('user_id', $client->id)->update([
                    'address'   => $request->full_address,
                    'city_id' => $request->city,
                    'state_id' => $request->state,
                    'country_id' => $request->country,
                    'zip' => $request->zip,
                    'default' => 'Yes'
                ]);

            } else {

                // Check if phone or email already exists
                $exists = User::where('phone_number', $request->client_phone)
                                ->orWhere('email', $request->client_email)
                                ->exists();

                if ($exists) {
                    return back()->withErrors([
                        'client_phone' => 'Client with this phone or email already exists.'
                    ])->withInput();
                }

                $client = User::create([
                    'code' => Helper::getTransId(4),
                    'name' => $request->client_name,
                    'email' => $request->client_email,
                    'phone_number' => $request->client_phone,
                    'password' => Hash::make($request->client_phone),
                    'role_id' => 4
                ]);

                Kyc::create([
                    'user_id' => $client->id
                ]);
                
                Address::create([
                    'user_id' => $client->id,
                    'type' => 'Home',
                    'address'   => $request->full_address,
                    'city_id' => $request->city,
                    'state_id' => $request->state,
                    'country_id' => $request->country,
                    'zip' => $request->zip,
                    'default' => 'Yes'
                ]);

                Wallet::create([
                    'user_id' => $client->id
                ]);

                BankDetail::create([
                    'user_id' => $client->id
                ]);
            }

            $address = Address::where('user_id', $client->id)->first();

            $client_address = [
                'type' => $address->type,
                'address'   => $address->address,
                'street'   => $address->street,
                'city_id'   => $address->city_id,
                'city_name'   => $address->city->name,
                'state_id'   => $address->state_id,
                'state_name'   => $address->state->name,
                'country_id'   => $address->country_id,
                'country_name'   => $address->country->name,
                'zip'   => $address->zip
            ];

            $gstRate = config('loan.tax');
            $total = (float) $request->total_amount;
            $otherCharges = (float) $request->other_charges;
            $ancCharges = (float) $ancChargesInfo->amount;
            $netMeteringCharges = (float) $netMeteringChargesInfo->amount;
            $finalAmount = $total + $ancCharges + $netMeteringCharges + $otherCharges;
            $gstAmount = $finalAmount * $gstRate / (100 + $gstRate);
            $baseAmount = $finalAmount - $gstAmount;
            $taxType = $address->state_id == 4022? 'CGST & SGST':'IGST';

            $cart = Cart::where('user_id', $user->id)->first();

            $code = 'ORD-' . strtoupper(uniqid());

            $order = Order::create([
                'code'                      => $code,
                'order_by_id'               => auth()->id(),
                'user_id'                   => $client->id,
                'address'                   => json_encode($client_address),
                'total_amount'              => $total,
                'other_charges'             => $otherCharges,
                'anc_amount'                => $ancCharges,
                'net_metering_amount'       => $netMeteringCharges,
                'final_amount_with_tax'     => $finalAmount,
                'final_amount_without_tax'  => $baseAmount,
                'order_tax'                 => $gstAmount,
                'tax_type'                  => $taxType,
                'anc_id'                    => $ancChargesInfo->id,
                'anc_name'                  => $ancChargesInfo->name,
                'net_metering_id'           => $netMeteringChargesInfo->id,
                'net_metering_name'         => $netMeteringChargesInfo->name,
                'order_status_id'           => 1,
                'payment_status_id'         => 1,
                'product_details'           => $cart->product_json
            ]);

            $orderId = $order->id;

            $imagePath = null;
            if ($request->hasFile('utr_img')) {
                $image = $request->file('utr_img');
                $imageName = $code . '_' . $image->getClientOriginalName();
                $image->move(public_path('payment'), $imageName); // save to public/payment
                $imagePath = 'payment/' . $imageName; // store relative path in DB
            }

            $advancePayment = (float)$request->advance_payment;
            $type = 'Part Payment';
            if($advancePayment >= $finalAmount){
                $type = 'Full Payment';
            }

            if($advancePayment > 0) {
                OrderPayment::create([
                    'user_id' => $user->id,
                    'order_id' => $orderId,
                    'trans_type' => 'Received',
                    'type' => $type,
                    'method' => $request->payment_mode,
                    'utr_no' => $request->utr_no,
                    'amount' => $advancePayment,
                    'image' => $imagePath,
                ]);
            }

            $cart->delete();
            
            if($order->orderBy->phone_number) {

                $sms_data = [   
                    'template_name' =>  'order_created_associate',
                    'send_to_phone' => $order->orderBy->phone_number,
                    'user_id'       =>  0,
                    'user_type'     =>  'User',
                    'title'         =>  'Order Completed',
                    'name'          =>  $order->user->name,
                    'code'          =>  $order->code,
                    'phone'         =>  $order->user->phone_number,
                    'email'         =>  $order->user->email,
                    'password'      =>  '',
                    'otp'           =>  '',
                    'message'       =>  '',
                    'date'          =>  '',
                    'link'          =>  '',
                    'trans_id'      =>  '',
                    'other'         =>  ''
                ];

                $send = Helper::send_sms($sms_data); 
            }

            $sms_data = [   
                'template_name' =>  'order_created_customer',
                'send_to_phone' => $order->user->phone_number,
                'user_id'       =>  0,
                'user_type'     =>  'User',
                'title'         =>  'Order Completed',
                'name'          =>  $order->user->name,
                'code'          =>  $order->code,
                'phone'         =>  $order->user->phone_number,
                'email'         =>  $order->user->email,
                'password'      =>  '',
                'otp'           =>  '',
                'message'       =>  '',
                'date'          =>  '',
                'link'          =>  '',
                'trans_id'      =>  '',
                'other'         =>  ''
            ];

            $send = Helper::send_sms($sms_data); 

            DB::commit();

            return redirect()->back()->with('success', 'Booking successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    } 
    

    public function ordereDelete($id)
    {
        $data = Order::withTrashed()->findOrFail($id);
        
        if ($data->trashed()) {
            $data->restore();
            $message = 'Booking restored successfully!';
        } else {
            $data->delete();
            $message = 'Booking deleted successfully!';
        }

        return redirect()->route('orderes')->with('success', $message);
    }  


    public function ordereUpdateStatus(Request $request)
    {

        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'status' => 'required|integer|exists:order_status,id',
            'payment_status' => 'required|integer|exists:order_payments,id',
        ]);

        $user = auth()->user();
        $role_type = auth()->user()->roles->type;

        // Get order
        $order = Order::findOrFail($request->order_id);

        // Update order
        $order->order_status_id = $request->status;
        $order->payment_status_id = $request->payment_status;

        if(!empty($request->commision) && $request->commision > 0) {   
            $order->commision = $request->commision;
        }

        $order->save();

        // Create order log
        OrderStatusTxn::create([
            'order_id'            => $order->id,
            'order_status_id'     => $request->status,
            'payment_status_id'   => $request->payment_status,
            'creatby_user_type'   => $role_type, // or $user->role
            'created_by_id'       => $user->id,
            // 'description'         => $request->description,
            // 'documents'           => $request->documents,
            // 'reason_message'      => $request->reason_message,
        ]);

        if($order->order_status_id == 8) {

            $sms_data = [   
                'template_name' =>  'order_completed_associate',
                'send_to_phone' => $order->orderBy->phone_number,
                'user_id'       =>  0,
                'user_type'     =>  'User',
                'title'         =>  'Order Completed',
                'name'          =>  $order->user->name,
                'code'          =>  $order->user->code,
                'phone'         =>  $order->user->phone_number,
                'email'         =>  $order->user->email,
                'password'      =>  '',
                'otp'           =>  '',
                'message'       =>  '',
                'date'          =>  '',
                'link'          =>  '',
                'trans_id'      =>  '',
                'other'         =>  ''
            ];

            $send = Helper::send_sms($sms_data); 

            $sms_data = [   
                'template_name' =>  'order_completed_customer',
                'send_to_phone' => $order->user->phone_number,
                'user_id'       =>  0,
                'user_type'     =>  'User',
                'title'         =>  'Order Completed',
                'name'          =>  $order->user->name,
                'code'          =>  $order->user->code,
                'phone'         =>  $order->user->phone_number,
                'email'         =>  $order->user->email,
                'password'      =>  '',
                'otp'           =>  '',
                'message'       =>  '',
                'date'          =>  '',
                'link'          =>  '',
                'trans_id'      =>  '',
                'other'         =>  ''
            ];

            $send1 = Helper::send_sms($sms_data); 
        }

        return redirect()->back()->with('success', 'chnage status successfully');
    }
    
    
    public function ordereUpdatePaymnet(Request $request)
    {
       $user = auth()->user();

        $request->validate([
            'order_id'         => 'required|integer|exists:orders,id',
            'amount'           => 'required|numeric|min:0',
            'payment_mode'     => 'required|string|max:50',
            'utr_no'           => 'nullable|string|max:100',
            'utr_img'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description'      => 'nullable|string|max:500'
        ]);
        
        $user = auth()->user();
        $role_type = auth()->user()->roles->type;

        // Get order
        $order = Order::findOrFail($request->order_id);

        $imagePath = null;
        if ($request->hasFile('utr_img')) {
            $image = $request->file('utr_img');
            $imageName = $order->code . '_' . $image->getClientOriginalName();
            $image->move(public_path('payment'), $imageName); // save to public/payment
            $imagePath = 'payment/' . $imageName; // store relative path in DB
        }

        $totalPay = OrderPayment::where('order_id', $request->order_id)->sum('amount');
        $amount = (float)$request->amount;


        if($amount > 0) {
            OrderPayment::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'trans_type' => 'Received',
                'type' => 'Part Payment',
                'method' => $request->payment_mode,
                'utr_no' => $request->utr_no,
                'amount' => $amount,
                'image' => $imagePath,
            ]);
        }

        if($totalPay >= $order->final_amount){
            $order->payment_status_id = 3;
        }

        $order->save();

        return redirect()->back()->with('success', 'payment update successfully');
    } 
    


    public function getByCategory(Request $request)
    {
        $products = Product::where('category_id', $request->category_id)->get();
        return view('admin.order._partial.product_list_ajax', compact('products'))->render();
    }


    public function getProductById(Request $request)
    {
        $user = auth()->user();

        $product = Product::with('category','brand')
            ->where('id', $request->product_id)
            ->firstOrFail();

        $cart = Cart::where('user_id', $user->id)->first();

        $data = [               
            "id" => $product->id,
            "name" =>   $product->name,
            "slug" =>   $product->slug,
            "image" => $product->image,
            "sku" => $product->sku,
            "category_id" => $product->category_id,
            "category_name" =>$product->category->name??'',
            "brand_id" => $product->brand_id,
            "brand_name" => $product->brand->name??'',
            "capacity" => $product->capacity,
            "type" => $product->type,
            "voltage" => $product->voltage,
            "price" => $product->price,
            "disc_price" => $product->disc_price,
            "quantity" => 1
        ];

        if ($cart) {
   
            $items = json_decode($cart->product_json, true);
            $ids = array_column($items, 'id');
            $index = array_search($product->id, $ids);

            if ($index !== false) {
                $items[$index]["quantity"] += 1;
            } else {
                $items[] = $data;
            }

            $cart->update(["product_json" => json_encode($items)]);

        } else {
            Cart::create([
                "user_id" => $user->id,
                "product_json" => json_encode([$data])
            ]);
        }

        return response()->json([
            'success' => true,
            'cart_html' => view('admin.order._partial.cart_table', [
            'cart' => Cart::where('user_id', $user->id)->first()
            ])->render()
        ]);
    }


    public function updateCart(Request $request)
    {
        $user = auth()->user();

        $product = Product::where('id', $request->product_id)->firstOrFail();

        $cart = Cart::where('user_id', $user->id)->first();
        
        if(!$cart){
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart'
            ], 404);
        }

        $items = json_decode($cart->product_json, true);
        $ids = array_column($items, 'id');
        $index = array_search($product->id, $ids);

        if ($index !== false) {

            $items[$index]['quantity']   = $request->quantity;
            $items[$index]['disc_price'] = $request->disc_price;

            $cart->update(["product_json" => json_encode($items)]);

            return response()->json([
                'success' => true,
                'data' => $items[$index]
            ]);
        } else {
            if ($index === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in cart'
                ], 404);
            }
        }
    }

    public function deleteCart(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())
                    ->firstOrFail();

        $items = json_decode($cart->product_json, true);

        $items = array_values(array_filter($items, function ($item) use ($request) {
            return $item['id'] != (int)$request->product_id;
        }));

        if (count($items) === 0) {
            $cart->delete();
        } else {
            $cart->update([
                'product_json' => json_encode($items)
            ]);
        }

        return response()->json(['success' => true]);
    }
    
    public function findByPhone(Request $request)
    {
        $client = User::where('phone_number', $request->phone)->first();

        if ($client) {
            return response()->json([
                'success' => true,
                'data' => [
                    'name'  => $client->name,
                    'email' => $client->email,
                ]
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function orderStatus(Request $request)
    {
        $role_type = auth()->user()->roles->type;
        $user = auth()->user();

        $data = OrderStatus::where('id', $request->status_id)->first();

        if ($data) {
            $list = OrderStatus::whereIn('process_order', [$data->process_order, ($data->process_order+1), 8])->whereRaw('FIND_IN_SET(?, for_role)', [$user->role_id])->get();
            return response()->json([
                'success' => true,
                'data' => $list
            ]);
        }

        return response()->json([
            'success' => false,
            'data' => []
        ]);
    }



    public function iac()
    {
        $data = Price::where('type','I&C')->get();

        return view('admin.order.master.ic.list', compact('data'));
    }
      public function iacAdd()
    {
        return view('admin.order.master.ic.add');
    }

    public function iacStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:pricings,name',
            'amount' => 'required|numeric',
        ]);

        $data = new Price();

        $data->name = $request->name;
        $data->amount = $request->amount;
        $data->type = 'I&C';


        $check = $data->save();

        if($check) {
            return redirect()->route('iac')->with('success', 'I & C created successfully.');
        } else {
            return redirect()->route('iac')->with('error', 'I & C not created.');
        }
    }

    public function iacEdit($id)
    {
        $data = Price::findOrFail($id);
        return view('admin.order.master.ic.edit', compact('data'));
    }

    public function iacUpdate(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255|unique:pricings,name,' . $id . ',id,type,I & C',
            'amount' => 'required|numeric',
        ]);

        $data =Price::findOrFail($id);
        $data->name = $request->name;
        $data->amount = $request->amount;

        $check = $data->save();

        if($check) {
            return redirect()->route('iac')->with('success', 'I & C updated successfully.');
        } else {
            return redirect()->route('iac')->with('error', 'I & C not updated.');
        }
    }

    public function iacDelete($id)
    {
        $data = Price::withTrashed()->findOrFail($id);
        
        if ($data->trashed()) {
            $data->restore();
            $message = 'I & C restored successfully!';
        } else {
            $data->delete();
            $message = 'I & C deleted successfully!';
        }

        return redirect()->route('iac')->with('success', $message);
    } 
    
    public function netmeterings()
    {
        $data = Price:: where('type','Net Metering')->get();
        return view('admin.order.master.netmetering.list',compact('data'));
    }

    public function netmeteringAdd()
    {
        return view('admin.order.master.netmetering.add');
    }

    public function netmeteringStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:pricings,name',
            'amount' => 'required|numeric',
        ]);

        $data = new Price();

        $data->name = $request->name;
        $data->amount = $request->amount;
        $data->type = 'Net Metering';


        $check = $data->save();

        if($check) {
            return redirect()->route('netmeterings')->with('success', 'Net Metering created successfully.');
        } else {
            return redirect()->route('netmeterings')->with('error', 'Netmetering not created.');
        }
    }

    public function netmeteringEdit($id)
    {
        $data = Price::findOrFail($id);
        return view('admin.order.master.netmetering.edit', compact('data'));
    }

    public function netmeteringUpdate(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255|unique:pricings,name,' . $id . ',id,type,Net Metering',
            'amount' => 'required|numeric',
        ]);

        $data =Price::findOrFail($id);
        $data->name = $request->name;
        $data->amount = $request->amount;

        $check = $data->save();

        if($check) {
            return redirect()->route('netmeterings')->with('success', 'Net Metering updated successfully.');
        } else {
            return redirect()->route('netmeterings')->with('error', 'Net Metering not updated.');
        }
    }

    public function netmeteringDelete($id)
    {
        $data = Price::withTrashed()->findOrFail($id);
        
        if ($data->trashed()) {
            $data->restore();
            $message = 'Net Metering restored successfully!';
        } else {
            $data->delete();
            $message = 'Net Metering deleted successfully!';
        }

        return redirect()->route('netmetrings')->with('success', $message);
    }  




}
