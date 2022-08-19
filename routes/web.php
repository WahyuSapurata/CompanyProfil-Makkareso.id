<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AdminController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::redirect('/', '/index.html');
Route::redirect('/admin', '/admin/index.html');

Route::prefix("api")->group(function () {
  Route::controller(AdminController::class)->prefix("admins")->group(function () {
      Route::get("/key", "key");
      Route::post("/register", "register");
      Route::post("/login", "login");
      Route::post("/logout", "logout");
      Route::post("/auth", "auth");
      Route::get("/{id}", "show");
      Route::patch("/{id}", "update");
      Route::delete("/{id}", "destroy");
    }
    );
    Route::apiResource('projects', ProjectController::class);
  });
