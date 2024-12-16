<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Hommies Group Api Documentation",
 *     version="1.0.0",
 *     @OA\Contact(
 *         name="developer",
 *         email="rohit7305.rk@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *     @OA\Server(
 *     description="http",
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 *     )
 *   @OA\Server(
 *   url="http://localhost/hommiesGroup/api",
 *   description="local server",
 * )
 *  @OA\Server(
 *   url="https://hommiesgroup.com/api",
 *   description="Live server",
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     in="header",
 *     scheme="bearer",
 *     name="Authorization",
 *     securityScheme="sanctum"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
