<?php

namespace App\Http\Controllers;
use App\Notifications\NewOrderNotification;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Models\ActivityLog;
use App\Models\LoginLog;
use App\Models\User;

use App\Helpers\Helper;
use Carbon\Carbon;

class UserController extends Controller
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
    public function profile()
    {
        return view('admin.user.profile');
    }

    public function profileUpdate(Request $request)
    {   
        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id); 

        $check = $user->update([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'dob' => $request->dob
        ]);

        if ($check) {
                return redirect()->route('profile')->with(['success'=> 'profile update Successfully,']);
        } else {
                return redirect()->route('profile')->with(['error'=> 'profile Not update.']);
        }
    }

    public function profileUploadImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|max:2048',
        ]);

        $file = $request->file('profile_image');
        $filename = 'profile_' . auth()->user()->code . '_' .time().'_'.$file->getClientOriginalExtension();
        $file->move(public_path('images/profile'), $filename);

        auth()->user()->update([
            'profile_image' => $filename
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }

    
    public function security()
    {
        $sessions = DB::table('sessions')
            ->where('user_id', auth()->id())
            ->orderBy('last_activity', 'DESC')
            ->get()
            ->map(function ($session) {

                $agent = new Agent();
                $agent->setUserAgent($session->user_agent);

                // Get the session's last activity timestamp
                $lastActivity = Carbon::createFromTimestamp($session->last_activity);

                // Get the session lifetime from config (default is 120 minutes)
                $sessionLifetime = config('session.lifetime'); 

                // Calculate session expiry time
                $expiryTime = $lastActivity->addMinutes($sessionLifetime);

                // Determine if session has expired
                $isExpired = Carbon::now()->gt($expiryTime);

                // If the session is expired, delete it
                if ($isExpired) {
                    DB::table('sessions')->where('id', $session->id)->delete();
                }

                return [
                    'id'          => $session->id,
                    'ip'          => $session->ip_address,
                    'browser'     => $agent->browser(),
                    'browser_ver' => $agent->version($agent->browser()),
                    'os'          => $agent->platform(),
                    'os_ver'      => $agent->version($agent->platform()),
                    'device'      => $agent->device(),
                    'is_phone'    => $agent->isPhone(),
                    'is_desktop'  => $agent->isDesktop(),
                    'last_active' => $lastActivity->diffForHumans(),
                    'is_current'  => $session->id === session()->getId(),
                    'is_expired'  => $isExpired, // Added expiry status
                ];
            });

        return view('admin.user.chnage-password', compact('sessions'));
    }


    public function loginActivity(Request $request)
    {
        $user_id = auth()->user()->id;
        $query = LoginLog::with('user')->where('user_id', $user_id)->withTrashed(); 

        // Default date range (last 3 month)
        $default_from = now()->subMonths(3)->startOfDay()->toDateString();
        $default_to   = now()->endOfDay()->toDateString();
        // Merge defaults only if user did NOT provide values
        $request->merge([
            'created_at_from' => $request->created_at_from ?? $default_from,
            'created_at_to'   => $request->created_at_to   ?? $default_to,
        ]);

        if ($request->has('created_at_from') && $request->created_at_from != '') {
            $query->whereDate('created_at', '>=', $request->created_at_from);
        }

        if ($request->has('created_at_to') && $request->created_at_to != '') {
            $query->whereDate('created_at', '<=', $request->created_at_to);
        }

        $data = $query->get()->map(function ($log) {

                $agent = new Agent();
                $agent->setUserAgent($log->device_info);

                return [
                    'id'          => $log->id,
                    'user_image'  => $log->user->image,
                    'user_name'   => $log->user->name,
                    'user_code'   => $log->user->code,
                    'user_gender' => $log->user->gender,
                    'ip'          => $log->ip_address,
                    'request'     => $log->request,
                    'server'      => $log->server,
                    'browser'     => $agent->browser(),
                    'browser_ver' => $agent->version($agent->browser()),
                    'os'          => $agent->platform(),
                    'os_ver'      => $agent->version($agent->platform()),
                    'device'      => $agent->device(),
                    'is_phone'    => $agent->isPhone(),
                    'is_desktop'  => $agent->isDesktop(),
                    'location'    => $log->location,
                    'created_at'  => $log->created_at,
                    'updated_at'  => $log->updated_at,
                ];
            });

        return view('admin.user.login-log', compact('data'));
    }
    
    
    public function activityLog(Request $request)
    {
        $user_id = auth()->user()->id;
        $query = ActivityLog::with('user')->where('user_id', $user_id)->withTrashed(); 

        // Default date range (last 3 month)
        $default_from = now()->subMonths(3)->startOfDay()->toDateString();
        $default_to   = now()->endOfDay()->toDateString();

        // Merge defaults only if user did NOT provide values
        $request->merge([
            'created_at_from' => $request->created_at_from ?? $default_from,
            'created_at_to'   => $request->created_at_to   ?? $default_to,
        ]);

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('created_at_from') && $request->created_at_from != '') {
            $query->whereDate('created_at', '>=', $request->created_at_from);
        }

        if ($request->has('created_at_to') && $request->created_at_to != '') {
            $query->whereDate('created_at', '<=', $request->created_at_to);
        }

        $data = $query->get();

        return view('admin.user.activity', compact('data'));
    }

    public function notifications(Request $request)
    {
        $user_id = auth()->user()->id;
        $query = ActivityLog::where('user_id', $user_id)->withTrashed(); 

        // Default date range (last 3 month)
        $default_from = now()->subMonths(3)->startOfDay()->toDateString();
        $default_to   = now()->endOfDay()->toDateString();

        // Merge defaults only if user did NOT provide values
        $request->merge([
            'created_at_from' => $request->created_at_from ?? $default_from,
            'created_at_to'   => $request->created_at_to   ?? $default_to,
        ]);

        if ($request->has('created_at_from') && $request->created_at_from != '') {
            $query->whereDate('created_at', '>=', $request->created_at_from);
        }

        if ($request->has('created_at_to') && $request->created_at_to != '') {
            $query->whereDate('created_at', '<=', $request->created_at_to);
        }

        $query->where('notification_show', 'Yes');
        
        // Execute query
        $data = $query->get();

        return view('admin.user.notification', compact('data'));
    }


    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }

    // 1. Save the token from the frontend
    public function updateToken(Request $request)
    {
        $request->validate(['token' => 'required']);

        auth()->user()->update(['fcm_token' => $request->token]);

        return response()->json(['message' => 'Token updated successfully']);
    }

    // 2. Send Notification (Server-side)
    public function sendNotification(Request $request)
    {
        $user = auth()->user();

    //     $check = Helper::send_fcm_notification(
    //         $user, 
    //         "Order Shipped!", 
    //         "Your order #{1} is on the way.", 
    //         url("/orders/{1}")
    //     );
    //    dd($check);
    }
    
}
