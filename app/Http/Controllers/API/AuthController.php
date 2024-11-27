<?php
namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\DeviceDetail;
use App\Models\PhonePassowrd;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\currentAcesssToken;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Dotunj\LaraTwilio\Facades\LaraTwilio;
use Twilio\Exceptions\TwilioException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Mail\sendPasswordResetLink;
use App\Mail\verification;
use Modules\Smtp\Entities\EmailQueue;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Modules\Page\Entities\Page;
use App\Models\Address;
use Mailgun\Mailgun;

class AuthController extends Controller
{

    /**
     *
     * @OA\Post(
     * path="/user/register",
     * operationId="userRegister",
     * tags={"users"},
     * summary="user register",
     * description="user register",
     * security={{ "basicAuth": {} }},
     *      @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"email","password","role"},
     *              @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password2"),
     *              @OA\Property(property="role", type="integer", format="role 1 for service provider and 2 for user", example="1"),
     *           ),
     *       ),
     *   ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Validator Error"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Authentication Error",
     *    @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Something went wrong"),
     *      )
     *     ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="User register successfully"),
     *          @OA\Property(property="user", type="string", example="User details"),
     *      )
     *     ),
     * )
     */
    public function register(Request $request)
    {
        $fields = $request->all();
        
        $validator = Validator::make($fields, [
            // 'first_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            // 'last_name' => 'required|string',
            'password' => ['required','string','min:8'],
            'role' => 'required|integer'
        ]);
        
        if ($validator->fails())
        {
            return response([
                'message' => $validator->errors()
            ], 400);
        }
        
        
        $createUSer = [
            // 'name' => $fields['first_name'] . ' ' . $fields['last_name'],
            // 'first_name' => $fields['first_name'],
            // 'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'role' => 1,
            'password' => Hash::make($request['password']),
            // 'customer_id' => 'ch_testcustomer',
            'state_id' => User::STATE_ACTIVE,
        ];
        // $verify_code = Crypt::encryptString($request['email']);
        //  $mail = Mail::to($fields['email'])->send(new verification($verify_code));
        if ($user = User::create($createUSer)) {
            $response = [
                'user' => $user,
            ];
            return response([
                'message' => 'User Registered Successfully',
                'details' => $user
                
            ], 200);
            return response($response, 200);
        }

        return response([
            'message' => 'Some Thing Went Wrong'
        ], 404);
        
    }

