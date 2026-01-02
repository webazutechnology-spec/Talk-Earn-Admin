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

    public function profile(Request $request)
    {
        $data = User::where('id', $request->user->id??'-')->first()->toArray();
        return response()->json([
            "status" => 200,
            "data" => $data
        ]);
    }


    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 400, 
                "message" => $validator->errors()->first(), 
                "errors" => $validator->errors()
            ]);
        }

        $user = User::find($request->user->id);
       
        $user->name = $request->name ?? $user->name;
        $user->gender = $request->gender ?? $user->gender;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/profile_images'), $filename);
            $user->image = $filename;
        }

        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'User info updated successfully.',
            'data' => $user
        ]);
    }
    

    public function getCategory()
    {
        $categories = Category::where('status', 1)->latest()->get();
        return response()->json([
            "status" => 200,
            'message' => 'Get category successfully.',
            "data" => $categories
        ]);
    }

    public function getSubCategory(Request $request)
    {
        $id = $request->category_id;
        $categories = SubCategory::when($id, function ($query) use ($id) {
            return $query->where('category_id', $id);
        })
        ->latest()
        ->get();
        return response()->json([
            "status" => 200,
            'message' => 'Get Sub category successfully.',
            "data" => $categories
        ]);
    }

    public function getBrand(Request $request)
    {
        $brand = Brand::where('status', 1)->latest()->get();
        return response()->json([
            "status" => 200,
            'message' => 'Get Brand successfully.',
            "data" => $brand
        ]);
    }


    // public function homeModule()
    // {
    //     $categories = Category::where('status', 1)->with(['products','getSubCategories'])->latest()->get();
    //     return response()->json([
    //         "status" => 200,
    //         'message' => 'Get category successfully.',
    //         "data" => $categories
    //     ]);
    // }

    public function homeModule(Request $request)
    {
        $userId = $request->user->id??"";

        $perPage = $request->get('per_page', 2);
        $page = $request->get('page', 1);

        $categories = Category::skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        $data = [];

        foreach ($categories as $category) {

            $banners = $category->banners()->get(); 

            $query = $category->products()->with(['category', 'brand', 'subCategory']);

            if ($userId) {
                $query->with([
                    'userWishlist' => fn($q) => $q->where('user_id', $userId),
                    'userCart' => fn($q) => $q->where('user_id', $userId),
                ]);
            }

            $products = $query->latest()->take(10)->get();

            $data[] = [
                'category_id' => $category->id,
                'category_name' => $category->name,
                'banners' => $banners,
                'products' => $products,
            ];
        }

        $totalCategories = Category::count();

        return response()->json([
            'status' => 200,
            'message' => 'Home data retrieved successfully.',
            'data' => [
                'list' => $data,
                'meta' => [
                'current_page' => (int)$page,
                'per_page' => (int)$perPage,
                'total_categories' => $totalCategories,
                'last_page' => ceil($totalCategories / $perPage),
            ]
            ],
        ]);
    }


    public function getSlider(Request $request)
    {

        if(!empty($request->category_id)) {
            $sliders = Slider::where(function ($query) {
                                $query->where('for', 'APP')
                                      ->orWhere('for', 'BOTH');
                                })
                                ->where('type', 'Other')
                                ->orderBy('id', 'desc')
                                ->get();
        } else {
           $sliders = Slider::where(function ($query) {
                                $query->where('for', 'APP')
                                      ->orWhere('for', 'BOTH');
                                })
                                ->where('type', 'Other')
                                ->orderBy('id', 'desc')
                                ->get();
        }

        $imageUrls = [];
        foreach ($sliders as $slider) {
            $imageUrls[] = ['img' => request()->getSchemeAndHttpHost()."/uploads/slider/".$slider->image];
        }


        return response()->json([
            "status" => 200,
            'message' => 'Get category successfully.',
            "data" => $imageUrls
        ]);
    }
    
    public function products(Request $request)
    {
        
        $userId = $request->user->id??"0";
        $query = Product::with(['category', 'brand', 'subCategory']);

        if ($userId) {
            $query->with([
                'userWishlist' => fn($q) => $q->where('user_id', $userId),
                'userCart' => fn($q) => $q->where('user_id', $userId),
            ]);
        }

        if ($request->has('category_id') && !is_null($request->category_id)) {
            $query->where('category', $request->category_id);
        }

        if ($request->has('sub_category_id') && !is_null($request->sub_category_id)) {
            $query->where('sub_category', $request->sub_category_id);
        }

        if ($request->has('brand_id') && !is_null($request->brand_id)) {
            $query->where('brand', $request->brand_id);
        }

        $perPage = $request->get('per_page', 10); // default to 10
        $products = $query->orderBy('id', 'desc')->paginate($perPage);

        return response()->json([
            'status' => 200,
            'message' => 'Products retrieved successfully.',
            'data' => [
                'products' => $products->items(),
                'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]],
        ]);
    }


    public function productDetail($id, Request $request)
    {
        $userId = $request->user->id??"";

        $query = Product::with(['category', 'brand', 'subCategory','reviews']);

        if ($userId) {
            $query->with([
                'userWishlist' => fn($q) => $q->where('user_id', $userId),
                'userCart' => fn($q) => $q->where('user_id', $userId),
            ]);
        }

        $product = $query->find($id);

        if (!$product) {
            return response()->json([
                'status' => 400,
                'message' => 'Product not found.',
                'data' => null,
            ]);
        }

        $querys = Product::where('sub_category', $product->sub_category)
                                    ->where('id', '!=', $product->id);
                                    
        if ($userId) {
            $querys->with([
                'userWishlist' => fn($q) => $q->where('user_id', $userId),
                'userCart' => fn($q) => $q->where('user_id', $userId),
            ]);
        }

        $relatedProducts = $querys->latest()->take(10)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Products retrieved successfully.',
            'data' => [
                        'product' => $product,
                        // 'availability' => $availability,
                        'reviews' => $product->reviews,
                        'related_products' => $relatedProducts
                    ],
        ]);
    }

    // public function productDetail(Request $request)
    // {
    //     $product = Product::where(['id' => $request->query('product_id')])->first();
    //     $cartProduct = Cart::where(['product_id' => $request->query('product_id'), 'user_id' => $request->user_id])->first();
    //     $isAddedToCart = false;
    //     if ($cartProduct != null) {
    //         $isAddedToCart = true;
    //     }


    //     return response()->json(['product' => $product, 'status' => 200, 'cart_product' => $isAddedToCart]);
    // }



    public function create(Request $request)
    {
        
        $request->merge(['user_id' => $request->user->id]);

        $validated = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:100',
            'mobile' => 'required|regex:/[0-9]{9}/',
            'pincode' => 'required|string|max:10',
            'locality' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'landmark' => 'nullable|string',
            'address_type' => 'required|in:home,work,other'
        ],[
            'mobile.regex'          => 'Please enter a valid mobile number.',
        ]);

        if ($validated->fails()) {
            return response()->json([
                "status" => 400, 
                "message" => $validated->errors()->first(), 
                "errors" => $validated->errors()
            ]);
        }

        $data = $validated->validated();

        $address = UserAddress::create($data);

        return response()->json([
            'status' => 201,
            'message' => 'Address created successfully.',
            'data' => $address
        ]);
    }


    public function update(Request $request, $id)
    {
        $address = UserAddress::where('id', $id)->where('user_id', $request->user->id)->first();

        $request->merge(['user_id' => $request->user->id]);
        $request->merge(['id' => $id]);

        $validated = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'id' => 'required|exists:user_addresses,id',
            'name' => 'required|string|max:100',
            'mobile' => 'required|regex:/[0-9]{9}/',
            'pincode' => 'required|string|max:10',
            'locality' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'landmark' => 'required|string',
            'address_type' => 'required|in:home,work,other'
        ],[
            'mobile.regex' => 'Please enter a valid mobile number.',
        ]);


        if ($validated->fails()) {
            return response()->json([
                "status" => 400, 
                "message" => $validated->errors()->first(), 
                "errors" => $validated->errors()
            ]);
        }

        $data = $validated->validated();

        $address->update($data);

        return response()->json([
            'status' => 200,
            'message' => 'Address updated successfully.',
            'data' => $address
        ]);
    }


    public function listByUser(Request $request)
    {
        $addresses = UserAddress::whereNull('deleted_at')->where('user_id', $request->user->id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Address list retrieved.',
            'data' => $addresses
        ]);
    }


    public function getById($id)
    {
        $address = UserAddress::whereNull('deleted_at')->find($id);

        if (!$address) {
            return response()->json([
                'status' => 404,
                'message' => 'Address not found.',
                'data' => null
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Address retrieved successfully.',
            'data' => $address
        ]);
    }



    public function destroy($id)
    {
        $address = UserAddress::find($id);

        if (!$address) {
            return response()->json([
                'status' => 400,
                'message' => 'Address not found.',
            ]);
        }

        $address->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Address deleted successfully.',
        ]);
    }

    public function getStates()
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


    public function search(Request $request)
    {
        $query = $request->get('query');

        if (!$query) {
            return response()->json([
                'status' => 400,
                'message' => 'Search query is required'
            ]);
        }

        $products = Product::with(['category', 'brand', 'subCategory'])->where('name', 'like', "%{$query}%")->limit(10)->get();
        $brands = Brand::where('name', 'like', "%{$query}%")->limit(10)->get();
        $categories = Category::where('name', 'like', "%{$query}%")->limit(10)->get();
        $subCategories = SubCategory::where('name', 'like', "%{$query}%")->limit(10)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Search query is required',
            'data' => [
                'query' => $query,
                'products' => $products,
                'brands' => $brands,
                'categories' => $categories,
                'sub_categories' => $subCategories,
            ]
            
        ]);
    }



    public function addToCart(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        if ($validated->fails()) {
            return response()->json([
                "status"  => 400, 
                "message" => $validated->errors()->first(), 
                "errors"  => $validated->errors()
            ]);
        }

        $data = $validated->validated();

        $product = Product::find($data['product_id']);

        if (!$product) {
            return response()->json([
                'status'  => 400,
                'message' => 'Product not found'
            ]);
        }

        $cartItem = Cart::where('user_id', $request->user->id)
                        ->where('product_id', $product->id)
                        ->first();

        $finalQty = $data['quantity'];

        if ($cartItem) {
            $finalQty = $cartItem->quantity + $data['quantity'];
        }

        if ($finalQty < $product->moq) {
            return response()->json([
                'status'  => 400,
                'message' => "Minimum order quantity for {$product->name} is {$product->moq}. You must add at least {$product->moq}."
            ]);
        }

        // Update or create cart
        $cart = Cart::updateOrCreate(
            [
                'user_id'    => $request->user->id,
                'product_id' => $product->id
            ],
            [
                'quantity' => $finalQty
            ]
        );

        $cart = Cart::with('product')
                    ->where('user_id', $request->user->id)
                    ->get();

        return response()->json([
            'status'  => 200,
            'message' => 'Product added to cart successfully',
            'data'    => $cart
        ]);
    }


    public function updateCartQty(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        if ($validated->fails()) {
            return response()->json([
                "status" => 400, 
                "message" => $validated->errors()->first(), 
                "errors" => $validated->errors()
            ]);
        }

        $data = $validated->validated();

        $product = Product::find($data['product_id']);

        if (!$product) {
            return response()->json([
                'status'  => 400,
                'message' => 'Product not found'
            ]);
        }

        if ($data['quantity'] < $product->moq) {
            return response()->json([
                'status'  => 400,
                'message' => "Minimum order quantity for {$product->name} is {$product->moq}."
            ]);
        }

        $cart = Cart::updateOrCreate(
            [
                'user_id'    => $request->user->id,
                'product_id' => $data['product_id']
            ],
            [
                'quantity' => $data['quantity']
            ]
        );

        $cart = Cart::with('product')
                    ->where('user_id', $request->user->id)
                    ->get();

        return response()->json([
            'status'  => 200,
            'message' => 'Cart updated successfully',
            'data'    => $cart
        ]);
    }


    public function decreaseQuantity(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        if ($validated->fails()) {
            return response()->json([
                "status" => 400, 
                "message" => $validated->errors()->first(), 
                "errors" => $validated->errors()
            ]);
        }

        $data = $validated->validated();

        $cart = Cart::where('user_id', $request->user->id)
                    ->where('product_id', $data['product_id'])
                    ->first();

        if (!$cart) {
            return response()->json([
                'status' => 400,
                'message' => 'Product not found in cart'
            ]);
        }

        if ($data['quantity'] >= $cart->quantity) {
            $cart->delete();


            $cart = Cart::with('product')
                    ->where('user_id', $request->user->id)
                    ->get();

            return response()->json([
                'status' => 200,
                'message' => 'Product removed from cart completely',
                'data' => $cart
            ]);
        }

        $cart->quantity -= $data['quantity'];
        $cart->save();

        $cart = Cart::with('product')
                    ->where('user_id', $request->user->id)
                    ->get();

        return response()->json([
            'status' => 200,
            'message' => "Removed {$data['quantity']} quantity from cart",
            'data' => $cart
        ]);
    }



    public function removeFromCart(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id'
        ]);

        if ($validated->fails()) {
            return response()->json([
                "status" => 400, 
                "message" => $validated->errors()->first(), 
                "errors" => $validated->errors()
            ]);
        }

        $data = $validated->validated();

        $cart = Cart::where('user_id', $request->user->id)
                    ->where('product_id', $data['product_id'])
                    ->first();

        if (!$cart) {
            return response()->json([
                'status' => 400,
                'message' => 'Product not found in cart'
            ]);
        }

        $cart->delete();

        $cart = Cart::with('product')
                    ->where('user_id', $request->user->id)
                    ->get();
                    
        return response()->json([
            'status' => 200,
            'message' => 'Product removed from cart',
            'data' => $cart
        ]);
    }

    
    public function emptyCart(Request $request)
    {
        Cart::where('user_id', $request->user->id)->delete();

        $cart = Cart::with('product')
                    ->where('user_id', $request->user->id)
                    ->get();
                    
        return response()->json([
            'status' => 200,
            'message' => 'Cart emptied successfully',
            'data' => $cart
        ]);
    }


    public function viewCart(Request $request)
    {
        $cart = Cart::with('product')
                    ->where('user_id', $request->user->id)
                    ->get();

        return response()->json([
            'status' => 200,
            'message' => 'Get cart data successfully',
            'data' => $cart
        ]);
    }



    public function addToWishlist(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status'  => 400,
                'message' => $validated->errors()->first(),
                'errors' => $validated->errors()
            ]);
        }

        $data = $validated->validated();

        // Prevent duplicate wishlist entry
        $exists = Wishlist::where('user_id', $request->user->id)
                          ->where('product_id', $data['product_id'])
                          ->first();

        if ($exists) {
            return response()->json([
                'status'  => 200,
                'message' => 'Product already in wishlist',
                'data'    => $exists
            ]);
        }

        $data['user_id'] = $request->user->id;
        $data['quantity'] = 1;

        $wishlist = Wishlist::create($data);

        return response()->json([
            'status'  => 201,
            'message' => 'Product added to wishlist',
            'data'    => $wishlist
        ]);
    }


    public function removeFromWishlist(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status'  => 400,
                'message' => $validated->errors()->first(),
                'errors' => $validated->errors()
            ]);
        }

        $data = $validated->validated();

        $wishlist = Wishlist::where('user_id', $request->user->id)
                            ->where('product_id', $data['product_id'])
                            ->first();

        if (!$wishlist) {
            return response()->json([
                'status'  => 400,
                'message' => 'Product not found in wishlist',
            ]);
        }

        $wishlist->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Product removed from wishlist',
        ]);
    }


    public function getWishlist(Request $request)
    {
        $wishlist = Wishlist::where('user_id', $request->user->id)
                            ->with('product') 
                            ->get();

        return response()->json([
            'status'  => 200,
            'message' => 'Wishlist fetched successfully',
            'data'    => $wishlist
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
