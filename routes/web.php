<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BusinessesController;
use App\Http\Controllers\ScenariosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Organizations

Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('auth');

Route::get('organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
    ->middleware('auth');


// Business Settings

Route::get('businesses', [BusinessesController::class, 'index'])
    ->name('businesses')
    ->middleware('auth');

Route::get('businesses/create', [BusinessesController::class, 'create'])
    ->name('businesses.create')
    ->middleware('auth');

Route::post('businesses', [BusinessesController::class, 'store'])
    ->name('businesses.store')
    ->middleware('auth');

Route::put('businesses/{business}', [BusinessesController::class, 'update'])
    ->name('businesses.update')
    ->middleware('auth');

Route::get('businesses/{business}/edit', [BusinessesController::class, 'edit'])
    ->name('businesses.edit')
    ->middleware('auth');

//Scenarios

Route::get('scenarios/{business}/list', [ScenariosController::class, 'list'])
    ->name('scenarios.list')
    ->middleware('auth');

Route::get('scenarios/draft/{id}', [ScenariosController::class, 'draft'])
    ->name('scenarios.draft')
    ->middleware('auth');

Route::post('scenarios/{id}', [ScenariosController::class, 'proceed'])
    ->name('scenarios.proceed')
    ->middleware('auth');

Route::get('scenarios', [ScenariosController::class, 'create'])
    ->name('scenarios.create')
    ->middleware('auth');

// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');

// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

//Xero implementations
Route::get('/manage/xero', [App\Http\Controllers\XeroController::class, 'redirectUserToXero'])->name('redirectUserToXero');


Route::get('/xero/signup', [App\Http\Controllers\XeroController::class, 'xeroSignup'])->name('xeroSignup');
Route::get('/xero/signin', [App\Http\Controllers\XeroController::class, 'xeroSignin'])->name('xeroSignin');

Route::get('/xero/callback', [App\Http\Controllers\XeroController::class, 'redirectToXero'])->name('redirectToXero');
Route::get('/xero/auth/callback', [App\Http\Controllers\XeroController::class, 'handleCallbackFromXero'])->name('handleCallbackFromXero');

Route::post('/save-user', [App\Http\Controllers\XeroController::class, 'saveUser'])->name('saveUser');

Route::get('/xero/get-data', [App\Http\Controllers\XeroController::class, 'getXeroData'])->name('getXeroData');

require __DIR__.'/auth.php';