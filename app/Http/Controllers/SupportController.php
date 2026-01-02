<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Support; 
use App\Models\SupportReply;
use App\Models\User;
use App\Models\Role;

class SupportController extends Controller
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
     
    public function tickets(Request $request)
    {   
        $url = request()->segment(count(request()->segments()));

        if($url == "open-tickets") {
            $status = ['Pending', 'Open'];
        } else {
            $status = ['Closed'];
        }

        $employees = User::where('role_id', 3)->get(['id', 'name']);

        $data = Support::withTrashed()->with(['user','assignee'])->whereIn('status', $status)->latest()->get();

        return view('admin.support.list',compact('data', 'status', 'employees'));
    }
    
    public function ticketAdd(Request $request)
    {
        return view('admin.support.create_ticket');
    }

    public function ticketStore(Request $request) {

        $user_id = Auth::user()->id;

        $request->validate([
            'request_for'  => 'required|string',
            'subject'      => 'required|string|max:255',
            'description'  => 'required|string',
            'file'         => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $code = config('app.shortname').'-'.time().$user_id;

        $support = Support::create([
            "code" => $code,
            "for" => $request->request_for,
            "user_id" => $user_id,
            "subject" => $request->subject,
        ]);

        $filename = null;
        $filetype = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filetype = $file->getClientOriginalExtension(); 
            $filename = $code. '_'.date("Y-m-d H:i:s"). '.' . $filetype;
            $destinationPath = public_path('support_replies');
            $file->move($destinationPath, $filename);
        }

        SupportReply::create([
            'support_id' =>  $support->id,
            'description' => $request->description,
            'type' => Auth::user()->roles->role_type == "Admin"?"Admin":"User",
            'file' => $filename,
            'file_type' => $filetype,
            'user_id' => $user_id,
            'replay_id' => 0,
        ]);

        $sms_data = [   
            'template_name' =>  'complaint_submitted_customer',
            'send_to_phone' => $support->user->phone_number,
            'user_id'       =>  0,
            'user_type'     =>  'User',
            'title'         =>  'Order Completed',
            'name'          =>  $support->user->name,
            'code'          =>  $code,
            'phone'         =>  $support->user->phone_number,
            'email'         =>  $support->user->email,
            'password'      =>  '',
            'otp'           =>  '',
            'message'       =>  '',
            'date'          =>  '',
            'link'          =>  '',
            'trans_id'      =>  '',
            'other'         =>  ''
        ];

        $send = Helper::send_sms($sms_data); 

        return redirect()->route('tickets', ['Pending'])->with('success', 'Support created successfully.');
    }
     
     
    public function replyTicket($id, Request $request)
    {       
        $data = Support::with(['user','assignee'])->findOrFail($id);

        $profile = auth()->user()->gender == 'Female'? 'images/user-2.svg':'images/user-1.svg';

        $query = SupportReply::where('support_id', $id)->orderBy('created_at', 'desc');

        if ($request->has('before_id')) {
            $query->where('id', '<', $request->before_id);
        }

        $messages = $query->limit(10)->get()->reverse();

        if ($request->ajax()) {
            return view('admin.support.partials.messages-list', compact('messages','data','profile'))->render();
        }

        $employees = User::withTrashed()->whereHas('roles', function($query) {
                                $query->where('type', 'Employee');
                            })->get(['id', 'name']);

        $support = Support::with(['user', 'assignee', 'replies' => function ($query) {
                                    $query->orderBy('created_at', 'desc')->limit(1);
                                }])->whereIn('status', ['Pending', 'Open'])->orderBy('updated_at','desc')->get();

        return view('admin.support.messages', compact('messages', 'data','employees','support','profile'));
    }

    public function storeReplyTicket($id, Request $request)
    {
            $data = Support::findOrFail($id);
          
            $request->validate([
                'message' => 'required',
                'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            ], [
                'message.required' => 'Message Required',
                'attachment.max' => 'File must be under 10MB',
            ]);

            $filename = null;
            $filetype = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filetype = $file->getClientOriginalExtension(); 
                $filename = $data->code . '_' . date("Y-m-d_H-i-s") . '.' . $filetype;
                $destinationPath = public_path('images/support');
                $file->move($destinationPath, $filename);
            }

            $insert = SupportReply::insert([
                                        'support_id' => $id, 
                                        'user_id' => Auth::user()->id, 
                                        'description' => $request->message,
                                        'type' => Auth::user()->roles->type,
                                        'file_type' => $filetype,
                                        'file' => $filename,
                                        'replay_id' => 0,
                                    ]);
            
            $count = SupportReply::groupBy('user_id')->where('support_id',$id)->count();
            
            if($count > 1 && $data->status != 'Closed') {
                $data->status = 'Open';
                $data->save();
            }

            return to_route('ticket-reply', [$id]);
    }

    
    public function assignEmployeeTicket(Request $request)
    {
        $update = Support::where('id', $request->id)->update([
            'assigned_to' => $request->employee,
            'assign_date' => now(),
            'assigned_by' => Auth::user()->id,
        ]);


        $sms_data = [   
            'template_name' =>  'complaint_assigned_associate',
            'send_to_phone' => $update->user->phone_number,
            'user_id'       =>  0,
            'user_type'     =>  'User',
            'title'         =>  'Order Completed',
            'name'          =>  $update->user->name,
            'code'          =>  $update->code,
            'phone'         =>  $update->user->phone_number,
            'email'         =>  $update->user->email,
            'password'      =>  '',
            'otp'           =>  '',
            'message'       =>  '',
            'date'          =>  '',
            'link'          =>  '',
            'trans_id'      =>  '',
            'other'         =>  ''
        ];

        $send = Helper::send_sms($sms_data); 

        return back()->with(['success' => 'Employee Assigned']);
    }


    public function statusTicket($id, Request $request)
    {
        $data = Support::findOrFail($id);
        $data->status = 'Closed';
        $data->save();

        $sms_data = [   
            'template_name' =>  'complaint_resolved',
            'send_to_phone' => $data->user->phone_number,
            'user_id'       =>  0,
            'user_type'     =>  'User',
            'title'         =>  'Order Completed',
            'name'          =>  $data->user->name,
            'code'          =>  $data->code,
            'phone'         =>  $data->user->phone_number,
            'email'         =>  $data->user->email,
            'password'      =>  '',
            'otp'           =>  '',
            'message'       =>  '',
            'date'          =>  '',
            'link'          =>  '',
            'trans_id'      =>  '',
            'other'         =>  ''
        ];

        $send = Helper::send_sms($sms_data); 

        return back()->with(['success' => 'Closed Ticket']);
    }

     
    public function ticketDelete($id)
    {
        $data = Support::withTrashed()->findOrFail($id);
        
        if ($data->trashed()) {
            $data->restore();
            $message = 'Ticket restored successfully!';
        } else {
            $data->delete();
            $message = 'Ticket deleted successfully!';
        }

        return redirect()->route('tickets')->with('success', $message);
    }
    
}
