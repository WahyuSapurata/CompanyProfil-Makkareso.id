<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::redirect('/', '/index.html');
Route::redirect('/admin', '/admin/index.html');
Route::get('/projects/{id}', [ProjectController::class, 'detail']);
