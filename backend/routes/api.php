<?php

use App\Http\Controllers\Api\HelpdescController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post("/login",LoginController::class)->name('login');
Route::post("/logout",LogoutController::class)->name('logout');

Route::get("/user",[UserController::class,'index'])->name("user.index");
Route::post("/user/store",[UserController::class,'store'])->name("user.store");
Route::get("/user/show/{id}",[UserController::class,'show'])->name("user.show");
Route::patch("/user/update/{id}",[UserController::class,'update'])->name("user.update");
Route::delete("/user/destroy/{id}",[UserController::class,'destroy'])->name("user.destroy");

Route::resource("/helpdesc",HelpdescController::class);

Route::middleware('auth:api')->get('/dataUser', function (Request $request) {
    return $request->user();
});
