<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\SendOtpMail;

use App\Models\User;
use App\Models\Kyc;
use App\Models\Address;
use App\Models\Wallet;
use App\Models\BankDetail;
use App\Models\UserRequest;

use App\Helpers\Helper;

class AuthController extends Controller
{
    // Example: login
    // public function login(Request $request)
    // {
    //     return response()->json(['message' => 'Login endpoint']);
    // }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|regex:/^[5-9]\d{9}$/'
        ], [
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex'    => 'Please enter a valid 10-digit phone number'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors()
            ]);
        }

        $user = User::where('phone_number', $request->phone_number)->first();
        $otp = rand(100000, 999999);
        $otp = 123456;
        $token = Str::random(64);
        if ($user) {

            $userrequest = UserRequest::create([
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $request->phone_number,
                'otp'          => $otp,
                'token'        => $token,
                'hit_count'    => 0,
                'for'          => 'otp',
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Phone number registered.',
                'token' => $userrequest->token,
                'next_screen' => 'otp'
            ]);
        } else {

            $userrequest = UserRequest::create([
                'phone_number' => $request->phone_number,
                'otp'          => $otp,
                'token'        => $token,
                'hit_count'    => 0,
                'for'          => 'registration',
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Phone number not registered.',
                'token' => $userrequest->token,
                'next_screen' => 'registration'
            ]);
        }
    }

    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'token'      => 'required',
            'email'     => 'required|email|unique:users',
            'phone_number'    => 'required|regex:/^[5-9]\d{9}$/|unique:users,phone_number',
        ], [
            'phone_number.unique' => 'Phone number is already registr.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex'    => 'Please enter a valid 10-digit phone number.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors()
            ]);
        }

        $data = UserRequest::where('token', $request->token)->where('phone_number', $request->phone_number)->latest()->first();

        if ($data) {
            if (!empty($data->verify_at)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'otp expired.',
                    'next_screen' => 'login',
                ]);
            }

            $check = UserRequest::where('id', $data->id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            if ($check) {
                return response()->json([
                    'status' => 200,
                    'message' => 'verify phone number.',
                    'token' => $data->token,
                    'next_screen' => 'otp'
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Failed to update user information.',
                    'next_screen' => 'login'
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'invalid token.',
                'next_screen' => 'login'
            ]);
        }
    }


    public function verify_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number'  => 'required|regex:/^[5-9]\d{9}$/',
            'token'         => 'required',
            'otp'           => 'required|digits:6',
        ], [
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex'    => 'Please enter a valid 10-digit phone number'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors()
            ]);
        }

        $data = UserRequest::where('token', $request->token)->where('phone_number', $request->phone_number)->latest()->first();

        if ($data) {
            if (!empty($data->verify_at)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'otp expired.',
                    'next_screen' => $data->for == 'registration' ? 'registration' : 'login'
                ]);
            }

            UserRequest::where('id', $data->id)->update([
                'hit_count' => $data->hit_count + 1
            ]);

            if ($data->hit_count >= 10) {

                return response()->json([
                    'status' => 401,
                    'message' => 'OTP verification failed: Maximum retry limit reached.',
                    'next_screen' => $data->for == 'registration' ? 'registration' : 'login',
                ]);
            }

            if ($data->otp == $request->otp) {

                $user = User::where('phone_number', $request->phone_number)->first();

                if (!$user && $data->for == 'registration') {

                    DB::beginTransaction();

                    try {

                        $code = Helper::getTransId(4);

                        $user = User::create([
                            'code' => $code,
                            'name'      => $data->name,
                            'email'     => $data->email,
                            'phone_number'    => $request->phone_number,
                            'password'  => Hash::make($request->phone_number),
                            'role_id' => 4
                        ]);

                        Kyc::create([
                            'user_id' => $user->id
                        ]);

                        Address::create([
                            'user_id' => $user->id,
                            'type' => 'Home',
                            'default' => 'Yes'
                        ]);

                        Wallet::create([
                            'user_id' => $user->id
                        ]);

                        BankDetail::create([
                            'user_id' => $user->id
                        ]);

                        DB::commit();
                    } catch (\Exception $e) {

                        DB::rollBack();

                        return response()->json([
                            'status' => 401,
                            'message' => 'Something went wrong: ' . $e->getMessage(),
                            'next_screen' => 'registration',
                        ]);
                    }
                }

                // $token = JWTAuth::fromUser($user);
                $token = $user->createToken('mobile', ['*'], now()->addDays(365))->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'message' => 'Login Successfully.',
                    'token' => $token,
                    'user' => $user
                ]);
            }

            return response()->json([
                'status' => 401,
                'message' => 'Please enter valid otp.',
                'next_screen' => 'otp'
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'invalid token.',
                'next_screen' => 'login',
            ]);
        }
    }


    public function login_resend_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'      => 'required',
            'phone_number'    => 'required|regex:/^[5-9]\d{9}$/',
        ], [
            'phone_number.unique' => 'Phone number is already registr.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex'    => 'Please enter a valid 10-digit phone number.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 400,
                "message" => $validator->errors()->first(),
                "errors" => $validator->errors()
            ]);
        }

        $data = UserRequest::where('token', $request->token)->where('phone_number', $request->phone_number)->latest()->first();

        if ($data) {

            if (!empty($data->verify_at)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'otp expired.',
                    'next_screen' => 'login',
                ]);
            }

            $otp = rand(100000, 999999);
            $otp = 123456;
            $check = UserRequest::where('id', $data->id)->update([
                'otp' => $otp,
                'hit_count' => 0,
            ]);

            if ($check) {
                return response()->json([
                    'status' => 200,
                    'message' => 'OTP send successfully.',
                    'token' => $data->token,
                    'next_screen' => 'otp'
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Failed to update user information.',
                    'next_screen' => 'login'
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'invalid token.',
                'next_screen' => 'login'
            ]);
        }
    }
}
