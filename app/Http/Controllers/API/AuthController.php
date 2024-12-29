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
use Illuminate\Support\Facades\DB;
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
     *              required={"email","password"},
     *              @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password2"),
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
            'email' => 'required|string|email|unique:users,email',
            'password' => ['required', 'string', 'min:8']
        ]);

        if ($validator->fails()) {
            return response([
                'message' => $validator->errors()
            ], 400);
        }
        try {
            DB::beginTransaction();
            $user = User::create([
                'email' => $fields['email'],
                'password' => Hash::make($fields['password']),
                'state_id' => User::STATE_ACTIVE,
                'role' => User::ROLE_USER,
            ]);
            $token = $user->createToken('authToken')->plainTextToken;
            $user->update(['access_token' => $token]);
            DB::commit();
            return response([
                'message' => 'User Registered Successfully',
                // 'access_token' => $token,
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response([
                'message' => 'Something went wrong during registration',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     *
     * @OA\Post(
     * path="/user/register-provider",
     * operationId="registerProvider",
     * tags={"users"},
     * summary="Register a new provider",
     * description="Register a new provider with additional details",
     * security={{ "basicAuth": {} }},
     *      @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"first_name","last_name","email","password","confirm_password","bio","dob","phone","id_proof_1","id_proof_2"},
     *              @OA\Property(property="first_name", type="string", example="John"),
     *              @OA\Property(property="last_name", type="string", example="Doe"),
     *              @OA\Property(property="phone", type="string", example="1234567890"),
     *              @OA\Property(property="email", type="string", format="email", example="provider@mail.com"),
     *              @OA\Property(property="dob", type="string", format="date", example="1990-01-01"),
     *              @OA\Property(property="bio", type="string", example="Experienced provider"),
     *              @OA\Property(property="password", type="string", format="password", example="password123"),
     *              @OA\Property(property="confirm_password", type="string", format="password", example="password123"),
     *              @OA\Property(property="id_proof_1", type="file", description="Id proof to upload"),
     *              @OA\Property(property="id_proof_2", type="file", description="Id proof to upload"),
     *              @OA\Property(description="Profile file to upload",property="profile_picture",type="file"),
     * 
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
     *          @OA\Property(property="message", type="string", example="provider register successfully"),
     *          @OA\Property(property="provider", type="string", example="Provider details"),
     *      )
     *     ),
     * )
     */
    public function registerProvider(Request $request)
    {
        $fields = $request->all();

        $validator = Validator::make($fields, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string|unique:users,phone',
            'email' => 'required|string|email|unique:users,email',
            'dob' => 'required|date',
            'bio' => 'nullable|string',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:password',
            'id_proof_1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_proof_2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response([
                'message' => $validator->errors()
            ], 400);
        }

        try {
            DB::beginTransaction();

            $imageName = null;
            if ($request->hasFile('profile_picture')) {
                $imageName = date('Ymd') . '_' . time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();
                $request->file('profile_picture')->move(public_path('uploads/'), $imageName);
            }

            $idProof1Name = null;
            $idProof2Name = null;
            if ($request->hasFile('id_proof_1')) {
                $idProof1Name = date('Ymd') . '_' . time() . '.' . $request->file('id_proof_1')->getClientOriginalExtension();
                $request->file('id_proof_1')->move(public_path('uploads/idproof/'), $idProof1Name);
            }

            if ($request->hasFile('id_proof_2')) {
                $idProof2Name = date('Ymd') . '_' . time() . '.' . $request->file('id_proof_2')->getClientOriginalExtension();
                $request->file('id_proof_2')->move(public_path('uploads/idproof/'), $idProof2Name);
            }

            $provider = User::create([
                'first_name' => $fields['first_name'],
                'last_name' => $fields['last_name'],
                'name' => $fields['first_name'] . ' ' . $fields['last_name'],
                'phone' => $fields['phone'],
                'email' => $fields['email'],
                'dob' => $fields['dob'],
                'bio' => $fields['bio'],
                'password' => Hash::make($fields['password']),
                'state_id' => User::STATE_INACTIVE,
                'role' => User::ROLE_SERVICE_PROVIDER,
                'id_proof_1' => isset($idProof1Name) ? $idProof1Name : null,
                'id_proof_2' => isset($idProof2Name) ? $idProof2Name : null,
                'image' => $imageName,
            ]);

            $token = $provider->createToken('authToken')->plainTextToken;
            $provider->update(['access_token' => $token]);

            DB::commit();
            return response([
                'message' => 'Provider Registered Successfully',
                'provider' => $provider,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response([
                'message' => 'Something went wrong during provider registration',
                'error' => $e->getMessage(),
            ], 500);
        }
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
     *              @OA\Property(property="password", type="string", format="password", example="password2"),
     *              @OA\Property(property="email", type="email", format="email", example="user1@mail.com"),
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

        if (!empty($user)) {
            if ($user->state_id == User::STATE_INACTIVE) {
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

        if ($user) {
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
     *     path="/user/check",
     *     operationId="userCheck",
     *     tags={"users"},
     *     summary="Check if the user is authenticated",
     *     security={{ "sanctum": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="User Data!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Data not found!")
     *         )
     *     )
     * )
     */
    public function userCheck(Request $request)
    {
        $token = $request->bearerToken();

        if ($token) {
            $user = User::where('access_token', $token)->first();

            if ($user) {
                return response(['details' => $user], 200);
            } else {
                return response()->json([
                    'message' => 'Invalid token or user not found.'
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Unauthenticated. Token not found.'
            ], 403);
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
            $user = User::where('email', $request->email)->first();

            if (empty($user)) {
                return response([
                    'message' => 'User does not exists!',

                ], 400);
            }

            if ($user->getResetUrl()) {
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
     *   @OA\Property(property="phone_number", type="numbrer", example="7018285882"),
     *   @OA\Property(property="first_name", type="string", example="arun"),
     *   @OA\Property(property="last_name", type="string", example="kumar"),
     *   @OA\Property(property="country_code", type="string", example="91"),
     *   @OA\Property(property="country", type="number", example="india"),
     *   @OA\Property(property="dob", type="string", format="date", example="1988-01-01"),
     *   required={"profile_picture","dob","first_name","last_name"} )),
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
            'dob' => 'required|date|before:today',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response([
                'message' => $validator->errors()
            ], 400);
        }

        $checkPhone = User::where('phone', $request->phone_number)->where('id', '!=', Auth::user()->id)->first();
        if ($checkPhone) {
            return response([
                'message' => 'The phone number has already been taken',
            ], 400);
        }

        if ($request->phone_number == $user->phone) {
            if ($request->phone_number == Auth::user()->phone) {
            }
        }

        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->dob = $request->dob;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone_number;

        if ($request->hasFile('profile_picture')) {
            $imageName = date('Ymd') . '_' . time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();
            $request->profile_picture->move(public_path('uploads/'), $imageName);
            $user->image = $imageName;
        }

        if ($user->save()) {

            $user = User::where('id', Auth::user()->id)->first();
            // $user->is_complete = 1;
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

        if ($validator->fails()) {
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
}
