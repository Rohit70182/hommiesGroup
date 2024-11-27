// <?php
// namespace App\Http\Controllers\API;

// // use App\Models\User;
// use Modules\Stripe\Entities;
// // use App\Models\PhonePassowrd;
// use Illuminate\Support\Facades\Mail;
// // use App\Mail\MailNotify;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Dotunj\LaraTwilio\Facades\LaraTwilio;
// use Twilio\Exceptions\TwilioException;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;
// use App\Http\Controllers\Controller;
// // use Modules\Smtp\Entities\EmailQueue;
// use Illuminate\Support\Facades\Redirect;

// class StripeCardsController extends Controller
// {
//     /**
//      *
//      * @OA\Post(
//      * path="/card/add",
//      * operationId="cardAdd",
//      * tags={"card"},
//      * summary="card add",
//      * description="card add",
//      * security={{ "basicAuth": {} }},
//      *      @OA\RequestBody(
//      *       @OA\MediaType(
//      *           mediaType="multipart/form-data",
//      *           @OA\Schema(
//      *              required={"card_number","card_month","card_year","card_cvc"},
//      *              @OA\Property(property="card_number", type="string", format="number", example="1212 5858 6565"),
//      *              @OA\Property(property="card_month", type="string", format="number", example="06"),
//      *              @OA\Property(property="card_year", type="string", format="number", example="2025"),
//      *              @OA\Property(property="card_cvc", type="string", format="number", example="321")
//      *           ),
//      *       ),
//      *   ),
//      *
//      * @OA\Response(
//      *    response=422,
//      *    description="Validator Error"
//      *     ),
//      * @OA\Response(
//      *    response=401,
//      *    description="Authentication Error",
//      *    @OA\JsonContent(
//      *          @OA\Property(property="message", type="string", example="Something went wrong"),
//      *      )
//      *     ),
//      * @OA\Response(
//      *    response=200,
//      *    description="Success",
//      *    @OA\JsonContent(
//      *          @OA\Property(property="message", type="string", example="OTP sent to user@gmail.com"),
//      *          @OA\Property(property="user", type="string", example="User details"),
//      *      )
//      *     ),
//      * )
//      */
//     public function store(Request $request)
//     {
//         $fields = $request->all();

//         $validator = Validator::make($fields, [
//             'card_number' => 'required|string',
//             'card_month' => 'required|string',
//             'card_year' => 'required|string',
//             'card_cvc' => 'required|string'
//         ]);
//         if ($validator->fails()) {
//             return response([
//                 "status" => 422,
//                 'message' => $validator->errors()
//             ]);
//         }
//         $addCard= [
//             'card_number' => $fields['card_number'],
//             'card_month' => $fields['card_month'],
//             'card_year' => $fields['card_year'],
//             'card_cvc' => $fields['card_cvc']
//         ];

// //         $createUSer['otp'] = mt_rand(1000, 9999);

// //         if ($card = User::create($addCard)) 
// //         {

// //             $mail_details = [
// //                 'subject' => 'Card Add OTP',
// //                 'body' => 'Your OTP is : ' . $user->otp
// //             ];

// //             try {

// //                 // Mail::to($request->email)->send(new MailNotify($mail_details));
// //                 $responseMessage = 'OTP sent to ' . $user->email;
// //             } catch (\Exception $e) { // Using a generic exception
// //                 $responseMessage = $e->getMessage();
// //             }

// //             $response = [
// //                 'message' => $responseMessage,
// //                 'user' => $user,
// //                 'otp' => $createUSer['otp']
// //             ];
// //         }
// //         return response($response, 201);
//     }

