<?php

namespace App\Http\Controllers\Api;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ProfessionalUser;
use App\Models\ServiceTimeSlot;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Media;
use App\Models\User;
use App\Models\Kyc;

class ApiUserController extends BaseController
{
    
    #[OA\Get(
        path: '/user/profile',
        operationId: 'getUserProfile',
        summary: 'Get user profile',
        description: 'Retrieve the authenticated user profile information.',
        tags: ['User Profile'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User profile retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Profile retrieved successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            description: 'User object'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthorized.')
                    ]
                )
            )
        ],
        security: [['sanctum' => []]]
    )]
    public function profile(Request $request)
    {
        $user = Auth::user();

        if (!Auth::check() || !$user) {
            return $this->error('Unauthorized.', [], 401);
        }

        $data = User::find($request->user()->id);

        if (!$data) {
            return $this->error('User not found.', [], 404);
        }
        return $this->success(
            'Profile retrieved successfully.',
            $data
        );
    }



  
    #[OA\Post(
        path: '/user/update-profile',
        operationId: 'updateUserProfile',
        summary: 'Update user profile',
        description: 'Update user profile information including name, username, about, hobbies, profile image, media files, and all professional fields.\n\nPreview in Postman: After calling this API, you can view the response and test the endpoint using Postman. Import the Swagger JSON or use the endpoint directly in Postman for preview.',
        tags: ['User Profile'],
        security: [['bearer' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['name', 'username', 'about', 'user_type','gender','dob','hobbies','image'],
                    properties: [
                        new OA\Property(property: 'user_type', type: 'string', enum: ['Personal', 'Professional'], description: 'User type (dropdown)'),
                        new OA\Property(property: 'name', type: 'string', example: 'Durgesh Verma', description: 'User full name'),
                        new OA\Property(property: 'username', type: 'string', example: 'dk01', description: 'Unique username'),
                        new OA\Property(property: 'about', type: 'string', example: 'User bio', description: 'User bio/about section'),
                        new OA\Property(property: 'location', type: 'string', description: 'User location'),
                        new OA\Property(property: 'hobbies', type: 'array', items: new OA\Items(type: 'string'), description: 'Array of hobbies'),
                        new OA\Property(property: 'image', type: 'string', format: 'binary', description: 'Profile image'),
                        new OA\Property(property: 'media', type: 'array', items: new OA\Items(type: 'string', format: 'binary'), description: 'Array of media files'),
                        // Professional fields
                        new OA\Property(property: 'title', type: 'string', description: 'Professional title'),
                        new OA\Property(property: 'skills', type: 'array', items: new OA\Items(type: 'string'), description: 'Array of skills'),
                        new OA\Property(property: 'skill_info', type: 'string', description: 'Skill information'),
                        new OA\Property(property: 'expert_bio', type: 'string', description: 'Expert bio'),
                        new OA\Property(property: 'portfolio_gallery', type: 'array', items: new OA\Items(type: 'string', format: 'binary'), description: 'Portfolio gallery images'),
                        new OA\Property(property: 'your_vibe', type: 'array', items: new OA\Items(type: 'string', format: 'binary'), description: 'Your vibe images'),
                        new OA\Property(property: 'files', type: 'array', items: new OA\Items(type: 'string', format: 'binary'), description: 'Professional files'),
                        new OA\Property(property: 'service_timing_type', type: 'string', enum: ["No Hours Available", "Always Open", "Permanently Closed", "Temporarily Closed", "Open during selected hours"], example: "Open during selected hours", description: 'Service timing type'),
                        new OA\Property(property: 'service_slots', type: 'array',
                            example: [ [
                                    "day" => "Monday",
                                    "start" => "09:00",
                                    "end" => "18:00",
                                    "type" => "Open"
                                ], [
                                    "day" => "Tuesday",
                                    "start" => "10:00",
                                    "end" => "17:00",
                                    "type" => "Open"
                                ], [
                                    "day" => "Wednesday",
                                    "start" => "10:00",
                                    "end" => "17:00",
                                    "type" => "Open"
                                ], [
                                    "day" => "Thursday",
                                    "start" => "10:00",
                                    "end" => "17:00",
                                    "type" => "Open"
                                ], [
                                    "day" => "Friday",
                                    "start" => "10:00",
                                    "end" => "17:00",
                                    "type" => "Open"
                                ], [
                                    "day" => "Saturday",
                                    "start" => "09:00",
                                    "end" => "18:00",
                                    "type" => "Closed"
                                ], [
                                    "day" => "Sunday",
                                    "start" => "09:00",
                                    "end" => "18:00",
                                    "type" => "Closed"
                                ] ],
                            items: new OA\Items(
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'day',
                                    type: 'string',
                                    example: 'Monday',
                                    description: 'Day of week'
                                ),
                                new OA\Property(
                                    property: 'start',
                                    type: 'string',
                                    example: '09:00',
                                    description: 'Start time (HH:MM)'
                                ),
                                new OA\Property(
                                    property: 'end',
                                    type: 'string',
                                    example: '18:00',
                                    description: 'End time (HH:MM)'
                                ),
                                new OA\Property(
                                    property: 'type',
                                    type: 'string',
                                    example: 'Open',
                                    description: 'Open or Closed'
                                ),
                            ]
                        ), description: 'Custom service slots'),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Profile updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'Profile updated successfully.'),
                        new OA\Property(property: 'data', type: 'object', description: 'Updated user data'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Validation error'),
                        new OA\Property(property: 'errors', type: 'object'),
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Unauthorized.'),
                    ]
                )
            ),
        ]
    )]
    // #[OA\Post(
    //     path: '/user/update-profile',
    //     operationId: 'updateUserProfile',
    //     summary: 'Update user profile',
    //     tags: ['User Profile'],
    //     security: [['bearer' => []]],
    //     requestBody: new OA\RequestBody(
    //         required: true,
    //         content: new OA\MediaType(
    //             mediaType: 'multipart/form-data',
    //             schema: new OA\Schema(
    //                 required: ['name', 'username', 'about', 'user_type', 'gender', 'dob', 'hobbies', 'image'],
    //                 properties: [

    //                     new OA\Property(
    //                         property: 'user_type',
    //                         type: 'string',
    //                         enum: ['Personal', 'Professional'],
    //                         example: 'Professional'
    //                     ),

    //                     new OA\Property(
    //                         property: 'name',
    //                         type: 'string',
    //                         example: 'Durgesh Verma'
    //                     ),

    //                     new OA\Property(
    //                         property: 'username',
    //                         type: 'string',
    //                         example: 'dk01'
    //                     ),

    //                     new OA\Property(
    //                         property: 'about',
    //                         type: 'string',
    //                         example: 'Senior Web Developer'
    //                     ),

    //                     new OA\Property(
    //                         property: 'gender',
    //                         type: 'string',
    //                         example: 'Male'
    //                     ),

    //                     new OA\Property(
    //                         property: 'dob',
    //                         type: 'string',
    //                         format: 'date',
    //                         example: '1995-05-10'
    //                     ),

    //                     new OA\Property(
    //                         property: 'location',
    //                         type: 'string',
    //                         example: 'Delhi'
    //                     ),

    //                     // Send as JSON string
    //                     new OA\Property(
    //                         property: 'hobbies',
    //                         type: 'string',
    //                         description: 'JSON encoded hobbies array',
    //                         example: '["Coding","Music"]'
    //                     ),

    //                     // Single image
    //                     new OA\Property(
    //                         property: 'image',
    //                         type: 'string',
    //                         format: 'binary'
    //                     ),

    //                     // Multiple files (IMPORTANT: use [])
    //                     new OA\Property(
    //                         property: 'media[]',
    //                         type: 'string',
    //                         format: 'binary',
    //                         description: 'Multiple media files'
    //                     ),

    //                     new OA\Property(
    //                         property: 'title',
    //                         type: 'string',
    //                         example: 'Full Stack Developer'
    //                     ),

    //                     new OA\Property(
    //                         property: 'skills',
    //                         type: 'string',
    //                         description: 'JSON encoded skills array',
    //                         example: '["Laravel","Vue","MySQL"]'
    //                     ),

    //                     new OA\Property(
    //                         property: 'skill_info',
    //                         type: 'string',
    //                         example: '5+ years experience in backend development'
    //                     ),

    //                     new OA\Property(
    //                         property: 'expert_bio',
    //                         type: 'string',
    //                         example: 'Helping startups build scalable systems'
    //                     ),

    //                     new OA\Property(
    //                         property: 'portfolio_gallery[]',
    //                         type: 'string',
    //                         format: 'binary'
    //                     ),

    //                     new OA\Property(
    //                         property: 'your_vibe[]',
    //                         type: 'string',
    //                         format: 'binary'
    //                     ),

    //                     new OA\Property(
    //                         property: 'files[]',
    //                         type: 'string',
    //                         format: 'binary'
    //                     ),

    //                     new OA\Property(
    //                         property: 'service_timing_type',
    //                         type: 'string',
    //                         enum: [
    //                             "No Hours Available",
    //                             "Always Open",
    //                             "Permanently Closed",
    //                             "Temporarily Closed",
    //                             "Open during selected hours"
    //                         ],
    //                         example: "Open during selected hours"
    //                     ),

    //                     // Send as JSON string
    //                     new OA\Property(
    //                         property: 'service_slots',
    //                         type: 'string',
    //                         description: 'JSON encoded service slots',
    //                         example: '[{"day":"Monday","start":"09:00","end":"18:00","type":"Open"},{"day":"Tuesday","start":"10:00","end":"17:00","type":"Open"}]'
    //                     ),
    //                 ]
    //             )
    //         )
    //     ),
    //     responses: [
    //         new OA\Response(
    //             response: 200,
    //             description: 'Profile updated successfully'
    //         ),
    //         new OA\Response(
    //             response: 422,
    //             description: 'Validation error'
    //         ),
    //         new OA\Response(
    //             response: 401,
    //             description: 'Unauthorized'
    //         )
    //     ]
    // )]
    public function update_profile(Request $request)
    {
        $user = Auth::user();

        // DB::beginTransaction();
        // try {
            $rules = [
                'user_type' => 'required|in:Personal,Professional',
                'name' => 'required|string|max:255',
                'username' => 'required|string|min:4|max:20|alpha_dash|unique:users,username,' . $user->id,
                'about' => 'nullable|string',
                'gender' => 'required|in:male,female,other',
                'dob' => 'required|date',
                'hobbies' => 'nullable|array',
                'hobbies.*' => 'string|max:50',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'media' => 'nullable|array',
                'media.*' => 'file|mimes:jpg,jpeg,png,mp4|max:10240',
                'location' => 'nullable|string|max:255',
            ];

            $userType = strtolower($request->user_type ?? 'personal');

            if ($userType == 'professional') {
                $rules = array_merge($rules, [
                    'title' => 'required|string|max:255',
                    'skills' => 'required|array|max:10',
                    'skills.*' => 'string|max:100',
                    'skill_info' => 'nullable|string',
                    'expert_bio' => 'required|string',
                    'portfolio_gallery' => 'nullable|array',
                    'portfolio_gallery.*' => 'nullable|mimes:jpg,jpeg,png|max:5120',
                    'files' => 'nullable|array',
                    'files.*' => 'file|max:5120',
                    'service_timing_type' => 'required|in:No Hours Available,Always Open,Permanently Closed,Temporarily Closed,Open during selected hours',
                    'service_slots' => 'required_if:service_timing_type,Open during selected hours|array',
                    'service_slots.*.day' => 'required_if:service_timing_type,Open during selected hours',
                    'service_slots.*.start' => 'required_if:service_timing_type,Open during selected hours',
                    'service_slots.*.end' => 'required_if:service_timing_type,Open during selected hours',
                    'service_slots.*.type' => 'required_if:service_timing_type,Open during selected hours',
                ]);
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->error(
                    $validator->errors()->first(),
                    $validator->errors()->toArray(),
                    422
                );
            }
            
            function uploadFiles($files, $folder)
            {
                $uploaded = [];

                if (!$files) {
                    return $uploaded;
                }

                if (!is_array($files)) {
                    $files = [$files];
                }

                $destinationPath = public_path('images/'.$folder);

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                foreach ($files as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $filename);
                    $uploaded[] = $filename;
                }

                return $uploaded;
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $user->code .'_'. time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/profile'), $filename);
                $user->image = $filename;
            }

            $mediaFiles = [];
            if ($request->hasFile('media')) {
                $mediaFiles = uploadFiles($request->file('media'), 'media');
            }

            $user->name = $request->name;
            $user->username = $request->username;
            $user->about = $request->about;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->hobbies = $request->hobbies ? json_encode($request->hobbies) : null;
            $user->user_type = $request->user_type;
            $user->location = $request->location;

            $user->save();

            if ($userType == 'professional') {

                $portfolio = [];
                if ($request->hasFile('portfolio_gallery')) {
                    $portfolio = uploadFiles($request->file('portfolio_gallery'), 'portfolio');
                }

                $vibe = [];
                if ($request->hasFile('your_vibe')) {
                    $vibe = uploadFiles($request->file('your_vibe'), 'vibe');
                }

                $docs = [];
                if ($request->hasFile('your_vibe')) {
                    $docs = uploadFiles($request->file('files'), 'docs');
                }

                $docs = uploadFiles($request->file('files'), 'docs');

                $professional = ProfessionalUser::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'title' => $request->title,
                        'skills' => json_encode($request->skills),
                        'skill_info' => $request->skill_info,
                        'expert_bio' => $request->expert_bio,
                        'portfolio_gallery' => json_encode($portfolio),
                        'your_vibe' => json_encode($vibe),
                        'files' => json_encode($docs),
                        'servic_timing' => $request->service_timing_type,
                    ]
                );

                ServiceTimeSlot::where('user_id', $user->id)->delete();

                if ($request->service_timing_type === 'custom') {
                    foreach ($request->service_slots as $slot) {
                        ServiceTimeSlot::create([
                            'user_id' => $user->id,
                            'day_of_week' => $slot['day'],
                            'start_time' => $slot['start'],
                            'end_time' => $slot['end'],
                            'type' => $slot['type'],
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'user' => $user,
                    'media' => $mediaFiles,
                ]
            ]);
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return response()->json([
        //         'status' => false,
        //         'message' => $e->getMessage()
        //     ], 500);
        // }
    }


    


    #[OA\Get(
        path: '/user-listing',
        operationId: 'listUsers',
        summary: 'List users with pagination',
        description: 'Get a paginated list of users filtered by user_type (personal or professional).',
        tags: ['User'],
        security: [['bearer' => []]],
        parameters: [
            new OA\Parameter(
                name: 'user_type',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', enum: ['personal', 'professional']),
                description: 'Type of user to filter (personal or professional)'
            ),
            new OA\Parameter(
                name: 'page',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 1),
                description: 'Page number for pagination'
            ),
            new OA\Parameter(
                name: 'per_page',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 10),
                description: 'Number of users per page'
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Paginated user list',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'User list fetched successfully.'),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'users', type: 'array', items: new OA\Items(type: 'object')), 
                                new OA\Property(property: 'pagination', type: 'object', description: 'Pagination details'),
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
                        new OA\Property(property: 'status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'Validation error'),
                        new OA\Property(property: 'errors', type: 'object'),
                    ]
                )
            ),
        ]
    )]
    public function user_listing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_type' => 'nullable|in:personal,professional',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return $this->error(
                $validator->errors()->first(),
                $validator->errors()->toArray(),
                422
            );
        }

        $type = $request->user_type ?? 'personal';
        $perPage = $request->per_page ?? 10;
        $users = User::where('user_type', $type)->paginate($perPage);

        return $this->success(
            'User list fetched successfully.',
            [
                'users' => $users->items(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                ]
            ]
        );
    }







    
    #[OA\Get(
        path: '/user-listing/{id}',
        operationId: 'getUserDetails',
        summary: 'Get user details by ID',
        description: 'Retrieve detailed information for a specific user by ID.',
        tags: ['User'],
        security: [['bearer' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                description: 'User ID'
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'User details',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: true),
                        new OA\Property(property: 'message', type: 'string', example: 'User details fetched successfully.'),
                        new OA\Property(property: 'data', type: 'object', description: 'User details'),
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'User not found',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', type: 'string', example: 'User not found.'),
                    ]
                )
            ),
        ]
    )]
    public function user_listing_details($id)
    {
        $user = User::with(['address', 'media', 'professionalProfile', 'wallet'])
            ->where('id', $id)
            ->first();

        if (!$user) {
            return $this->error('User not found.', [], 404);
        }
        return $this->success('User details fetched successfully.', $user->toArray());
    }



    

    // public function dashboard(Request $request)
    // {
    //     $request->validate([
    //         'user_type' => 'nullable|in:personal,professional',
    //     ]);

    //     $user = User::with('wallet')->find(Auth::id());

    //     if (!$user) {
    //         return response()->json([
    //             'status' => 401,
    //             'message' => 'Unauthorized',
    //         ], 401);
    //     }

    //     ########### switch profile type ############
    //     if ($request->filled('user_type')) {
    //         $user->user_type = $request->user_type;
    //         $user->save();
    //     }

    //     if ($user->user_type === 'professional') {

    //         $professionalProfile = ProfessionalUser::where('user_id', $user->id)->first();

    //         return response()->json([
    //             'type' => 'professional',
    //             'user' => $professionalProfile,
    //             'wallet' => $user->wallet,
    //         ]);
    //     }

    //     return response()->json([
    //         'type' => 'personal',
    //         'user' => $user,
    //     ]);
    // }

    
    // public function update_professional_profile(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'title' => 'required|string|max:255',
    //         'about' => 'required|string|max:1000',
    //         'skills' => 'required|array',
    //         'skills.*' => 'string|max:50',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 400,
    //             'message' => $validator->errors()->first(),
    //             'errors' => $validator->errors(),
    //         ]);
    //     }

    //     $user = Auth::user();
    //     if (!$user) {
    //         return response()->json([
    //             'status' => 401,
    //             'message' => 'Unauthorized',
    //         ]);
    //     }

    //     ProfessionalUser::updateOrCreate(
    //         ['user_id' => $user->id],
    //         [
    //             'title' => $request->title,
    //             'about' => $request->about,
    //             'skills' => $request->skills,
    //         ]
    //     );

    //     return response()->json([
    //         'status' => 200,
    //         'message' => 'Professional profile updated successfully',
    //         'data' => ProfessionalUser::where('user_id', $user->id)->first(),
    //     ]);
    // }

    // public function sendAadhaarOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'aadhar_number' => 'required|digits:12'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $validator->errors()->first(),
    //             'errors' => $validator->errors(),
    //         ], 400);
    //     }

    //     $user = Auth::user();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Unauthorized'
    //         ], 401);
    //     }
    //     if (Kyc::where('aadhar_number', $request->aadhar_number)->where('status', 'Verified')->exists()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Aadhaar number already verified'
    //         ], 422);
    //     }
    //     $otp = 123456;

    //     Kyc::updateOrCreate(
    //         ['user_id' => $user->id],
    //         [
    //             'aadhar_number' => $request->aadhar_number,
    //             'otp' => $otp,
    //             'otp_expires_at' => now()->addMinutes(10),
    //             'status' => 'Pending',
    //             'remarks' => null
    //         ]
    //     );
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'OTP sent to Aadhaar registered mobile number'
    //     ]);
    // }

    // public function verifyAadhaarOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'otp' => 'required|digits:6'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $validator->errors()->first(),
    //             'errors' => $validator->errors(),
    //         ], 400);
    //     }

    //     $user = Auth::user();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Unauthorized'
    //         ], 401);
    //     }

    //     $kyc = Kyc::where('user_id', $user->id)
    //         ->where('otp', $request->otp)
    //         ->where('otp_expires_at', '>', now())
    //         ->first();

    //     if (!$kyc) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid or expired OTP'
    //         ], 422);
    //     }

    //     $kyc->update([
    //         'status' => 'Verified',
    //         'otp' => null,
    //         'otp_expires_at' => null
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Aadhaar verified successfully'
    //     ]);
    // }

    // public function sendPanOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'pan_number' => [
    //             'required',
    //             'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'
    //         ]
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $validator->errors()->first()
    //         ], 422);
    //     }

    //     $user = Auth::user();
    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Unauthorized'
    //         ], 401);
    //     }
    //     if (Kyc::where('pan_number', strtoupper($request->pan_number))->where('pan_status', 'Verified')->exists()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'PAN number already verified'
    //         ], 422);
    //     }
    //     $otp = rand(100000, 999999);
    //     $otp = 123456;

    //     Kyc::updateOrCreate(
    //         ['user_id' => $user->id],
    //         [
    //             'pan_number' => strtoupper($request->pan_number),
    //             'otp' => $otp,
    //             'otp_expires_at' => now()->addMinutes(10),
    //             'pan_status' => 'Pending',
    //             'remarks' => null
    //         ]
    //     );

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'OTP sent to PAN registered mobile number',
    //         'otp' => $otp
    //     ]);
    // }
    // public function verifyPanOtp(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'otp' => 'required|digits:6'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $validator->errors()->first()
    //         ], 422);
    //     }

    //     $user = Auth::user();
    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Unauthorized'
    //         ], 401);
    //     }
    //     $kyc = Kyc::where('user_id', $user->id)->first();

    //     if (!$kyc) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'KYC record not found'
    //         ]);
    //     }

    //     $kyc = Kyc::where('user_id', $user->id)
    //         ->where('otp', $request->otp)
    //         ->where('otp_expires_at', '>', now())
    //         ->first();

    //     if (!$kyc) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid or expired OTP'
    //         ], 200);
    //     }

    //     $kyc->update([
    //         'otp' => null,
    //         'otp_expires_at' => null,
    //         'pan_status' => 'Verified'
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'PAN verified successfully'
    //     ]);
    // }
}
