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

// Route::middleware('auth:sanctum')->get('/user', function () {
    // return $request->user();
// });

// Route::group(['middleware' => ['auth:sanctum']], function(){
//     Route::get('/products/search/{name}', [ProductController::class, 'search'];)
// });

Route::middleware('auth:sanctum')->get('/user', function (Request $requst) {
    return $request->user();
});

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
