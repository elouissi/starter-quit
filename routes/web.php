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
use App\Http\Controllers\LangueController;
use App\Http\Controllers\NotificationController;
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

  // users

  // chatgpt
  Route::get('/chat', [ChatGPTController::class, 'askToChatGpt'])->name('askToChatGpt');
  Route::get('/rechat', [ChatGPTController::class, 'reAskToChatGpt'])->name('reAskToChatGpt');
  // Route::post('/chat', [ChatController::class, 'chat'])->name('askToChatgpt4');

  // config
  Route::get('configuration/expectedfunction/datatable', [ExpectedFunctionController::class, 'indexDataTable'])->name('configuration.expectedfunction.datatable');
  Route::resource('configuration/expectedfunction', ExpectedFunctionController::class)->names('configuration.expectedfunction');
  Route::get('configuration/prompt/datatable', [PromptController::class, 'indexDataTable'])->name('configuration.prompt.datatable');
  Route::resource('configuration/prompt', PromptController::class)->names('configuration.prompt');
  Route::get('configuration/prompttype/datatable', [PromptTypeController::class, 'indexDataTable'])->name('configuration.prompttype.datatable');
  Route::resource('configuration/prompttype', PromptTypeController::class)->names('configuration.prompttype');
  Route::get('configuration/langue/datatable', [LangueController::class, 'indexDataTable'])->name('configuration.langue.datatable');
  Route::resource('configuration/langue', LangueController::class)->names('configuration.langue');
  // users
  Route::get('/user/list', [UserList::class, 'index'])->name('user-list');
  Route::get('/config/list', [UserList::class, 'index'])->name('config-list');
  Route::get('users/datatable', [UserController::class, 'indexDataTable'])->name('users-datatable');
  Route::post('/users/{user}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
  Route::post('/users/{user}/unsuspend', [UserController::class, 'unsuspend'])->name('users.unsuspend');
  Route::resource('users', UserController::class);
  // specifications
  Route::get('/example', function () {
    return view('content.specifications.mail', ['name' => 'John']);
  });
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
  Route::post('specifications/step3/{id}', [SpecificationsController::class, 'updatestep3'])->name('specifications.updatestep3');
  Route::post('deletefile/{id}', [SpecificationsController::class, 'deletefile'])->name('specifications.deletefile');
  // 4
  Route::post('specifications/step4', [SpecificationsController::class, 'storestep4'])->name('specifications.storestep4');
  Route::get('specifications/step4/{id}', [SpecificationsController::class, 'showstep4'])->name('specifications.showstep4');
  Route::post('specifications/step4/{id}', [SpecificationsController::class, 'updatestep4'])->name('specifications.updatestep4');
  // 5
  Route::post('specifications/step5', [SpecificationsController::class, 'storestep5'])->name('specifications.storestep5');
  Route::get('specifications/step5/{id}', [SpecificationsController::class, 'showstep5'])->name('specifications.showstep5');
  Route::post('specifications/step5/{id}', [SpecificationsController::class, 'updatestep5'])->name('specifications.updatestep5');
  // 5
  Route::post('specifications/step6', [SpecificationsController::class, 'storestep6'])->name('specifications.storestep5');
  // Route::get('specifications/step5/{id}', [SpecificationsController::class, 'showstep5'])->name('specifications.showstep5');
  Route::get('specifications/upload/{id}', [SpecificationsController::class, 'upload'])->name('specifications.upload');

  //route CDC web  create
  Route::get('specifications-web-site_vitrine/create', [SpecificationsController::class,'create_vitrine'])->name('specifications-web-site_vitrine.create');
  Route::get('specifications-web-E_Commerce/create', [SpecificationsController::class,'create_E_commerce'])->name('specifications-web-E_Commerce.create');
  Route::get('specifications-web-Blog/create', [SpecificationsController::class,'create_blog'])->name('specifications-web-Blog.create');
  Route::get('specifications-web-Affiliation/create', [SpecificationsController::class,'create_affiliation'])->name('specifications-web-Affiliation.create');

  //route CDC mobile create
  Route::get('specifications-mobile-E_Commerce/create', [SpecificationsController::class,'create_App_E_commerce'])->name('specifications-mobile-E_Commerce.create');
  Route::get('specifications-mobile-E_learning/create', [SpecificationsController::class,'create_E_learning'])->name('specifications-mobile-E_learning.create');

  //route CDC web edit
  Route::get('/specifications/{id}/edit', [SpecificationsController::class, 'edit'])->name('specifications.edit');
  Route::get('specifications-web-site_vitrine/{id}/edit', [SpecificationsController::class,'edit_vitrine'])->name('specifications-web-site_vitrine.edit');
  Route::get('specifications-web-E_Commerce/{id}/edit', [SpecificationsController::class,'edit_E_commerce'])->name('specifications-web-E_Commerce.edit');
  Route::get('specifications-web-Blog/{id}/edit', [SpecificationsController::class,'edit_blog'])->name('specifications-web-Blog.edit');
  Route::get('specifications-web-Affiliation/{id}/edit', [SpecificationsController::class,'edit_affiliation'])->name('specifications-web-Affiliation.edit');

  //route CDC mobile edit
  Route::get('specifications-mobile-m-E_Commerce/{id}/edit', [SpecificationsController::class, 'edit_App_E_commerce'])->name('specifications-mobile-E_Commerce.edit');
  Route::get('specifications-mobile-E_learning/{id}/edit', [SpecificationsController::class,'edit_E_learning'])->name('specifications-mobile-E_learning.edit');
  // ressources
  Route::resource('specifications', SpecificationsController::class);


  Route::get('/dashboard', function () {
    return view('dashboard');
  })->name('dashboard');

  // notification
  Route::get('/notifications', [NotificationController::class, 'index']);
  Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead']);
  Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
});
