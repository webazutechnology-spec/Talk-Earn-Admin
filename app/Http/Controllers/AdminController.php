<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\WithdrawRequest;
use App\Models\FundRequest;
use App\Models\CompanyBank;
use App\Models\ActivityLog;
use App\Models\LoginLog;
use App\Models\Countrie;
use App\Models\BankDetail;
use App\Models\Address;
use App\Models\Ledger;
use App\Models\State;
use App\Models\Citie;
use App\Models\User;
use App\Models\Role;
use App\Models\Wallet;
use App\Models\Kyc;

class AdminController extends Controller
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
        return view('home');
    }

    
    public function clients(Request $request)
    {
        $clients = User::withTrashed()->whereHas('roles', function($query) {
                                        $query->where('type', 'User');
                                    });

        // Deleted clients (soft deleted)
        $deleted = (clone $clients)->onlyTrashed()->count();

        // Deleted clients (soft deleted)
        $notDeleted = (clone $clients)->withoutTrashed()->count();

        // Registered this month (only not deleted)
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        $thisMonth = (clone $clients)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        
        $total = (clone $clients)->count();

        $data = (clone $clients)->get();
        
        return view('admin.user.clients.list', compact('data','total','deleted','notDeleted','thisMonth'));
    }


    public function clientAdd()
    {
        $roles = Role::where('type', 'User')->get();
        $countrie = Countrie::orderBy('name', 'asc')->get();
        $country_id = $countrie[0]->id??'';
        return view('admin.user.clients.create', compact('roles','countrie','country_id'));
    }


    public function clientStore(Request $request)
    {
        $request->merge(['code' => Helper::getTransId(4)]);

        $validated = $request->validate([
            'code' => 'required|string|unique:users,code',
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'required|in:Male,Female,Other',
            'role_id' => 'required|integer|exists:roles,id',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20|unique:users,phone_number',
            'full_address' => 'nullable|string|max:500',
            'country' => 'nullable|integer|exists:countries,id',
            'state' => 'nullable|integer|exists:states,id',
            'city' => 'nullable|integer|exists:cities,id',
            'zip' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_image_front' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_image_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pan_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_number' => 'nullable|string|max:20',
            'pan_number' => 'nullable|string|max:20',
            'terms' => 'accepted',
            'password' => 'required|string|min:6|confirmed',
        ]);


        DB::beginTransaction();

        try {

            $timestamp = now()->format('YmdHis');

            // Profile image (optional)
            $profileFileName = null;
            if ($request->hasFile('profile_image')) {
                $profileFile = $request->file('profile_image');
                $profileFileName = 'profile_' . $request->code . '_' . $timestamp . '.' . $profileFile->getClientOriginalExtension();
                $profileFile->move(public_path('images/profile'), $profileFileName);
            }

            // Aadhar front (optional)
            $aadharFrontName = null;
            if ($request->hasFile('aadhar_image_front')) {
                $aadharFrontFile = $request->file('aadhar_image_front');
                $aadharFrontName = 'aadhar_front_' . $request->code . '_' . $timestamp . '.' . $aadharFrontFile->getClientOriginalExtension();
                $aadharFrontFile->move(public_path('images/user/aadhar'), $aadharFrontName);
            }

            // Aadhar back (optional)
            $aadharBackName = null;
            if ($request->hasFile('aadhar_image_back')) {
                $aadharBackFile = $request->file('aadhar_image_back');
                $aadharBackName = 'aadhar_back_' . $request->code . '_' . $timestamp . '.' . $aadharBackFile->getClientOriginalExtension();
                $aadharBackFile->move(public_path('images/user/aadhar'), $aadharBackName);
            }

            // PAN image (optional)
            $panFileName = null;
            if ($request->hasFile('pan_image')) {
                $panFile = $request->file('pan_image');
                $panFileName = 'pan_' . $request->code . '_' . $timestamp . '.' . $panFile->getClientOriginalExtension();
                $panFile->move(public_path('images/user/pan'), $panFileName);
            }

            
            $user = User::create([
                'code' => $request->code,
                'name' => $request->name,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'image' => $profileFileName
            ]);

            Kyc::create([
                'user_id' => $user->id,
                'aadhar_number' => $request->aadhar_number,
                'pan_number' => $request->pan_number,
                'aadhar_image_front' => $aadharFrontName,
                'aadhar_image_back' => $aadharBackName,
                'pan_image' => $panFileName
            ]);
            
            Address::create([
                'user_id' => $user->id,
                'type' => 'Home',
                'address'   => $request->full_address,
                'city_id' => $request->city,
                'state_id' => $request->state,
                'country_id' => $request->country,
                'zip' => $request->zip,
                'default' => 'Yes'
            ]);

            Wallet::create([
                'user_id' => $user->id
            ]);

            BankDetail::create([
                'user_id' => $user->id
            ]);

            DB::commit();

            Helper::logActivity([
                'type'          => 'Insert',
                'title'         => "create new client",
                'message'       => "New Client created successfully",
                'route_name'    => $request->route()->getName(),
                'old_data'      => $user,
                'form_data'     => $request->all(),
                'ref_id'        => $user->id,
                'show'          => 'No',
            ]);

            return redirect()->route('clients')->with('success', 'Client created successfully!');

        } catch (\Exception $e) {

            DB::rollBack();

            if ($profileFileName && file_exists(public_path('images/profile/'.$profileFileName))) { unlink(public_path('images/profile/'.$profileFileName)); }
            if ($aadharFrontName && file_exists(public_path('images/user/aadhar/'.$aadharFrontName))) { unlink(public_path('images/user/aadhar/'.$aadharFrontName)); }
            if ($aadharBackName && file_exists(public_path('images/user/aadhar/'.$aadharBackName))) { unlink(public_path('images/user/aadhar/'.$aadharBackName)); }
            if ($panFileName && file_exists(public_path('images/user/pan/'.$panFileName))) { unlink(public_path('images/user/pan/'.$panFileName)); }

            return redirect()->route('clients')->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

        return redirect()->route('clients')->with('success', 'Client added successfully!');
    }

    
    public function clientEdit($id)
    {    
        $data = User::findOrFail($id); 
        $address = Address::where('user_id', $id)->first();
        $kyc = Kyc::where('user_id', $id)->first();
           
        $roles = Role::where('type', 'User')->get();
        $countrie = Countrie::orderBy('name', 'asc')->get();
        $country_id = $address->country_id??'';
        $states = [];
        $cities = [];
        if(!empty($country_id)) {
            $states = State::where(['country_id' => $country_id])->orderBy('name', 'asc')->get();
        }
        if(!empty($address->state_id)) {
            $cities = Citie::where(['state_id' => $address->state_id])->orderBy('name', 'asc')->get();
        }
        

        return view('admin.user.clients.edit', compact('data','address','kyc','roles','countrie','country_id','states','cities'));
    }


    public function clientUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'required|in:Male,Female,Other',
            'role_id' => 'required|integer|exists:roles,id',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required|string|max:20|unique:users,phone_number,' . $id,
            'full_address' => 'nullable|string|max:500',
            'country' => 'nullable|integer|exists:countries,id',
            'state' => 'nullable|integer|exists:states,id',
            'city' => 'nullable|integer|exists:cities,id',
            'zip' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_image_front' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_image_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pan_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_number' => 'nullable|string|max:20',
            'pan_number' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();

        try {

            $timestamp = now()->format('YmdHis');
            $code = $user->code;

            /*---------------------------------------------------
                HANDLE PROFILE IMAGE (IF UPDATED)
            ----------------------------------------------------*/
            if ($request->hasFile('profile_image')) {

                if ($user->image && file_exists(public_path('images/profile/'.$user->image))) {
                    unlink(public_path('images/profile/'.$user->image));
                }

                $profileFile = $request->file('profile_image');
                $profileName = 'profile_' . $code . '_' . $timestamp . '.' . $profileFile->getClientOriginalExtension();
                $profileFile->move(public_path('images/profile'), $profileName);
                $user->image = $profileName;
            }

            /*---------------------------------------------------
                HANDLE KYC IMAGES
            ----------------------------------------------------*/
            $kyc = Kyc::where('user_id', $user->id)->first();

            if ($request->hasFile('aadhar_image_front')) {
                if ($kyc->aadhar_front_image && file_exists(public_path('images/user/aadhar/'.$kyc->aadhar_front_image))) {
                    unlink(public_path('images/user/aadhar/'.$kyc->aadhar_front_image));
                }

                $file = $request->file('aadhar_image_front');
                $newName = 'aadhar_front_' . $code . '_' . $timestamp . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/user/aadhar'), $newName);
                $kyc->aadhar_image_front = $newName;
            }

            if ($request->hasFile('aadhar_image_back')) {
                if ($kyc->aadhar_back_image && file_exists(public_path('images/user/aadhar/'.$kyc->aadhar_back_image))) {
                    unlink(public_path('images/user/aadhar/'.$kyc->aadhar_back_image));
                }

                $file = $request->file('aadhar_image_back');
                $newName = 'aadhar_back_' . $code . '_' . $timestamp . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/user/aadhar'), $newName);
                $kyc->aadhar_image_back = $newName;
            }

            if ($request->hasFile('pan_image')) {
                if ($kyc->pan_image && file_exists(public_path('images/user/pan/'.$kyc->pan_image))) {
                    unlink(public_path('images/user/pan/'.$kyc->pan_image));
                }

                $file = $request->file('pan_image');
                $newName = 'pan_' . $code . '_' . $timestamp . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/user/pan'), $newName);
                $kyc->pan_image = $newName;
            }

            /*---------------------------------------------------
                UPDATE USER BASIC INFORMATION
            ----------------------------------------------------*/
            $user->update([
                'name' => $request->name,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'role_id' => $request->role_id,
            ]);

            /*---------------------------------------------------
                UPDATE KYC
            ----------------------------------------------------*/
            $kyc->update([
                'aadhar_number' => $request->aadhar_number,
                'pan_number' => $request->pan_number
            ]);

            /*---------------------------------------------------
                UPDATE ADDRESS
            ----------------------------------------------------*/
            $address = Address::where('user_id', $user->id)->first();

            $address->update([
                'address' => $request->full_address,
                'city_id' => $request->city,
                'state_id' => $request->state,
                'country_id' => $request->country,
                'zip' => $request->zip,
            ]);

            DB::commit();

            Helper::logActivity([
                'type'          => 'Update',
                'title'         => "update client info",
                'message'       => "Client info updated successfully",
                'route_name'    => $request->route()->getName(),
                'old_data'      => $user,
                'form_data'     => $request->all(),
                'ref_id'        => $user->id,
                'show'          => 'No',
            ]);

            return redirect()->route('clients')->with('success', 'Client updated successfully!');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('clients')->with('error', 'Update failed: ' . $e->getMessage());
        }
    }


    public function clientDelete($id, Request $request)
    {
        $user = auth()->user();
        $data = User::withTrashed()->whereHas('roles', function($query) {
                                $query->where('type', 'User');
                            })->findOrFail($id);

        if ($data->trashed()) {
            $data->restore();
            $message = 'Account restored successfully!';

            Helper::logActivity([
                'type'          => 'Restore',
                'title'         => "Client account restored",
                'message'       => "Client account restored successfully!",
                'route_name'    => $request->route()->getName(),
                'old_data'      => $user,
                'form_data'     => $request->all(),
                'ref_id'        => $user->id,
                'show'          => 'No',
            ]);

        } else {
            $data->delete();
            $message = 'Account deleted successfully!';
            
            Helper::logActivity([
                'type'          => 'Delete',
                'title'         => "Client account deleted",
                'message'       => "Client account deleted successfully!",
                'route_name'    => $request->route()->getName(),
                'old_data'      => $user,
                'form_data'     => $request->all(),
                'ref_id'        => $user->id,
                'show'          => 'No',
            ]);
        }

        return redirect()->back()->with('success', 'Account deleted successfully!');
    }
 

    public function clientChnagePassword(Request $request)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'password'     => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::find($request->user_id);

        $user->password = Hash::make($request->password);
        $user->save();

        Helper::logActivity([
            'type'          => 'Update',
            'title'         => "Client account password chnage",
            'message'       => "Client account password chnaged successfully!",
            'route_name'    => $request->route()->getName(),
            'old_data'      => $user,
            'form_data'     => $request->all(),
            'ref_id'        => $user->id,
            'show'          => 'No',
        ]);

        return redirect()->back()->with('success', 'Password chnage successfully!');
    }
    

    public function employees(Request $request)
    {
        $employees = User::withTrashed()->whereHas('roles', function($query) {
                                        $query->where('type', 'Employee');
                                    });

        // Deleted employees (soft deleted)
        $deleted = (clone $employees)->onlyTrashed()->count();

        // Deleted employees (soft deleted)
        $notDeleted = (clone $employees)->withoutTrashed()->count();

        // Registered this month (only not deleted)
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        $thisMonth = (clone $employees)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        
        $total = (clone $employees)->count();

        $data = (clone $employees)->get();
        
        return view('admin.user.employees.list', compact('data','total','deleted','notDeleted','thisMonth'));
    }


    public function employeeAdd()
    {
        $roles = Role::where('type', 'Employee')->get();
        $countrie = Countrie::orderBy('name', 'asc')->get();
        $country_id = $countrie[0]->id??'';
        return view('admin.user.employees.create', compact('roles','countrie','country_id'));
    }


    public function employeeStore(Request $request)
    {
        $request->merge(['code' => Helper::getTransId(4)]);

        $validated = $request->validate([
            'code' => 'required|string|unique:users,code',
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'required|in:Male,Female,Other',
            'role_id' => 'required|integer|exists:roles,id',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20|unique:users,phone_number',
            'full_address' => 'nullable|string|max:500',
            'country' => 'nullable|integer|exists:countries,id',
            'state' => 'nullable|integer|exists:states,id',
            'city' => 'nullable|integer|exists:cities,id',
            'zip' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_image_front' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_image_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pan_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_number' => 'nullable|string|max:20',
            'pan_number' => 'nullable|string|max:20',
            'terms' => 'accepted',
            'password' => 'required|string|min:6|confirmed',
        ]);


        DB::beginTransaction();

        try {

            $timestamp = now()->format('YmdHis');

            // Profile image (optional)
            $profileFileName = null;
            if ($request->hasFile('profile_image')) {
                $profileFile = $request->file('profile_image');
                $profileFileName = 'profile_' . $request->code . '_' . $timestamp . '.' . $profileFile->getClientOriginalExtension();
                $profileFile->move(public_path('images/profile'), $profileFileName);
            }

            // Aadhar front (optional)
            $aadharFrontName = null;
            if ($request->hasFile('aadhar_image_front')) {
                $aadharFrontFile = $request->file('aadhar_image_front');
                $aadharFrontName = 'aadhar_front_' . $request->code . '_' . $timestamp . '.' . $aadharFrontFile->getClientOriginalExtension();
                $aadharFrontFile->move(public_path('images/user/aadhar'), $aadharFrontName);
            }

            // Aadhar back (optional)
            $aadharBackName = null;
            if ($request->hasFile('aadhar_image_back')) {
                $aadharBackFile = $request->file('aadhar_image_back');
                $aadharBackName = 'aadhar_back_' . $request->code . '_' . $timestamp . '.' . $aadharBackFile->getClientOriginalExtension();
                $aadharBackFile->move(public_path('images/user/aadhar'), $aadharBackName);
            }

            // PAN image (optional)
            $panFileName = null;
            if ($request->hasFile('pan_image')) {
                $panFile = $request->file('pan_image');
                $panFileName = 'pan_' . $request->code . '_' . $timestamp . '.' . $panFile->getClientOriginalExtension();
                $panFile->move(public_path('images/user/pan'), $panFileName);
            }

            
            $user = User::create([
                'code' => $request->code,
                'name' => $request->name,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'image' => $profileFileName
            ]);

            Kyc::create([
                'user_id' => $user->id,
                'aadhar_number' => $request->aadhar_number,
                'pan_number' => $request->pan_number,
                'aadhar_image_front' => $aadharFrontName,
                'aadhar_image_back' => $aadharBackName,
                'pan_image' => $panFileName
            ]);
            
            Address::create([
                'user_id' => $user->id,
                'type' => 'Home',
                'address'   => $request->full_address,
                'city_id' => $request->city,
                'state_id' => $request->state,
                'country_id' => $request->country,
                'zip' => $request->zip,
                'default' => 'Yes'
            ]);

            Wallet::create([
                'user_id' => $user->id
            ]);

            BankDetail::create([
                'user_id' => $user->id
            ]);

            DB::commit();

            Helper::logActivity([
                'type'          => 'Insert',
                'title'         => "employee new client",
                'message'       => "New Employee created successfully",
                'route_name'    => $request->route()->getName(),
                'old_data'      => $user,
                'form_data'     => $request->all(),
                'ref_id'        => $user->id,
                'show'          => 'No',
            ]);

            return redirect()->route('employees')->with('success', 'Employee created successfully!');

        } catch (\Exception $e) {

            DB::rollBack();

            if ($profileFileName && file_exists(public_path('images/profile/'.$profileFileName))) { unlink(public_path('images/profile/'.$profileFileName)); }
            if ($aadharFrontName && file_exists(public_path('images/user/aadhar/'.$aadharFrontName))) { unlink(public_path('images/user/aadhar/'.$aadharFrontName)); }
            if ($aadharBackName && file_exists(public_path('images/user/aadhar/'.$aadharBackName))) { unlink(public_path('images/user/aadhar/'.$aadharBackName)); }
            if ($panFileName && file_exists(public_path('images/user/pan/'.$panFileName))) { unlink(public_path('images/user/pan/'.$panFileName)); }

            return redirect()->route('employees')->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

        return redirect()->route('employees')->with('success', 'Employee added successfully!');
    }

    
    public function employeeEdit($id)
    {    
        $data = User::findOrFail($id); 
        $address = Address::where('user_id', $id)->first();
        $kyc = Kyc::where('user_id', $id)->first();
           
        $roles = Role::where('type', 'Employee')->get();
        $countrie = Countrie::orderBy('name', 'asc')->get();
        $country_id = $address->country_id??'';
        $states = [];
        $cities = [];
        if(!empty($country_id)) {
            $states = State::where(['country_id' => $country_id])->orderBy('name', 'asc')->get();
        }
        if(!empty($address->state_id)) {
            $cities = Citie::where(['state_id' => $address->state_id])->orderBy('name', 'asc')->get();
        }
        

        return view('admin.user.employees.edit', compact('data','address','kyc','roles','countrie','country_id','states','cities'));
    }


    public function employeeUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'required|in:Male,Female,Other',
            'role_id' => 'required|integer|exists:roles,id',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required|string|max:20|unique:users,phone_number,' . $id,
            'full_address' => 'nullable|string|max:500',
            'country' => 'nullable|integer|exists:countries,id',
            'state' => 'nullable|integer|exists:states,id',
            'city' => 'nullable|integer|exists:cities,id',
            'zip' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_image_front' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_image_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pan_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aadhar_number' => 'nullable|string|max:20',
            'pan_number' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();

        try {

            $timestamp = now()->format('YmdHis');
            $code = $user->code;

            /*---------------------------------------------------
                HANDLE PROFILE IMAGE (IF UPDATED)
            ----------------------------------------------------*/
            if ($request->hasFile('profile_image')) {

                if ($user->image && file_exists(public_path('images/profile/'.$user->image))) {
                    unlink(public_path('images/profile/'.$user->image));
                }

                $profileFile = $request->file('profile_image');
                $profileName = 'profile_' . $code . '_' . $timestamp . '.' . $profileFile->getClientOriginalExtension();
                $profileFile->move(public_path('images/profile'), $profileName);
                $user->image = $profileName;
            }

            /*---------------------------------------------------
                HANDLE KYC IMAGES
            ----------------------------------------------------*/
            $kyc = Kyc::where('user_id', $user->id)->first();

            if ($request->hasFile('aadhar_image_front')) {
                if ($kyc->aadhar_front_image && file_exists(public_path('images/user/aadhar/'.$kyc->aadhar_front_image))) {
                    unlink(public_path('images/user/aadhar/'.$kyc->aadhar_front_image));
                }

                $file = $request->file('aadhar_image_front');
                $newName = 'aadhar_front_' . $code . '_' . $timestamp . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/user/aadhar'), $newName);
                $kyc->aadhar_image_front = $newName;
            }

            if ($request->hasFile('aadhar_image_back')) {
                if ($kyc->aadhar_back_image && file_exists(public_path('images/user/aadhar/'.$kyc->aadhar_back_image))) {
                    unlink(public_path('images/user/aadhar/'.$kyc->aadhar_back_image));
                }

                $file = $request->file('aadhar_image_back');
                $newName = 'aadhar_back_' . $code . '_' . $timestamp . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/user/aadhar'), $newName);
                $kyc->aadhar_image_back = $newName;
            }

            if ($request->hasFile('pan_image')) {
                if ($kyc->pan_image && file_exists(public_path('images/user/pan/'.$kyc->pan_image))) {
                    unlink(public_path('images/user/pan/'.$kyc->pan_image));
                }

                $file = $request->file('pan_image');
                $newName = 'pan_' . $code . '_' . $timestamp . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/user/pan'), $newName);
                $kyc->pan_image = $newName;
            }

            /*---------------------------------------------------
                UPDATE USER BASIC INFORMATION
            ----------------------------------------------------*/
            $user->update([
                'name' => $request->name,
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'role_id' => $request->role_id,
            ]);

            /*---------------------------------------------------
                UPDATE KYC
            ----------------------------------------------------*/
            $kyc->update([
                'aadhar_number' => $request->aadhar_number,
                'pan_number' => $request->pan_number
            ]);

            /*---------------------------------------------------
                UPDATE ADDRESS
            ----------------------------------------------------*/
            $address = Address::where('user_id', $user->id)->first();

            $address->update([
                'address' => $request->full_address,
                'city_id' => $request->city,
                'state_id' => $request->state,
                'country_id' => $request->country,
                'zip' => $request->zip,
            ]);

            DB::commit();

            Helper::logActivity([
                'type'          => 'Update',
                'title'         => "update employee info",
                'message'       => "Employee info updated successfully",
                'route_name'    => $request->route()->getName(),
                'old_data'      => $user,
                'form_data'     => $request->all(),
                'ref_id'        => $user->id,
                'show'          => 'No',
            ]);

            return redirect()->route('employees')->with('success', 'Employee Info updated successfully!');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('employees')->with('error', 'Update failed: ' . $e->getMessage());
        }
    }


    public function employeeDelete($id, Request $request)
    {   
        $user = auth()->user();
        $data = User::withTrashed()->whereHas('roles', function($query) {
                                        $query->where('type', 'Employee');
                                    })->findOrFail($id);

       if ($data->trashed()) {
            $data->restore();

            $message = 'Account restored successfully!';

            Helper::logActivity([
                'type'          => 'Restore',
                'title'         => "Employee account restored",
                'message'       => "Employee account restored successfully!",
                'route_name'    => $request->route()->getName(),
                'old_data'      => $user,
                'form_data'     => $request->all(),
                'ref_id'        => $user->id,
                'show'          => 'No',
            ]);

        } else {
            $data->delete();
            $message = 'Account deleted successfully!';

            Helper::logActivity([
                'type'          => 'Delete',
                'title'         => "Employee account deleted",
                'message'       => "Employee account deleted successfully!",
                'route_name'    => $request->route()->getName(),
                'old_data'      => $user,
                'form_data'     => $request->all(),
                'ref_id'        => $user->id,
                'show'          => 'No',
            ]);

        }

        return redirect()->back()->with('success', 'Account deleted successfully!');
    }
 

    public function employeeChnagePassword(Request $request)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'password'     => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::find($request->user_id);

        $user->password = Hash::make($request->password);
        $user->save();

        Helper::logActivity([
            'type'          => 'Update',
            'title'         => "Employee account password chnage",
            'message'       => "Employee account password chnaged successfully!",
            'route_name'    => $request->route()->getName(),
            'old_data'      => $user,
            'form_data'     => $request->all(),
            'ref_id'        => $user->id,
            'show'          => 'No',
        ]);

        return redirect()->back()->with('success', 'Password chnage successfully!');
    }



    public function notifications(Request $request)
    {
        $query = ActivityLog::withTrashed(); 

        // Default date range (last 1 month)
        $default_from = now()->subMonth()->startOfDay()->toDateString();
        $default_to = now()->endOfDay()->toDateString();

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

        return view('admin.log.notification', compact('data'));
    }


    public function activityLog(Request $request)
    {
        $query = ActivityLog::with('user')->withTrashed(); 

        // Default date range (last 1 month)
        $default_from = now()->subMonth()->startOfDay()->toDateString();
        $default_to = now()->endOfDay()->toDateString();

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

        return view('admin.log.activity', compact('data'));
    }


    public function loginActivity(Request $request)
    {
        $query = LoginLog::with('user')->withTrashed(); 

        // Default date range (last 1 month)
        $default_from = now()->subMonth()->startOfDay()->toDateString();
        $default_to = now()->endOfDay()->toDateString();

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

        return view('admin.log.login-log', compact('data'));
    }



    public function fundAdd(Request $request)
    {
        $banks = CompanyBank::get();
        return view('admin.fund.add',compact('banks'));
    }
    
    public function fundAddStore(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'bank_id'       => 'required|integer|exists:company_banks,id',
            'amount'        => 'required|numeric|min:1',
            'payment_mode'  => 'required|string',
            'utr_no'        => 'required|string',
            'description'   => 'nullable|string',
            'utr_img'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        
        if ($request->hasFile('utr_img')) {
            $file = $request->file('utr_img');

            $newName = auth()->user()->phone_number . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/fund_request'), $newName);

            $data['utr_img'] = $newName;
        }

        $bank = CompanyBank::findOrFail($request->bank_id); 

        $data['trans_id'] = Helper::getTransId();
        $data['from_user_id'] = $user->id;
        $data['to_user_id'] = $bank->user_id;
        $data['desc'] = $request->description;
        
        $check = FundRequest::create($data);

        if ($check) {
                return redirect()->route('fund-requests')->with(['success' => 'Fund request send Successfully,']);
        } else {
                return redirect()->route('fund-requests')->with(['error' => 'Fund request Not send.']);
        }
    }
    

    public function fundSend(Request $request)
    {
        $banks = CompanyBank::get();
        return view('admin.fund.send',compact('banks'));
    }


    public function fundSendStore(Request $request)
    {
        // ---------- Validation ----------
        $request->validate([
            'ledger_type'   => 'required|in:1,2',
            'wallet_type'   => 'required|in:DMT,MAIN',
            'phone_number'  => 'required|digits:10|exists:users,phone_number',
            'amount'        => 'required|numeric|min:1|max:1000000000',
            'remark'        => 'required|string',
        ]);

        // ---------- Fetch user ----------
        $sendUser = User::where([
            'phone_number' => $request->phone_number
        ])->first();

        if (!$sendUser) {
            return back()->withErrors(['phone_number' => 'User Info Not Found.'])->withInput();
        }

        // ---------- Prevent self-transfer ----------
        if ($sendUser->id === auth()->id()) {
            return back()->withErrors(['phone_number' => 'Cannot transfer to your own account.'])->withInput();
        }

        // ---------- Role check ----------
        if (auth()->user()->role_id != 1) {
            return back()->withErrors(['phone_number' => 'You do not have permission to transfer funds.'])->withInput();
        }

        // ---------- Wallet Check ----------
        $walletBal = Wallet::where('user_id', $sendUser->id)->first();
        if (!$walletBal) {
            return back()->withErrors(['phone_number' => 'Wallet information not found.'])->withInput();
        }

        $amount = (float)$request->amount;
        $wallet_type = $request->wallet_type === 'MAIN' ? 1 : 2;

        // ---------- Check balance only if ledger type = debit (2) ----------
        if ($request->ledger_type == 2) {
            // if ($request->wallet_type === 'DMT' && $walletBal->dmt_balance < $amount) {
            //     return back()->withErrors(['points' => 'Insufficient DMT balance.'])->withInput();
            // }

            if ($request->wallet_type === 'MAIN' && $walletBal->main_balance < $amount) {
                return back()->withErrors(['main_balance' => 'Insufficient main balance.'])->withInput();
            }
        }

        // ---------- Prepare payload ----------
        $payload = [
            "user_id"      => $sendUser->id,
            "refrence_id"  => auth()->id(),
            "amount"       => $amount,
            "trans_id"     => Helper::getTransId(3),
            "cgst"         => 0,
            "sgst"         => 0,
            "ledger_type"  => (int)$request->ledger_type,
            "wallet_type"  => $wallet_type,
            "trans_from"   => 'Wallet',
            "description"  => $request->remark
        ];

        // ---------- Execute ledger action ----------
        $action = $request->ledger_type == 1
                    ? Helper::creadit_ledger($payload)
                    : Helper::debit_ledger($payload);

        // ---------- Final response ----------
        if ($action["status"] === "success") {
            return redirect()->route('fund-transfers')->with('success', 'Fund transfer successfully.');
        }

        return redirect()->route('fund-transfers')->with('error', $action["message"] ?? 'Fund transfer failed.');
    }


    


    public function fundTransfers(Request $request)
    {
        $role_type = auth()->user()->roles->type;
        $user = auth()->user();

        $defaultFrom = request('from_date') ?? now()->subMonths(3)->format('Y-m-d');
        $defaultTo   = request('to_date') ?? now()->format('Y-m-d');

        $query = Ledger::whereIn('ledger_type', ['WALLET CREDIT ADMIN','WALLET DEBIT BY ADMIN'])->latest();

  
        // ---------- Date Filter ----------
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);

        } else {
            // ---------- Default: Last 3 Months ----------
            $query->where('created_at', '>=', now()->subMonths(3));
        }


        if ($role_type !== "Admin") {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                ->orWhere('refrence_id', $user->id);
            });
        } else {
            // ---------- Phone Filter ----------
            if ($request->filled('phone_number')) {
                $phone = $request->phone_number;

                $query->where(function ($q) use ($phone) {
                    $q->whereHas('users', function ($u) use ($phone) {
                        $u->where('phone_number', $phone);
                    })->orWhereHas('referenceUser', function ($r) use ($phone) {
                        $r->where('phone_number', $phone);
                    });
                });
            }
        }

        $data = $query->get();

        return view('admin.fund.transfer-list', compact('data','defaultFrom','defaultTo'));
    }

    
    public function fundRequests(Request $request)
    {
        $role_type = auth()->user()->roles->type;
        $user = auth()->user();

        $defaultFrom = request('from_date') ?? now()->subMonths(3)->format('Y-m-d');
        $defaultTo   = request('to_date') ?? now()->format('Y-m-d');

        $query = FundRequest::where('to_user_id', $user->id)->latest();

  
        // ---------- Date Filter ----------
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);

        } else {
            // ---------- Default: Last 3 Months ----------
            $query->where('created_at', '>=', now()->subMonths(3));
        }


        if ($role_type !== "Admin") {
            $query->where(function ($q) use ($user) {
                $q->where('from_user_id', $user->id);
            });
        } else {
            if ($request->filled('phone_number')) {
                $phone = $request->phone_number;

                $query->where(function ($q) use ($phone) {
                    $q->whereHas('users', function ($u) use ($phone) {
                        $u->where('phone_number', $phone);
                    })->orWhereHas('referenceUser', function ($r) use ($phone) {
                        $r->where('phone_number', $phone);
                    });
                });
            }
        }

        $data = $query->get();

        return view('admin.fund.request-list', compact('data','defaultFrom','defaultTo')); 
    }
     
    public function fundRequestUpdate($status, $id, Request $request)
    {
        $user = auth()->user();

        // Fetch fund request
        $data = FundRequest::where([
            'to_user_id'   => $user->id,
            'id'           => $id
        ])->first();

        if (!$data) {
            return back()->with('error', 'Invalid Request.');
        }

        // ---- APPROVE ----
        if ($status === 'verify') {

            if ((float)$data->amount <= 0) {
                return back()->with('error', 'Amount must be greater than zero.');
            }

            // Wallet mapping
            $walletMap = [
                'MAIN' => 1,
                'DMT'  => 2
            ];

            $wallet_type = $walletMap[$data->wallet_type] ?? 0;

            if ($wallet_type == 0) {
                return back()->with('error', 'Invalid wallet type!');
            }

            $ledgerResponse = Helper::creadit_ledger([
                "user_id"     => $data->from_user_id,
                "refrence_id" => $user->id,
                "amount"      => (float)$data->amount,
                "trans_id"    => $data->trans_id,
                "cgst"        => 0,
                "sgst"        => 0,
                "ledger_type" => 18,
                "wallet_type" => $wallet_type,
                "trans_from"  => 'Wallet',
                "description" => 'Fund Request Approved'
            ]);

            if ($ledgerResponse["status"] === "success") {

                $data->update([
                    "status"   => "Approved",
                    "remark"   => $request->remarks
                ]);

                return back()->with('success', 'Fund approved successfully.');
            }

            return back()->with('error', $ledgerResponse["message"]);
        }

        // ---- REJECT ----
        if ($status === 'reject') {

            $data->update([
                "status" => "Rejected",
                "remark" => $request->remarks
            ]);

            return back()->with('success', 'Fund rejected successfully.');
        }

        return back()->with('error', 'Action not allowed.');
    }
        
    
    public function availableBalance(Request $request)
    {
        $data = Wallet::latest()->get();

        $role_type = auth()->user()->roles->type;
        $user = auth()->user();

        $query = Wallet::with('user')->latest();

        if ($role_type !== "Admin") {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } else {
            if ($request->filled('phone_number')) {
                $phone = $request->phone_number;

                $query->where(function ($q) use ($phone) {
                    $q->whereHas('user', function ($u) use ($phone) {
                        $u->where('phone_number', $phone);
                    });
                });
            }
        }

        $data = $query->get();

        return view('admin.fund.wallet-list',compact('data'));
    }
  
    public function mainLedger(Request $request)
    {
        $role_type = auth()->user()->roles->type;
        $user = auth()->user();

        $defaultFrom = request('from_date') ?? now()->subMonths(3)->format('Y-m-d');
        $defaultTo   = request('to_date') ?? now()->format('Y-m-d');

        $query = Ledger::whereIn('bal_type', ['MAIN'])->latest();

  
        // ---------- Date Filter ----------
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);

        } else {
            // ---------- Default: Last 3 Months ----------
            $query->where('created_at', '>=', now()->subMonths(3));
        }


        if ($role_type !== "Admin") {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                ->orWhere('refrence_id', $user->id);
            });
        } else {
            // ---------- Phone Filter ----------
            if ($request->filled('phone_number')) {
                $phone = $request->phone_number;

                $query->where(function ($q) use ($phone) {
                    $q->whereHas('users', function ($u) use ($phone) {
                        $u->where('phone_number', $phone);
                    })->orWhereHas('referenceUser', function ($r) use ($phone) {
                        $r->where('phone_number', $phone);
                    });
                });
            }
        }

        $data = $query->get();

        return view('admin.fund.main-ledger-list', compact('data','defaultFrom','defaultTo'));
    }

    public function pointsLedger(Request $request)
    {
        $role_type = auth()->user()->roles->type;
        $user = auth()->user();

        $defaultFrom = request('from_date') ?? now()->subMonths(3)->format('Y-m-d');
        $defaultTo   = request('to_date') ?? now()->format('Y-m-d');

        $query = Ledger::whereIn('ledger_type', ['WALLET CREDIT ADMIN','WALLET DEBIT BY ADMIN'])->latest();

        // ---------- Date Filter ----------
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);

        } else {
            // ---------- Default: Last 3 Months ----------
            $query->where('created_at', '>=', now()->subMonths(3));
        }

        if ($role_type !== "Admin") {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                ->orWhere('refrence_id', $user->id);
            });
        } else {
            // ---------- Phone Filter ----------
            if ($request->filled('phone_number')) {
                $phone = $request->phone_number;

                $query->where(function ($q) use ($phone) {
                    $q->whereHas('users', function ($u) use ($phone) {
                        $u->where('phone_number', $phone);
                    })->orWhereHas('referenceUser', function ($r) use ($phone) {
                        $r->where('phone_number', $phone);
                    });
                });
            }
        }

        $data = $query->get();

        return view('admin.fund.transfer-list', compact('data','defaultFrom','defaultTo'));
    }





    public function withdrawAdd(Request $request)
    {
        $user = auth()->user();
        $banks=BankDetail::where('user_id',$user->id)->whereNotNull('bank_id')->orWhere('status','Verified')->get();
        return view('admin.withdraw.add',compact('banks'));
        
    }

 

    public function withdrawAddStore(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'amount'        => 'required|numeric|min:1',
            'description'   => 'nullable|string',
        ]);

        $bank = BankDetail::findOrFail($request->bank_id); 

        $data['trans_id'] = Helper::getTransId();
        $data['user_id'] = $user->id;
        $data['user_bank_id'] = $bank->id;
        $data['referral_id'] = 1; 
          
        $check = WithdrawRequest::create($data);

        if ($check) {
            return redirect()->route('withdraw-requests')->with(['success' => 'Withdraw request send Successfully,']);
        } else {
            return redirect()->route('withdraw-requests')->with(['error' => 'withdraw request Not send.']);
            
        }
    }



   public function withdrawRequests(Request $request)
   { 
        $role_type = auth()->user()->roles->type;
        $user = auth()->user();

        $defaultFrom = request('from_date') ?? now()->subMonths(3)->format('Y-m-d');
        $defaultTo   = request('to_date') ?? now()->format('Y-m-d');

        $query = WithdrawRequest::latest();

  
        // ---------- Date Filter ----------
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);

        } else {
            // ---------- Default: Last 3 Months ----------
            $query->where('created_at', '>=', now()->subMonths(3));
        }


        if ($role_type !== "Admin") {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } else {

            $query->where('referral_id', $user->id);

            if ($request->filled('phone_number')) {
                $phone = $request->phone_number;

                $query->where(function ($q) use ($phone) {
                    $q->whereHas('users', function ($u) use ($phone) {
                        $u->where('phone_number', $phone);
                    });
                });
            }
        }

        $data = $query->get();

        return view('admin.withdraw.request-list', compact('data','defaultFrom','defaultTo')); 
    }




    public function withdrawRequestUpdate($status, $id, Request $request)
    {
        $request->validate([
            'remarks'   => 'nullable|string',
            'mode'=>'required|string|in:ATM Transfer,CASH,CHEQUE,UPI,DMR WALLET,IMPS,MAIN WALLET,NEFT / RTGS,SAME BANK FUND TRANSFER,Wallet',
            'utr_no'=>'nullable|string',
        ]);
         
        $user = auth()->user();

        // Fetch Withdraw request
        $data = WithdrawRequest::where([
            'referral_id'   => $user->id,
            'id'           => $id
        ])->first();
    

        if (!$data) {
            return back()->with('error', 'Invalid Request.');
        }

        if ($status === 'reject') {
          
            if ((float)$data->amount <= 0) {
                return back()->with('error', 'Amount must be greater than zero.');
            }
            
            $data['mode']=$request->mode;
            //   dd($data);

            // Wallet mapping
            // $walletMap = [
            //     'MAIN' => 1,
            //     'DMT'  => 2
            // ];

            $wallet_type = 1; //$walletMap[$data->wallet_type] ?? 0;
           
            if ($wallet_type == 0) {
                return back()->with('error', 'Invalid wallet type!');
            }

            $ledgerResponse = Helper::creadit_ledger([
                "user_id"     => $data->user_id,
                "refrence_id" => $user->id,
                "amount"      => (float)$data->amount,
                "trans_id"    => $data->trans_id,
                "cgst"        => 0,
                "sgst"        => 0,
                "ledger_type" => 18,
                "wallet_type" => $wallet_type,
                "trans_from"  => 'Wallet',
                "description" => 'Withdraw Request Rejected'
            ]);

            if ($ledgerResponse["status"] === "success") {

                $data->update([
                    "status"   => "Rejected",
                    "mode"   => $request->mode,
                    "utr_no" => $request->utr_no,
                    "remark"   => $request->remarks
                ]);

                return back()->with('success', 'Withdraw rejected successfully.');
            }

            return back()->with('error', $ledgerResponse["message"]);
        }

        if ($status === 'verify') {

            $data->update([
                "status" => "Approved",
                "remark" => $request->remarks
            ]);

            return back()->with('success', 'Withdraw approved successfully.');
        }

        return back()->with('error', 'Action not allowed.');
    }



}
