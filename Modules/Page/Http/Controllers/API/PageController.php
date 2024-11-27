<?php
namespace Modules\Page\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PhonePassowrd;
use App\Models\User;
use Dotunj\LaraTwilio\Facades\LaraTwilio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Twilio\Exceptions\TwilioException;
use Modules\Page\Entities\Page;

class PageController extends Controller
{
    /**
     * @OA\Get(
     * path="/page/list",
     * operationId="pagelist",
     * tags={"Page"},
     * summary="list",
     * description="page list",
     * security={{ "sanctum": {} }},
     * @OA\Response(
     *    response=422,
     *    description="Validator Error"
     *     ),
     *   @OA\Parameter(
     *      name="type_id",
     *      in="query",
     *      description=" TERMS_CONDITION = 1; PRIVACY_POLICY = 2;ABOUT_US = 3;",
     *      required=true,
     *      @OA\Schema(
     *           type="number"
     *      )
     *   ),

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
     *          @OA\Property(property="message", type="string", example="Data found"),
     *          @OA\Property(property="data", type="string", example="Categories"),
     *      )
     *     ),
     * )
     */
    public function list(Request $request)
    {
        $page = Page::where(['type_id' => $request->type_id])->first();
        if (! empty($page)) {
            return response()->json([
                'success' => true,
                "message" => "Page data",
                'page' => $page
            ], 200);
        }else{
            return response()->json(

                ['success' => true,
                    'message' => 'Page not added',
                    'data' => $page],
                400

                );
        }
        
        
    }
}
