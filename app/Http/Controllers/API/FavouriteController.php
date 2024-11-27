<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Favourite\Entities\Item;
use Modules\ServiceProvider\Entities\ServiceProvider;


class FavouriteController extends Controller
{

    /**
     * @OA\Get(
     *      path="/favourite/favourites",
     *      operationId="getFavouritesList",
     *      tags={"favourite"},
     *      summary="Get list of favourites",
     *      description="Returns list of favourites",
     *     @OA\Parameter(
     *     name="id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found",
     *      ),
     *       @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */

    public function favourites($id)
    {
        try {
            $favourite = Item::where([
                'created_by_id' => $id,
                'state_id' => Item::STATE_ACTIVE,
            ])->get();
            if ($favourite) {
                return response($favourite);
            } else {
                return response([
                    'message' => 'no providers are in your favourites'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->with($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *      path="/favourite/favourite/",
     *      operationId="addFavourite",
     *      tags={"favourite"},
     *      summary="",
     *      description="Changes state from state to not_favourite and vice versa",
     *     @OA\Parameter(
     *     name="id",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     ),
     *   ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *       @OA\Response(
     *          response=404,
     *          description="Not Found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */

    public function favourite($id)
    {
        try {
            $provider = ServiceProvider::find($id);
            if ($provider->isNotEmpty()) {
                $item = Item::where([
                    'model_type' => get_class($provider),
                    'model_id' => $provider->id,
                    'created_by_id' => Auth::user()->id
                ])->first();
                if ($item) {
                    if ($item->state_id == Item::STATE_ACTIVE) {
                        $item->state_id = Item::STATE_INACTIVE;
                        return response([
                            'message' => 'provider removed from favourites'
                        ], 200);
                    } else {
                        $item->state_id = Item::STATE_ACTIVE;
                        return response([
                            'message' => 'provider added to favourites'
                        ], 200);
                    }
                    $item->save();
                        return response([
                            'message' => 'success'
                        ], 200);
                } else {
                    $model = new Item;
                    $class = get_class($provider);
                    $model->model_type = $class;
                    $model->model_id = $provider->id;
                    $model->state_id = Item::STATE_ACTIVE;
                    $model->created_by_id = Auth::user()->id;
                }
                if ($model->save()) {
                    return response([
                        'message' => 'provider added to favourites'
                    ], 200);
                } else {
                    return response(['message' => 'unexpected error occurred'], 401);
                }
            }
        } catch (\Exception $e) {
            return response()->with($e->getMessage());
        }
    }
}
