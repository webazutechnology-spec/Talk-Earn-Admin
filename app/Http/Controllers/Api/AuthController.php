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
use OpenApi\Attributes as OA;

use App\Helpers\Helper;

class AuthController extends BaseController
{

    #[OA\Post(
        path: '/login',
        operationId: 'loginUser',
        summary: 'Login or Register using Phone Number',
        description: 'Checks if the phone number exists. If registered, sends OTP for login. If not registered, sends OTP for registration.',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['phone_number'],
                properties: [
                    new OA\Property(
                        property: 'phone_number',
                        type: 'string',
                        example: '9918829937',
                        description: 'Valid 10-digit Indian phone number starting from 5-9'
                    )
                ]
            )
        ),
        responses: [

            new OA\Response(
                response: 200,
                description: 'OTP sent successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Phone number registered.'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'token', type: 'string', example: 'uuid-token'),
                                new OA\Property(property: 'next_screen', type: 'string', example: 'otp'),
                            ]
                        )
                    ]
                )
            ),

            new OA\Response(
                response: 422,
                description: 'Validation Error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Phone number is required.'),
                        new OA\Property(property: 'errors', type: 'object')
                    ]
                )
            )
        ]
    )]
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|regex:/^[5-9]\d{9}$/'
        ], [
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex'    => 'Please enter a valid 10-digit phone number'
        ]);

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first(),
                $validator->errors()->toArray(),
                422
            );
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        $otp = rand(100000, 999999);
        $otp = 123456; 

        $token = Str::uuid()->toString();

        if ($user) {

            $userrequest = UserRequest::create([
                'reg_code'       => $user->code,
                'name'           => $user->name,
                'email'          => $user->email,
                'phone_number'   => $request->phone_number,
                'phonecode'      => 91,
                'otp'            => $otp,
                'token'          => $token,
                'referral_id'    => 1,
                'otp_expires_at' => now()->addMinutes(5),
                'hit_count'      => 0,
                'for'            => 'otp',
                'otp_verified_at' => null,
            ]);

            return $this->success(
                'Phone number registered.',
                [
                    'token' => $userrequest->token,
                    'next_screen' => 'otp'
                ]
            );
        }

        // If user not exists → registration flow
        $userrequest = UserRequest::create([
            'reg_code'       => 'NA',
            'name'           => 'NA',
            'email'          => 'NA',
            'phone_number'   => $request->phone_number,
            'phonecode'      => 91,
            'otp'            => $otp,
            'token'          => $token,
            'referral_id'    => 1,
            'otp_expires_at' => now()->addMinutes(5),
            'hit_count'      => 0,
            'for'            => 'registration',
            'otp_verified_at' => null,
        ]);

        return $this->success(
            'Phone number not registered.',
            [
                'token' => $userrequest->token,
                'next_screen' => 'registration'
            ]
        );
    }

    #[OA\Post(
        path: '/registration',
        operationId: 'registerUser',
        summary: 'Complete user registration',
        description: 'Registers a new user after login OTP request. Referral ID is optional but must exist if provided.',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name','email','phone_number','token'],
                properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'John Doe',
                        description: 'Full name of the user'
                    ),
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        example: 'john@example.com',
                        description: 'Valid unique email address'
                    ),
                    new OA\Property(
                        property: 'phone_number',
                        type: 'string',
                        example: '9918829937',
                        description: 'Valid 10-digit Indian phone number starting from 5-9'
                    ),
                    new OA\Property(
                        property: 'token',
                        type: 'string',
                        example: 'random-uuid-token',
                        description: 'Token received from login API'
                    ),
                    new OA\Property(
                        property: 'referral_id',
                        type: 'integer',
                        example: 12,
                        nullable: true,
                        description: 'Optional referral user ID'
                    ),
                ]
            )
        ),
        responses: [

            new OA\Response(
                response: 200,
                description: 'Registration data saved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'integer', example: 200),
                        new OA\Property(property: 'message', type: 'string', example: 'Please verify OTP.'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'token', type: 'string', example: 'random-uuid-token'),
                                new OA\Property(property: 'next_screen', type: 'string', example: 'otp'),
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'integer', example: 422),
                        new OA\Property(property: 'message', type: 'string', example: 'Invalid referral ID.'),
                        new OA\Property(property: 'errors', type: 'object')
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized or expired token',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'integer', example: 401),
                        new OA\Property(property: 'message', type: 'string', example: 'Invalid token.')
                    ]
                )
            ),
        ]
    )]
    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'token'        => 'required',
            'email'        => 'required|email|unique:users,email',
            'phone_number' => 'required|regex:/^[5-9]\d{9}$/|unique:users,phone_number',
            'referral_id'  => 'nullable|exists:users,id',
        ], [
            'phone_number.unique'   => 'Phone number is already registered.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex'    => 'Please enter a valid 10-digit phone number.',
            'referral_id.exists'    => 'Invalid referral ID.'
        ]);

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first(),
                $validator->errors()->toArray(),
                422
            );
        }

        $data = UserRequest::where('token', $request->token)
            ->where('phone_number', $request->phone_number)
            ->where('for', 'registration')
            ->latest()
            ->first();

        if (!$data) {
            return $this->error('Invalid token.', [], 401);
        }

        if ($data->otp_expires_at && $data->otp_expires_at < now()) {
            return $this->error('OTP expired. Please login again.', [], 401);
        }

        if (!empty($data->otp_verified_at)) {
            return $this->error('Token already used.', [], 401);
        }

        // Prevent self-referral
        if ($request->referral_id && $request->referral_id == $data->reg_code) {
            return $this->error('You cannot use your own referral.', [], 422);
        }

        $data->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'role'        => 4,
            'referral_id' => $request->referral_id ?? 1
        ]);

        return $this->success(
            'Please verify OTP.',
            [
                'token' => $data->token,
                'next_screen' => 'otp'
            ]
        );
    }


    #[OA\Post(
        path: '/verify-otp',
        operationId: 'verifyOtp',
        summary: 'Verify OTP for login or registration',
        description: 'Verifies the OTP sent to the phone number for either login or completing registration.',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['phone_number', 'token', 'otp'],
                properties: [
                    new OA\Property(
                        property: 'phone_number',
                        type: 'string',
                        example: '9918829937',
                        description: 'Valid 10-digit Indian phone number'
                    ),
                    new OA\Property(
                        property: 'token',
                        type: 'string',
                        example: 'uuid-token',
                        description: 'Token received from login or registration API'
                    ),
                    new OA\Property(
                        property: 'otp',
                        type: 'string',
                        example: '123456',
                        description: '6-digit OTP'
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'OTP verified successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Login Successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'token', type: 'string', example: 'sanctum-token'),
                                new OA\Property(property: 'user', type: 'object', description: 'User object'),
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation Error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Phone number is required.'),
                        new OA\Property(property: 'errors', type: 'object')
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized or invalid request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Invalid token.')
                    ]
                )
            )
        ]
    )]
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
            return $this->error(
                $validator->errors()->first(),
                $validator->errors()->toArray(),
                422
            );
        }

        $data = UserRequest::where('token', $request->token)->where('phone_number', $request->phone_number)->latest()->first();

        if (!$data) {
            return $this->error('Invalid token.', [], 401);
        }

        if (!empty($data->otp_verified_at)) {
            return $this->error('OTP already verified.', [], 401);
        }

        if ($data->otp_expires_at && $data->otp_expires_at < now()) {
            return $this->error('OTP expired.', [], 401);
        }

        $data->update([
            'hit_count' => $data->hit_count + 1
        ]);

        if ($data->hit_count > 10) {
            return $this->error('OTP verification failed: Maximum retry limit reached.', [], 401);
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

                        return $this->error('Something went wrong: ' . $e->getMessage(), [], 500);
                    }
                }

                if (!$user) {
                    return $this->error('User not found.', [], 401);
                }

                $data->update(['otp_verified_at' => now()]);

                $token = $user->createToken('mobile', ['*'], now()->addDays(365))->plainTextToken;

                return $this->success(
                    'Login Successfully.',
                    [
                        'token' => $token,
                        'user' => $user
                    ]
                );
            }

        return $this->error('Please enter valid otp.', [], 401);
    }


    #[OA\Post(
        path: '/resend-otp',
        operationId: 'resendOtp',
        summary: 'Resend OTP for login or registration',
        description: 'Resends the OTP to the phone number if the token is valid and OTP has not been verified yet.',
        tags: ['Authentication'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['phone_number', 'token'],
                properties: [
                    new OA\Property(
                        property: 'phone_number',
                        type: 'string',
                        example: '9918829937',
                        description: 'Valid 10-digit Indian phone number'
                    ),
                    new OA\Property(
                        property: 'token',
                        type: 'string',
                        example: 'uuid-token',
                        description: 'Token received from login or registration API'
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'OTP resent successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'OTP send successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'token', type: 'string', example: 'uuid-token'),
                                new OA\Property(property: 'next_screen', type: 'string', example: 'otp'),
                            ]
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation Error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Phone number is required.'),
                        new OA\Property(property: 'errors', type: 'object')
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized or invalid request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Invalid token.')
                    ]
                )
            )
        ]
    )]
    public function resend_otp(Request $request)
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
            return $this->error(
                $validator->errors()->first(),
                $validator->errors()->toArray(),
                422
            );
        }

        $data = UserRequest::where('token', $request->token)->where('phone_number', $request->phone_number)->latest()->first();

        if ($data) {

            if (!empty($data->otp_verified_at)) {
                return $this->error('OTP already verified.', [], 401);
            }

            $otp = rand(100000, 999999);
            $otp = 123456;
            $check = UserRequest::where('id', $data->id)->update([
                'otp' => $otp,
                'hit_count' => 0,
            ]);

            if ($check) {
                return $this->success(
                    'OTP send successfully.',
                    [
                        'token' => $data->token,
                        'next_screen' => 'otp'
                    ]
                );
            } else {
                return $this->error('Failed to update user information.', [], 500);
            }
        } else {
            return $this->error('Invalid token.', [], 401);
        }
    }
}