//     /**
//      *
//      * @OA\Post(
//      * path="/card/cards list",
//      * operationId="cardshow",
//      * tags={"card"},
//      * summary="card show",
//      * description="card show",
//      * security={{ "basicAuth": {} }},
//      *      @OA\RequestBody(
//      *       @OA\MediaType(
//      *           mediaType="multipart/form-data",
//      *           @OA\Schema(
//      *              required={"card_number","card_month","card_year","card_cvc"},
//      *              @OA\Property(property="card_number", type="string", format="number", example="1212 5858 6565"),
//      *              @OA\Property(property="card_month", type="string", format="number", example="06"),
//      *              @OA\Property(property="card_year", type="string", format="number", example="2025"),
//      *              @OA\Property(property="card_cvc", type="string", format="number", example="321")
//      *           ),
//      *       ),
//      *   ),
//      *
//      * @OA\Response(
//      *    response=422,
//      *    description="Validator Error"
//      *     ),
//      * @OA\Response(
//      *    response=401,
//      *    description="Authentication Error",
//      *    @OA\JsonContent(
//      *          @OA\Property(property="message", type="string", example="Something went wrong"),
//      *      )
//      *     ),
//      * @OA\Response(
//      *    response=200,
//      *    description="Success",
//      *    @OA\JsonContent(
//      *          @OA\Property(property="message", type="string", example="OTP sent to user@gmail.com"),
//      *          @OA\Property(property="user", type="string", example="User details"),
//      *      )
//      *     ),
//      * )
//      */
//     public function show(Request $request)
//     {
        
//     }
    
    
//     /**
//      *
//      * @OA\Post(
//      * path="/card/cards retrieve",
//      * operationId="cardretrieve",
//      * tags={"card"},
//      * summary="card retrieve",
//      * description="card retrieve",
//      * security={{ "basicAuth": {} }},
//      *      @OA\RequestBody(
//      *       @OA\MediaType(
//      *           mediaType="multipart/form-data",
//      *           @OA\Schema(
//      *              required={"card_number","card_month","card_year","card_cvc"},
//      *              @OA\Property(property="card_number", type="string", format="number", example="1212 5858 6565"),
//      *              @OA\Property(property="card_month", type="string", format="number", example="06"),
//      *              @OA\Property(property="card_year", type="string", format="number", example="2025"),
//      *              @OA\Property(property="card_cvc", type="string", format="number", example="321")
//      *           ),
//      *       ),
//      *   ),
//      *
//      * @OA\Response(
//      *    response=422,
//      *    description="Validator Error"
//      *     ),
//      * @OA\Response(
//      *    response=401,
//      *    description="Authentication Error",
//      *    @OA\JsonContent(
//      *          @OA\Property(property="message", type="string", example="Something went wrong"),
//      *      )
//      *     ),
//      * @OA\Response(
//      *    response=200,
//      *    description="Success",
//      *    @OA\JsonContent(
//      *          @OA\Property(property="message", type="string", example="OTP sent to user@gmail.com"),
//      *          @OA\Property(property="user", type="string", example="User details"),
//      *      )
//      *     ),
//      * )
//      */
//     public function retrieve(Request $request)
//     {
        
//     }
    
    
//     /**
//      *
//      * @OA\Post(
//      * path="/card/cards remove",
//      * operationId="cardremove",
//      * tags={"card"},
//      * summary="card remove",
//      * description="card remove",
//      * security={{ "basicAuth": {} }},
//      *      @OA\RequestBody(
//      *       @OA\MediaType(
//      *           mediaType="multipart/form-data",
//      *           @OA\Schema(
//      *              required={"card_number","card_month","card_year","card_cvc"},
//      *              @OA\Property(property="card_number", type="string", format="number", example="1212 5858 6565"),
//      *              @OA\Property(property="card_month", type="string", format="number", example="06"),
//      *              @OA\Property(property="card_year", type="string", format="number", example="2025"),
//      *              @OA\Property(property="card_cvc", type="string", format="number", example="321")
//      *           ),
//      *       ),
//      *   ),
//      *
//      * @OA\Response(
//      *    response=422,
//      *    description="Validator Error"
//      *     ),
//      * @OA\Response(
//      *    response=401,
//      *    description="Authentication Error",
//      *    @OA\JsonContent(
//      *          @OA\Property(property="message", type="string", example="Something went wrong"),
//      *      )
//      *     ),
//      * @OA\Response(
//      *    response=200,
//      *    description="Success",
//      *    @OA\JsonContent(
//      *          @OA\Property(property="message", type="string", example="OTP sent to user@gmail.com"),
//      *          @OA\Property(property="user", type="string", example="User details"),
//      *      )
//      *     ),
//      * )
//      */
//     public function remove(Request $request)
//     {
        
//     }
    
    
    
// }