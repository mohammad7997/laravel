<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::prefix('v1/')->group(function () {

    // routes Auth


    include __DIR__ .'/v1/auth_routes.php';


    // routes Channel

    include __DIR__ .'/v1/channel_routes.php';


    // routes Thread and route Answer

    include __DIR__ . '/v1/Thread_routes.php';




});
