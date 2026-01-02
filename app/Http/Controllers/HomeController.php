<?php

namespace App\Http\Controllers;
use App\Services\SolarCalculationService;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\CalculatorState;
use App\Models\StaticContent;
use App\Models\ClientReview;
use App\Models\ContactUs;
use App\Models\Countrie;
use App\Models\State;
use App\Models\Blog;
use App\Helpers\Helper;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    // protected $solarService;

    public function __construct()// SolarCalculationService $solarService
    {
        // $this->middleware('auth');
        // $this->solarService = $solarService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $states = CalculatorState::get();
        $reviews = ClientReview::latest()->limit(3)->get();
        $blogs = Blog::with('category')
                ->where(function ($query) {
                    $query->where('status', 'publish')
                        ->orWhere(function ($q) {
                            $q->where('status', 'schedule')
                            ->where('publish_datetime', '<=', now());
                        });
                })
                ->latest()->limit(3)
                ->get();
        return view('front.index',compact('states','reviews','blogs'));
    }

    public function static_content()
    {
        $routeName = \Route::currentRouteName();

        $data = StaticContent::where('type', $routeName)->first();
        if(!$data) {
            return back();
        } else {
            return view('front.static_content', compact('data'));
        }
    }

    
    public function blogs(Request $request)
    {
        $data = Blog::with('category')
                ->where(function ($query) {
                    $query->where('status', 'publish')
                        ->orWhere(function ($q) {
                            $q->where('status', 'schedule')
                            ->where('publish_datetime', '<=', now());
                        });
                })
                ->latest()
                ->paginate(6);

        return view('front.blog-list', compact('data'));
    } 

    
    public function blogDetails($slug)
    {
        $blog = Blog::with('category')
                ->where(function ($query) {
                    $query->where('status', 'publish')
                        ->orWhere(function ($q) {
                            $q->where('status', 'schedule')
                            ->where('publish_datetime', '<=', now());
                        });
                })->where('slug', $slug)->first();

        $data = Blog::with('category')
                ->where(function ($query) {
                    $query->where('status', 'publish')
                        ->orWhere(function ($q) {
                            $q->where('status', 'schedule')
                            ->where('publish_datetime', '<=', now());
                        });
                })->where('category_id', $blog->category_id)
                ->latest()
                ->paginate(6);

        return view('front.blog-details',compact('blog','data'));
    } 

    public function ourServices()
    {
        return view('front.services');
    } 
   

    public function ourProjects()
    {
        $data = ClientReview::latest()->paginate(6);
        return view('front.projects',compact('data'));
    } 
   
   
    public function faq()
    {
        return view('front.contact-us');
    } 
   
    public function contactUs()
    {
        return view('front.contact-us');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:100',
            'phone'         => ['required', 'regex:/^[6-9]\d{9}$/'],
            'email'         => 'required|email',
            'subject'       => 'required|string|max:191',
            'message'       => 'required|string|max:10000'
        ]);

        ContactUs::create([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);


        $send = Helper::send_sms([   
            'template_name' =>  'lead_submited_by_customer',
            'send_to_phone' => $request->phone,
            'user_id'       =>  0,
            'user_type'     =>  'User',
            'title'         =>  'Customer us',
            'name'          =>  $request->name,
            'code'          =>  $request->phone,
            'phone'         =>  $request->phone,
            'email'         =>  $request->email,
            'password'      =>  '',
            'otp'           =>  '',
            'message'       =>  '',
            'date'          =>  '',
            'link'          =>  '',
            'trans_id'      =>  '',
            'other'         =>  ''
        ]); 

        return back()->with('success', 'Your message has been submitted successfully!');
    }


    public function querySend()
    {
        $countrie = Countrie::orderBy('name', 'asc')->get();
        $country_id = '101';
        $states = [];
        if(!empty($country_id)) {
            $states = State::where(['country_id' => $country_id])->orderBy('name', 'asc')->get();
        }

        return view('front.query-send',compact('countrie','states','country_id'));
    } 
}
