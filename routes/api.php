<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StorageController;

/* |-------------------------------------------------------------------------- | API Routes |-------------------------------------------------------------------------- | | Here is where you can register API routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | is assigned the "api" middleware group. Enjoy building your API! | */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(UserController::class)->name('user')->prefix('user')->group(function () {
    Route::post("/register", 'register');
    Route::get("/auth", "auth")->middleware('auth:sanctum');
    Route::post("/login", "login");
    Route::get("/logout", "logout")->middleware('auth:sanctum');
    Route::patch("/update/{id}", "update")->whereNumber('id')->middleware('auth:sanctum');
}
);
Route::apiResource('projects', ProjectController::class);
Route::controller(StorageController::class)->name('storage')->prefix('storage')->group(function () {
    Route::get('/local/{path}', 'local_download')->where('path', '.*');
    Route::post('/local', 'local_upload');
    Route::delete('/local/{path}', 'local_remove')->where('path', '.*');
});
