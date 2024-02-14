<?php

use App\Http\Controllers\app\ChatGPTController;
use App\Http\Controllers\apps\Kanban;
use App\Http\Controllers\apps\UserList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\SpecificationsController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main Page Route
Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

// locale
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');

Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified',
])->group(function () {
  Route::get('/', [HomePage::class, 'index'])->name('pages-home');

  // chatgpt
  Route::get('/chat', [ChatGPTController::class, 'askToChatGpt'])->name('askToChatGpt');

  // users
  Route::get('/app/user/list', [UserList::class, 'index'])->name('app-user-list');
  Route::get('users/datatable', [UserController::class, 'indexDataTable'])->name('users-datatable');
  Route::resource('users', UserController::class);
  // specifications
  Route::resource('specifications', SpecificationsController::class);
  Route::get('/dashboard', function () {
    return view('dashboard');
  })->name('dashboard');
});
