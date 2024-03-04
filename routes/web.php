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
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ExpectedFunctionController;
use App\Http\Controllers\PromptController;
use App\Http\Controllers\PromptTypeController;
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
// Route::get('/page-2', [Page2::class, 'index'])->name('pages-page-2');

// // locale
// Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// // pages
// Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

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
  Route::post('/chat', [ChatController::class, 'chat'])->name('askToChatgpt4');

  // config
  Route::get('configuration/expectedfunction/datatable', [ExpectedFunctionController::class, 'indexDataTable'])->name('configuration.expectedfunction.datatable');
  Route::resource('configuration/expectedfunction', ExpectedFunctionController::class)->names('configuration.expectedfunction');
  Route::get('configuration/prompt/datatable', [PromptController::class, 'indexDataTable'])->name('configuration.prompt.datatable');
  Route::resource('configuration/prompt', PromptController::class)->names('configuration.prompt');
  Route::get('configuration/prompttype/datatable', [PromptTypeController::class, 'indexDataTable'])->name('configuration.prompttype.datatable');
  Route::resource('configuration/prompttype', PromptTypeController::class)->names('configuration.prompttype');
  // users
  Route::get('/user/list', [UserList::class, 'index'])->name('user-list');
  Route::get('/config/list', [UserList::class, 'index'])->name('config-list');
  Route::get('users/datatable', [UserController::class, 'indexDataTable'])->name('users-datatable');
  Route::resource('users', UserController::class);
  // specifications
  Route::get('specifications/datatable', [SpecificationsController::class, 'indexDataTable'])->name('specification.datatable');
  // 1
  Route::post('specifications/step1', [SpecificationsController::class, 'storestep1'])->name('specifications.storestep1');
  Route::get('specifications/step1/{id}', [SpecificationsController::class, 'showstep1'])->name('specifications.showstep1');
  Route::post('specifications/step1/{id}', [SpecificationsController::class, 'updatestep1'])->name('specifications.updatestep1');
  // 2
  Route::post('specifications/step2', [SpecificationsController::class, 'storestep2'])->name('specifications.storestep2');
  Route::get('specifications/step2/{id}', [SpecificationsController::class, 'showstep2'])->name('specifications.showstep2');
  Route::post('specifications/step2/{id}', [SpecificationsController::class, 'updatestep2'])->name('specifications.updatestep2');
  // 3
  Route::post('specifications/step3', [SpecificationsController::class, 'storestep3'])->name('specifications.storestep3');
  Route::get('specifications/step3/{id}', [SpecificationsController::class, 'showstep3'])->name('specifications.showstep3');
  // 4
  Route::post('specifications/step4', [SpecificationsController::class, 'storestep4'])->name('specifications.storestep4');
  Route::get('specifications/step4/{id}', [SpecificationsController::class, 'showstep4'])->name('specifications.showstep4');
  // 5
  Route::post('specifications/step5', [SpecificationsController::class, 'storestep5'])->name('specifications.storestep5');
  Route::get('specifications/step5/{id}', [SpecificationsController::class, 'showstep5'])->name('specifications.showstep5');
  // 5
  Route::post('specifications/step6', [SpecificationsController::class, 'storestep6'])->name('specifications.storestep5');
  // Route::get('specifications/step5/{id}', [SpecificationsController::class, 'showstep5'])->name('specifications.showstep5');
  Route::get('specifications/showUpload/{id}', [SpecificationsController::class, 'showUpload'])->name('specifications.showUpload');
  // ressources
  Route::resource('specifications', SpecificationsController::class);
  Route::get('/dashboard', function () {
    return view('dashboard');
  })->name('dashboard');
});