    /**
     *
     * @OA\Post(
     * path="/user/login",
     * operationId="userLogin",
     *
     * tags={"users"},
     * summary="user login",
     * description="user login",
     * security={{ "basicAuth": {} }},
     *      @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"email","password","device_token","device_name","device_type"},
     *              @OA\Property(property="password", type="string", format="password", example="admin@123"),
     *              @OA\Property(property="email", type="email", format="email", example="rohit@gmail.in"),
     *              @OA\Property(property="device_token", type="string", format="string", example="DVtoken"),
     *              @OA\Property(property="device_name", type="string", format="string", example="DVname"),
     *              @OA\Property(property="device_type", type="integer", format="string", example="1")
     *           ),
     *       ),
     *   ),
     *
     * @OA\Response(
     *    response=422,
     *    description="Validator Error"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Authentication Error",
     *    @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Something went wrong"),
     *      )
     *     ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="login successfully"),
     *          @OA\Property(property="user", type="string", example="User details"),
     *      )
     *     ),
     * )
     */
    public function login(Request $request)
    {
        $fields = $request->all();

        $validator = Validator::make($fields, [
            'email' => 'required',
            'password' => 'required|string',
            'device_token' => 'required|string',
            'device_name' => 'required|string',
            'device_type' => 'required|integer',
        ]);
        
        if ($validator->fails()) {

            return response([
                'message' => $validator->errors()
            ], 422);
        }
        
        

        $user = User::where('email', $fields['email'])->first();
        
        if(!empty($user)) {
            if($user->state_id == User::STATE_INACTIVE) {
                return response([
                    'message' => 'You are currently inactive'
                ], 400);
            }
        }

        // Check password
        if (! $user || ! Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Password or Email is Incorrect!'
            ], 400);
        }

        $token = $user->createToken('authToken')->plainTextToken;
        $response = [
            'details' => $user,
            'token' => $token
        ];  

        if($user)
        {
            // Device Details Add on Login
            $deviceDetails = [
                'device_token' => $fields['device_token'],
                'device_name' => $fields['device_name'],
                'device_type' => $fields['device_type'],
                'access_token' => $token,
                'type_id' => $fields['device_type'],
                'created_by_id' => $user->id
            ];
            
            $device = DeviceDetail::create($deviceDetails);
            return response([
                'message' => 'Logged In Successfully',
                'details' => $user,
                'token' => $token
            ], 200);
        }
        return response($response, 200);
    }
    
     
    
    /**
     * @OA\Get(
     *      path="/user/check",
     *      operationId="userCheck",
     *      tags={"users"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="User Data!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="data Not Found!"),
     *        )
     * ),
     * )
     */
    
    
    public function userCheck(Request $request)
    {
        
        $DeviceDetail = DeviceDetail::where('access_token', $request->bearerToken())->first();
        if($DeviceDetail && $request->bearerToken()){
            $user = User::find($DeviceDetail->created_by_id);

            if($user){
                return response(['details' => $user], 200);
            } else {
                return response()->json([
                    'message' => 'User Not Found'
                ], 404);
            }    
        } else {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 403);
        }

 
    }

    /**
     *
     * @OA\post(
     * path="/user/verify_otp",
     * summary="user otp verification",
     * description="user verify",
     * operationId="user_verify_otp",
     * tags={"users"},
     * security={{ "basicAuth": {} }},
     *      @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"otp","phone","country_code"},
     *              @OA\Property(property="otp", type="integer", format="number", example="1234"),
     *              @OA\Property(property="phone", type="string", format="number", example="34534534535",description="conatct number"),
     *              @OA\Property(property="country_code", type="integer", format="number", example="91",description="country code"),
     *           ),
     *       ),
     *   ),
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Otp verified"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     * )
     */
    public function verifyOtp(Request $request)
    {
        if (! ($request->has('phone'))) {
            return response([
                "status" => 422,
                'message' => 'phone number is required'
            ]);
        }
        if (! $request->has('otp')) {
            return response([
                "status" => 422,
                'message' => 'otp is required'
            ]);
        }

        $user = User::where('phone', $request->phone)->first();

        if ($user) {
            if ($user->otp == $request->otp) {
                $user->otp_verified = 1;
                $user->save();

                $accessToken = $user->createToken('access_token')->plainTextToken;

                return response()->json([
                    'details' => $user,
                    'token' => $accessToken
                ], 200);
            } else {
                return response()->json([
                    'message' => 'The code your provided is wrong.'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'No such account found .'
            ], 401);
        }
    }

    /**
     *
     * @OA\post(
     * path="/user/password/forgot",
     * summary="user forget password",
     * description="user forget password",
     * operationId="user_forget_password",
     * tags={"users"},
     * security={{ "basicAuth": {} }},
     *      @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"email"},
     *              @OA\Property(property="email", type="email", format="email", example="rohit@gmail.com")
     *           ),
     *       ),
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="We have emailed you password reset link!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     * )
     */
    public function sendPasswordResetLink(Request $request)
    {
        if ($request->has('email')) {

            $request->validate([
                'email' => 'required|email'
            ]);
            $user = User::where('email' ,$request->email)->first();

            if(empty($user)){
                return response([
                    'message' => 'User does not exists!',
                    
                ], 400);
            }

            if($user->getResetUrl()){
                // send resetpasswordlink
                //   $res = Mail::to($request->email)->send(new sendPasswordResetLink($user->password_reset_token));

                return response([
                    'message' => 'Mail has been sent to you with reset link. Please check your mail.'
                    
                ], 200);

            } else {
                return response([
                    'message' => 'Something went wrong'
                    
                ], 401);
            }
            
          
        }
    }

    /**
     *
     * @OA\Post(
     * path="/user/resend_otp",
     * summary="user resend otp",
     * description="user reset otp",
     * operationId="userReset",
     * tags={"users"},
     * security={{ "basicAuth": {} }},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"otp"},
     * @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     * @OA\Property(property="phone_number", type="string", example="123455"),
     * @OA\Property(property="otp", type="string", example="1234"),
     *   )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Otp is sent successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     * )
     */
    public function resendOtp(Request $request)
    {
        if ($request->has('email')) {

            $fields = $request->validate([
                'email' => 'required|string|email|email:rfc,dns'
            ]);

            $user = User::where('email', $fields['email'])->first();
        } else if ($request->has('phone_number')) {

            $fields = $request->validate([
                'phone_number' => 'required|string'
            ]);

            $user = User::where('phone_number', $fields['phone_number'])->first();
        }
        if ($user) {
            $user->otp = mt_rand(10000, 99999);

            if ($user->save()) {

                if ($request->has('email')) {

                    $mail_details = [
                        'subject' => 'Register Application OTP',
                        'body' => 'Your OTP is : ' . $user->otp
                    ];

                    try {

                        // Mail::to($request->email)->send(new MailNotify($mail_details));
                        $responseMessage = 'OTP sent to ' . $user->email;
                    } catch (\Exception $e) { // Using a generic exception
                        $responseMessage = $e->getMessage();
                    }

                    $response = [
                        'message' => $responseMessage
                    ];
                } else if ($request->has('phone_number')) {

                    $message = 'Your OTP is : ' . $user->otp;

                    try {

                        // LaraTwilio::notify($request->phone_number, $message);
                        $responseMessage = 'OTP sent to ' . $user->phone_number;
                    } catch (TwilioException $e) {

                        $responseMessage = $e->getMessage();
                    }

                    $response = [
                        'message' => $responseMessage
                    ];
                }
            } else {

                return response([
                    'message' => 'Something Went Wrong'
                ], 401);
            }
            return response($response, 201);
        }
        return response([
            'message' => 'User does not exists!'
        ], 404);
    }

    /**
     *
     * @OA\Post(
     * path="/user/profile/update",
     * summary=" user profile update",
     * description="user profile update",
     * operationId="userProfileUpdate",
     * tags={"users"},
     * security={{ "sanctum": {} }},
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     *   mediaType="multipart/form-data",
     *   @OA\Schema(
     *   @OA\Property(description="file to upload",property="profile_picture",type="file"),
     *   @OA\Property(property="phone_number", type="string", example="123455"),
     *   @OA\Property(property="first_name", type="string", example="arun"),
     *   @OA\Property(property="last_name", type="string", example="kumar"),
     *   @OA\Property(property="country_code", type="string", example="91"),
     *   @OA\Property(property="country", type="number", example="india"),
     *   @OA\Property(property="gender", type="number", example="1" ,description=" 1 for male and 2 for female"),
     *   @OA\Property(property="dob", type="string", format="date", example="1988-01-01"),
     *   @OA\Property(property="address_one", type="string", example="address_one"),
     *   @OA\Property(property="address_two", type="string", example="address_two"),
     *   @OA\Property(property="state", type="string", example="state"),
     *   @OA\Property(property="city", type="string", example="cityName"),
     *   @OA\Property(property="zip", type="string",  example="zip"),
     *   required={"profile_picture","dob","phone_number","first_name","last_name","country_code","country","gender"} )),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Profile  Updated successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401, 
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     * )
     */
    
    public function profileUpdate(Request $request)
    {
        
        $user = User::where('id', Auth::user()->id)->first();
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'gender' => 'required',
            'dob' => 'required|date|before:today',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'country_code' => 'required|string',
        ]);
       
        if ($validator->fails()) 
        {
            return response([
                'message' => $validator->errors()
            ], 400);
        }

        $checkPhone = User::where('phone', $request->phone_number)->where('id', '!=', Auth::user()->id)->first();
        if($checkPhone){
            return response([
                'message' => 'The phone number has already been taken',
            ], 400);
        }

        if($request->phone_number == $user->phone){
            if($request->phone_number == Auth::user()->phone){

            }
        } 

        $user->gender = $request->gender;
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->dob = $request->dob;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->country_code = $request->country_code;
        $user->phone = $request->phone_number;
        $user->address = $request->address_one;
        $user->address_two = $request->address_two;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->zip = $request->zip;
        
        if ($request->hasFile('profile_picture')) {
            $imageName = date('Ymd') . '_' . time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();
            $request->profile_picture->move(public_path('uploads/'), $imageName);
            $user->image = $imageName;
        }

        if ($user->save()) {

            $user = User::where('id', Auth::user()->id)->first();
            $user->is_complete = 1;
            $user->save();

            return response()->json([
                "message" => "Profile updated successfully",
                'details' => $user
            ], 200);
        }

        return response([
            'message' => 'User does not exists!'
        ], 404);
    }

    /**
     *
     * @OA\Post(
     * path="/user/change-password",
     * summary=" user change password",
     * description="user change password",
     * operationId="userChangePassword",
     * tags={"users"},
     * security={{ "sanctum": {} }},
     *      @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"old-password","password","password_confirmation"},
     *              @OA\Property(property="old-password", type="string", format="password", example="secret123"),
     *              @OA\Property(property="password", type="string", format="password", example="secret1234"),
     *              @OA\Property(property="password_confirmation", type="string", format="password", example="secret1234"),
     *           ),
     *       ),
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Password  Updated successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     * )
     */
    public function changePassword(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $fields = $request->all();
        $validator = Validator::make($fields, [
            'old-password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (! Hash::check($value, $user->password)) {
                        $fail('Old password does not match.');
                    }
                }
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
            'password_confirmation' => 'required|same:password'
        ]);
       
        if ($validator->fails())
        {
            return response([
                'message' => $validator->errors()
            ], 400);
        }

        if ($request['old-password']  == $request['password']) {
            return response()->json([
                "message" => "Old Password and New Password cannot be same",
            ], 400);
        }

        $user->password = Hash::make($request['password']);
        if ($user->save()) {
            return response()->json([
                "message" => "Password changed successfully",
                'user' => $user
            ], 200);
        }
    }
        
    
    /**
     * @OA\Get(
     * path="/user/logout",
     * operationId="userLogout",
     * tags={"users"},
     * security={{ "sanctum": {} }},
     * summary="",
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="User Data!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="data Not Found!"),
     *        )
     * ),
     * )
     */
    
    public function logout(Request $request)
    {

        $user_id = Auth::user()->id;
        $device_token = $request->bearerToken();

        // delete on 'user_device_tokens'
        DeviceDetail::where('created_by_id', $user_id)->where('device_token', $device_token)->delete();

        return response(['message' => 'You have been successfully logged out!'], 200);

    }
    /**
     *
     * @OA\Get(path="/user/page",
     *   summary="",
     *   tags={"users"},
     *   @OA\Parameter(
     *     name="type",
     *     in="query",description="
     *       TYPE_PRIVACY = 1,
     *       TYPE_TERM_CONDITION = 2,
     *       TYPE_ABOUT_US = 3,
     * " ,
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="page info",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *
     *     ),
     *   ),
     * )
     */
 
    public function page(Request $request)
    {
        $model = Page::Where('type_id', $request->type)->first();
        if ($model) {
            return response([
                "title" => $model->title,
                "description" => $model->description,
            ], 200);
        } else {
            if(Page::TERMS_CONDITION == $request->type){
                $page = "Terms & Condition";
            } elseif(Page::PRIVACY_POLICY == $request->type){
                $page = "Privacy Policy";
            } else {
                $page = "About Us";
            }
            return response([
                "message" => "page not Found, info will be available soon",
            ], 200);
        }
    }
    
    /**
     * @OA\Post(
     *      path="/user/address/add",
     *      operationId="addAddress",
     *      tags={"users"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *
     *   @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"address","city","state","country","postal_code","longitude","latitude","address_type"},
     *              @OA\Property(property="address", type="string", example="address"),
     *              @OA\Property(property="address_two", type="string", example="address_two"),
     *              @OA\Property(property="city", type="string", example="city"),
     *              @OA\Property(property="state", type="string", example="state"),
     *              @OA\Property(property="country", type="string", example="countryName"),
     *              @OA\Property(property="postal_code", type="integer",  example="112233"),
     *              @OA\Property(property="longitude", type="string", example="-25.89"),
     *              @OA\Property(property="latitude", type="string", example="126.79"),
     *              @OA\Property(property="address_type", type="integer",  example="0 for home 1 for office"),
     *           ),
     *       ),
     *   ),
     *
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Address Added successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    
    public function addAddress(Request $request) 
    {
        
        $addressType = [0,1];
        
        $validator = validator($request->all(), [
            'address' => 'required',
            'city' => 'required',
            'address_two' => 'nullable',
            'state' => 'required',
            'country' => 'required',
            'postal_code' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address_type' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        
        if (!in_array($request->address_type, $addressType)) {
            
            return response([
                "status" => 422,
                'message' => 'Address type not found'
            ]);
        }


        $address = new Address();
        $address->user_id = Auth::user()->id;
        $address->address = $request->address;
        $address->address_two = $request->address_two;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->postal_code = $request->postal_code;
        $address->latitude = $request->latitude;
        $address->longitude = $request->longitude;
        $address->address_type = $request->address_type;
        $address->save();
        
        if($address->save()) {
            return response([
                'message' => 'Success, Your address has been added',
                'detail'=>$address
            ], 200);
        } else {
            return response([
                'message' => 'unexpected error occurred'
            ], 404);
        }
    }
    
    /**
     *
     * @OA\Get(
     *      path="/user/address-list",
     *      operationId="AddressList",
     *      tags={"users"},
     *      summary="",
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="user_id", type="integer", example="1"),
     *           @OA\Property(property="address", type="string", example="address"),
     *           @OA\Property(property="address_two", type="string", example="address two"),
     *           @OA\Property(property="city", type="string", example="city"),
     *           @OA\Property(property="state", type="string", example="state"),
     *           @OA\Property(property="country", type="string", example="country"),
     *           @OA\Property(property="postal_code", type="string", example="115577"),
     *           @OA\Property(property="latitude", type="string", example="-124.56"),
     *           @OA\Property(property="longitude", type="string", example="25.89"),
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function addressDetail(Request $request) {
        
        $currentUser = Auth::user()->id;
        
        if(!empty($currentUser)) {
            
            $getAddress = Address::where('user_id',$currentUser)->get();
            
            return response([
                'message' => 'Address List',
                'list'=>$getAddress
            ], 200);
            
        }
    }
    
    
    /**
     *
     * @OA\Get(
     *      path="/user/address/delete",
     *      operationId="AddressDelete",
     *      tags={"users"},
     *      summary="",
     *      @OA\Parameter(
     *          name="address_id",
     *          description="address id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Service object",
     *           @OA\JsonContent(
     *           @OA\Property(property="message", type="string", example="Address Deleted Successfully"),
     *
     *     )
     * ),
     *
     * @OA\Response(
     *    response=400,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     *     )
     */
    
    public function addressDelete(Request $request) {
        $address = Address::query();
        
        $addressId = $request->address_id;
        
        $user = Auth::user()->id;
        
        if(empty($user)) {
            return response([
                'message' => 'Login to delete address'
            ], 404);
        }
        
        
        
        if(!empty($addressId)) {
            $getAddress = $address->where([
                ['id','=',$addressId],
                ['user_id','=',$user],
            ])->first();
            
            if(!empty($getAddress)) {
                $getAddress->delete();
                
                return response([
                    'message' => 'Address deleted successfully',
                ], 200);
            } else {
                return response([
                    'message' => 'Something went wrong'
                ], 404);
            }
        } else {
            return response([
                'message' => 'Something went wrong'
            ], 404);
        }
    }
    
    /**
     * @OA\Post(
     *      path="/user/address/update",
     *      operationId="updateAddress",
     *      tags={"users"},
     *      security={{ "sanctum": {} }},
     *      summary="",
     *
     *
     *   @OA\RequestBody(
     *
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"address_id","address","city","state","country","postal_code","longitude","latitude","address_type"},
     *              @OA\Property(property="address_id", type="integer", example="1"),
     *              @OA\Property(property="address", type="string", example="address"),
     *              @OA\Property(property="address_two", type="string", example="address_two"),
     *              @OA\Property(property="city", type="string", example="city"),
     *              @OA\Property(property="state", type="string", example="state"),
     *              @OA\Property(property="country", type="string", example="countryName"),
     *              @OA\Property(property="postal_code", type="integer",  example="112233"),
     *              @OA\Property(property="longitude", type="string", example="-25.89"),
     *              @OA\Property(property="latitude", type="string", example="126.79"),
     *              @OA\Property(property="address_type", type="integer",  example="0 for home 1 for office"),
     *           ),
     *       ),
     *   ),
     *
     *
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Address Updated successfully!"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Not Found",
     *    @OA\JsonContent(
     *    @OA\Property(property="status", type="integer", example="Something went wrong"),
     *        )
     * ),
     * @OA\Response(
     *    response=403,
     *    description="Forbidden",
     *    @OA\JsonContent(
     *    @OA\Property(property="message", type="string", example="Something went wrong"),
     *    )
     *  ),
     * )
     */
    
    public function addressUpdate(Request $request) {
        $address = Address::query();
        
        $addressType = [0,1];
        
        $currentUser = Auth::user()->id;
        
        $validator = validator($request->all(), [
            'address_id' => 'required|integer',
            'address' => 'required',
            'city' => 'required',
            'address_two' => 'nullable',
            'state' => 'required',
            'country' => 'required',
            'postal_code' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address_type' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            
            return response([
                "status" => 422,
                'message' => $validator->errors()
            ]);
        }
        
        $addressId = $request->address_id;
        
        if (!in_array($request->address_type, $addressType)) {
            
            return response([
                "status" => 422,
                'message' => 'Address type not found'
            ]);
        }
        
        $addressUpdate = $address->where([
            ['id','=',$addressId],
            ['user_id','=',$currentUser],
        ])->limit(1)->update([
            'address'      => $request->address,
            'address_two'  => $request->address_two,
            'city'         => $request->city,
            'state'        => $request->state,
            'country'      => $request->country,
            'postal_code'  => $request->postal_code,
            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,
            'address_type' => $request->address_type
        ]);
        
        if($addressUpdate) {
            return response([
                'message' => 'Address Updated Successfully',
            ], 200);
        } else {
            return response([
                'message' => 'Something went wrong'
            ], 404);
        }
    }
}
