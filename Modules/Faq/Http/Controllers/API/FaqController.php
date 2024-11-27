<?php
namespace Modules\Faq\Http\Controllers\API;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Faq\Entities\Faq;

class FaqController extends Controller
{

    /**
     *
     * @OA\Get(
     * path="/faq/list",
     * operationId="faqlist",
     * tags={"Page"},
     * summary="list",
     * description="Faq list",
     * security={{ "sanctum": {} }},
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
     *          @OA\Property(property="message", type="string", example="Data found"),
     *          @OA\Property(property="data", type="string", example="Categories"),
     *      )
     *     ),
     * )
     */
    public function list(Request $request)
    {
        $list = Faq::paginate(10);
        if (! ($list->isEmpty())) {
            return response()->json([
                'success' => true,
                "message" => "Faqs data",
                'list' => $list
            ], 200);
        } else {
            return response()->json(
            [
                'success' => true,
                'message' => 'Faqs not added',
                'data' => $list
            ], 400
            );
        }
    }
}
