<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FundRequest;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use App\Models\Lead;
use Carbon\Carbon;

class DashboardController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        if($user->roles->type == "Admin") { 
            $main_balance = Wallet::sum('main_balance');

            $orders = Order::latest()->limit(5)->get();
            $orderCount = Order::count();
            $orderLastCount = Order::where('created_at', '>=', Carbon::now()->subWeek())->count();
            $totalRevenue = 0;//Order::where('payment_status_id', 2)->sum('final_amount_with_tax');
            $totalRevenueLast = 0;//Order::where('payment_status_id', 2)->where('created_at', '>=', now()->subWeek())->sum('final_amount_with_tax');
            $totalCommission = Order::where('payment_status_id', 2)->sum('commision');
            $totalCommissionLast = Order::where('created_at', '>=', now()->subWeek())->sum('commision');

            $fundRequestCount = FundRequest::selectRaw("
                    SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) AS Approved,
                    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS Pending,
                    SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) AS Rejected
                ")->first();

            $userCount = User::selectRaw("
                    SUM(CASE WHEN role_id = 2 THEN 1 ELSE 0 END) AS Sales,
                    SUM(CASE WHEN role_id = 3 THEN 1 ELSE 0 END) AS Support,
                    SUM(CASE WHEN role_id = 5 THEN 1 ELSE 0 END) AS Associate
                ")->first();

            
            $leadCount = Lead::selectRaw("
                    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS Pending,
                    SUM(CASE WHEN status = 'Prospecting' THEN 1 ELSE 0 END) AS Prospecting,
                    SUM(CASE WHEN status = 'Converted' THEN 1 ELSE 0 END) AS Converted,
                    SUM(CASE WHEN status = 'Closed' THEN 1 ELSE 0 END) AS Closed
                ")->first();        

            $orderStatusCount = Order::selectRaw("
                    SUM(CASE WHEN order_status_id = 1 THEN 1 ELSE 0 END) AS Pending,
                    SUM(CASE WHEN order_status_id = 2 THEN 1 ELSE 0 END) AS Confirm,
                    SUM(CASE WHEN order_status_id = 3 THEN 1 ELSE 0 END) AS VisitVerification,
                    SUM(CASE WHEN order_status_id = 4 THEN 1 ELSE 0 END) AS Documentation,
                    SUM(CASE WHEN order_status_id = 5 THEN 1 ELSE 0 END) AS PartsDelivered,
                    SUM(CASE WHEN order_status_id = 6 THEN 1 ELSE 0 END) AS Installation,
                    SUM(CASE WHEN order_status_id = 7 THEN 1 ELSE 0 END) AS Netmeeting,
                    SUM(CASE WHEN order_status_id = 8 THEN 1 ELSE 0 END) AS Completed,
                    SUM(CASE WHEN order_status_id = 9 THEN 1 ELSE 0 END) AS Cancelled
                ")->first();

        } else {

            $main_balance = Wallet::where('user_id', $user->id)->sum('main_balance');

            $orders = Order::where('order_by_id', $user->id)->latest()->limit(5)->get();
            $orderCount = Order::where('order_by_id', $user->id)->count();
            $orderLastCount = Order::where('order_by_id', $user->id)->where('created_at', '>=', Carbon::now()->subWeek())->count();

            $totalRevenue = 0;//Order::where('order_by_id', $user->id)->where('payment_status_id', 2)->sum('final_amount_with_tax');
            $totalRevenueLast = 0;//Order::where('order_by_id', $user->id)->where('payment_status_id', 2)->where('created_at', '>=', now()->subWeek())->sum('final_amount_with_tax');
            $totalCommission = Order::where('order_by_id', $user->id)->where('payment_status_id', 2)->sum('commision');
            $totalCommissionLast = Order::where('order_by_id', $user->id)->where('created_at', '>=', now()->subWeek())->sum('commision');

  
            $fundRequestCount = FundRequest::where('from_user_id', $user->id)->where('to_user_id', $user->id)->selectRaw("
                    SUM(CASE WHEN status = 'Approved' THEN 1 ELSE 0 END) AS Approved,
                    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS Pending,
                    SUM(CASE WHEN status = 'Rejected' THEN 1 ELSE 0 END) AS Rejected
                ")->first();

                $userCount = User::selectRaw("
                    SUM(CASE WHEN role_id = 2 THEN 1 ELSE 0 END) AS Sales,
                    SUM(CASE WHEN role_id = 3 THEN 1 ELSE 0 END) AS Support,
                    SUM(CASE WHEN role_id = 5 THEN 1 ELSE 0 END) AS Associate
                ")->first();

             if ($user->role_id == 5) {

                $leadCount = Lead::where(function ($q) use ($user) {
                        $q->where('created_by', $user->id)
                          ->orWhere('assigned_to', $user->id)
                          ->orWhere('associate_id', $user->id)
                          ->orWhere(function ($sub) {
                              $sub->whereNull('associate_id')
                                  ->whereNotNull('lead_price');
                          });
                    })
                    ->selectRaw("
                        SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS Pending,
                        SUM(CASE WHEN status = 'Prospecting' THEN 1 ELSE 0 END) AS Prospecting,
                        SUM(CASE WHEN status = 'Converted' THEN 1 ELSE 0 END) AS Converted,
                        SUM(CASE WHEN status = 'Closed' THEN 1 ELSE 0 END) AS Closed
                    ")
                    ->first();

            } else {

                $leadCount = Lead::where(function ($q) use ($user) {
                        $q->where('assigned_to', $user->id)
                          ->orWhere('created_by', $user->id);
                    })
                    ->selectRaw("
                        SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS Pending,
                        SUM(CASE WHEN status = 'Prospecting' THEN 1 ELSE 0 END) AS Prospecting,
                        SUM(CASE WHEN status = 'Converted' THEN 1 ELSE 0 END) AS Converted,
                        SUM(CASE WHEN status = 'Closed' THEN 1 ELSE 0 END) AS Closed
                    ")
                    ->first();
            }

            
             

            $orderStatusCount = Order::where('order_by_id', $user->id)->selectRaw("
                    SUM(CASE WHEN order_status_id = 1 THEN 1 ELSE 0 END) AS Pending,
                    SUM(CASE WHEN order_status_id = 2 THEN 1 ELSE 0 END) AS Confirm,
                    SUM(CASE WHEN order_status_id = 3 THEN 1 ELSE 0 END) AS VisitVerification,
                    SUM(CASE WHEN order_status_id = 4 THEN 1 ELSE 0 END) AS Documentation,
                    SUM(CASE WHEN order_status_id = 5 THEN 1 ELSE 0 END) AS PartsDelivered,
                    SUM(CASE WHEN order_status_id = 6 THEN 1 ELSE 0 END) AS Installation,
                    SUM(CASE WHEN order_status_id = 7 THEN 1 ELSE 0 END) AS Netmeeting,
                    SUM(CASE WHEN order_status_id = 8 THEN 1 ELSE 0 END) AS Completed,
                    SUM(CASE WHEN order_status_id = 9 THEN 1 ELSE 0 END) AS Cancelled
                ")->first();

        }

        return view('admin.dashboard.dashboard', compact('main_balance','orders','orderCount','orderLastCount','totalRevenue','totalRevenueLast','totalCommission','totalCommissionLast','fundRequestCount','userCount','leadCount','orderStatusCount'));
    }
}
