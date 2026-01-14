<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Kyc;
use App\Models\Media;
use App\Models\Professionalusers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Usercontroller extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();
        if (!Auth::check() || !$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ]);
        }
        $data = User::find($request->user()->id);
        return response()->json([
            "status" => 200,
            "data" => $data
        ]);
    }
    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'image'     => 'nullable|image|max:2048',
            'username' =>  'required|string|max:50|unique:users,username,' . Auth::id(),
            'about'     => 'required|string|max:1000',
            'location'  => 'nullable|string|max:255',
            'hobbies' => 'nullable',
            'hobbies.*' => 'string|max:50',
            'media'     => 'required|array',
            'media.*'   => 'file|mimes:jpg,jpeg,png,webp,mp4,mp3,mov,avi|max:204800',
        ]);
        // dd($request->all());
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ]);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ]);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/profile_images'), $filename);
            $user->image = $filename;
        }
        $hobbies = $request->hobbies;

        if (is_string($hobbies)) {
            $hobbies = json_decode($hobbies, true);
        }


        User::updateOrCreate(['id' => $user->id], [
            'name'     => $request->name,
            'username' => $request->username,
            'about'    => $request->about,
            'hobbies'  => $hobbies,
            'image'    => $user->image ?? null
        ],);
        if ($request->filled('location')) {
            Address::updateOrCreate(
                ['user_id' => $user->id],
                ['address' => $request->location]
            );
        }
        if ($request->hasFile('media')) {
            $timestamp = time();
            $uploadPath = public_path('uploads/media');

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach ($request->file('media') as $file) {
                if ($file->isValid()) {
                    $type = str_starts_with($file->getMimeType(), 'video')
                        ? 'video'
                        : 'image';

                    $filename = $timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $filename);
                    $path = 'uploads/media/' . $filename;

                    Media::create([
                        'user_id'   => $user->id,
                        'file_path' => $path,
                        'file_name' => $filename,
                        'file_type' => $type,
                    ]);
                }
            }
        }
        // dd($request->file('media'));
        return response()->json([
            'status' => 200,
            'message' => 'Profile updated successfully',
            'data' => User::with(['address', 'media'])->find($user->id)
        ]);
    }
    public function dashboard(Request $request)
    {
        $request->validate([
            'user_type' => 'nullable|in:personal,professional',
        ]);

        $user = User::with('wallet')->find(Auth::id());

        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ], 401);
        }

        ########### switch profile type ############
        if ($request->filled('user_type')) {
            $user->user_type = $request->user_type;
            $user->save();
        }

        if ($user->user_type === 'professional') {

            $professionalProfile = Professionalusers::where('user_id', $user->id)->first();

            return response()->json([
                'type' => 'professional',
                'user' => $professionalProfile,
                'wallet' => $user->wallet,
            ]);
        }

        return response()->json([
            'type' => 'personal',
            'user' => $user,
        ]);
    }
    public function update_professional_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'about' => 'required|string|max:1000',
            'skills' => 'required|array',
            'skills.*' => 'string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ]);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ]);
        }

        Professionalusers::updateOrCreate(
            ['user_id' => $user->id],
            [
                'title' => $request->title,
                'about' => $request->about,
                'skills' => $request->skills,
            ]
        );

        return response()->json([
            'status' => 200,
            'message' => 'Professional profile updated successfully',
            'data' => Professionalusers::where('user_id', $user->id)->first(),
        ]);
    }
    public function sendAadhaarOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aadhar_number' => 'required|digits:12'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        if (Kyc::where('aadhar_number', $request->aadhar_number)->where('status', 'Verified')->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Aadhaar number already verified'
            ], 422);
        }
        $otp = 123456;

        Kyc::updateOrCreate(
            ['user_id' => $user->id],
            [
                'aadhar_number' => $request->aadhar_number,
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
                'status' => 'Pending',
                'remarks' => null
            ]
        );
        return response()->json([
            'status' => true,
            'message' => 'OTP sent to Aadhaar registered mobile number'
        ]);
    }

    public function verifyAadhaarOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $kyc = Kyc::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('otp_expires_at', '>', now())
            ->first();

        if (!$kyc) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired OTP'
            ], 422);
        }

        $kyc->update([
            'status' => 'Verified',
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Aadhaar verified successfully'
        ]);
    }

    public function sendPanOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pan_number' => [
                'required',
                'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        if (Kyc::where('pan_number', strtoupper($request->pan_number))->where('pan_status', 'Verified')->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'PAN number already verified'
            ], 422);
        }
        $otp = rand(100000, 999999);
        $otp = 123456;

        Kyc::updateOrCreate(
            ['user_id' => $user->id],
            [
                'pan_number' => strtoupper($request->pan_number),
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10),
                'pan_status' => 'Pending',
                'remarks' => null
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'OTP sent to PAN registered mobile number',
            'otp' => $otp
        ]);
    }
    public function verifyPanOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        $kyc = Kyc::where('user_id', $user->id)->first();

        if (!$kyc) {
            return response()->json([
                'status' => false,
                'message' => 'KYC record not found'
            ]);
        }

        $kyc = Kyc::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->where('otp_expires_at', '>', now())
            ->first();

        if (!$kyc) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired OTP'
            ], 200);
        }

        $kyc->update([
            'otp' => null,
            'otp_expires_at' => null,
            'pan_status' => 'Verified'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'PAN verified successfully'
        ]);
    }
}
