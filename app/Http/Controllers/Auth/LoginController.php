<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\LoginLog;
use App\Helpers\Helper;

// usually this is hidden inside 'use AuthenticatesUsers;'

class LoginController extends Controller
{
        /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // -------------------------------------------------------
    // 1. SHOW LOGIN FORM
    // -------------------------------------------------------
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // -------------------------------------------------------
    // 2. MAIN LOGIN ACTION
    // -------------------------------------------------------
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    // -------------------------------------------------------
    // 3. VALIDATE THE REQUEST
    // -------------------------------------------------------
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    // -------------------------------------------------------
    // 4. ATTEMPT TO LOGIN (Check DB)
    // -------------------------------------------------------
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    // -------------------------------------------------------
    // 5. GET CREDENTIALS (Email & Password)
    // -------------------------------------------------------
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    // -------------------------------------------------------
    // 6. SEND SUCCESS RESPONSE
    // -------------------------------------------------------
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new \Illuminate\Http\JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    // -------------------------------------------------------
    // 7. AUTHENTICATED (Hook for custom logic)
    // -------------------------------------------------------
    // The user has been authenticated. Use this to do something *after* login
    // like updating a 'last_login_at' timestamp.
    protected function authenticated(Request $request, $user)
    {
        LoginLog::create([
            'user_id'       => $user->id,
            'user_type'     => 'User', // or class_basename($user)
            'request'       => json_encode($request->except(['password', '_token'])), // Don't save password!
            'server'        => json_encode($request->server()),
            'ip_address'    => $request->ip(),
            'location'      => null, // Requires an external GeoIP package to fill this
            'last_activity' => null,
        ]);

        Helper::logActivity([
            'type'          => 'Insert',
            'title'         => "Login Account",
            'message'       => "You account logged in successfully",
            'route_name'    => 'login',
            'old_data'      => $user,
            'form_data'     => $request->all(),
            'ref_id'        => $user->id,
            'show'          => 'Yes',
        ]);
    }

    // -------------------------------------------------------
    // 8. SEND FAILED RESPONSE
    // -------------------------------------------------------
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    // -------------------------------------------------------
    // 9. GET USERNAME COLUMN
    // -------------------------------------------------------
    // Change this return value to 'username' if you want to login with username instead of email
    public function username()
    {
        return 'email';
    }

    // -------------------------------------------------------
    // 10. LOGOUT
    // -------------------------------------------------------
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new \Illuminate\Http\JsonResponse([], 204)
            : redirect('/');
    }

    // -------------------------------------------------------
    // 11. LOGGED OUT (Hook)
    // -------------------------------------------------------
    protected function loggedOut(Request $request)
    {
        // Default is empty
    }

    // -------------------------------------------------------
    // 12. GET GUARD
    // -------------------------------------------------------
    protected function guard()
    {
        return Auth::guard();
    }
}