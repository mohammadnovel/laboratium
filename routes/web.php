<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CompotitionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\IndificationController;
use App\Http\Controllers\Admin\ParameterController;
use App\Http\Controllers\Admin\GeneralController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\PatientIndificationController;
use App\Http\Controllers\Admin\MutuIndicatorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Main\MainController;

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
Auth::routes(['register' => false]);
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/', function () {
    return view('welcome');
});
Route::get('/download-report-pdf/{id}', [ReportController::class, 'GenerateReport'])->name('report-download');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::patch('user/login-as/{id}', [UserController::class, 'loginAs'])->name('user.login-as');
        Route::resource('user', UserController::class);
        Route::resource('permission', PermissionController::class);
        Route::resource('role', RoleController::class);
        Route::post('message/resend', [MessageController::class, 'resend'])->name('message.resend');
        Route::resource('message', MessageController::class);

        Route::resource('service', ServiceController::class);
        Route::resource('report', ReportController::class);
        Route::resource('general', GeneralController::class);
        Route::resource('parameter', ParameterController::class);
        Route::resource('indification', IndificationController::class);
        Route::resource('compotition', CompotitionController::class);
        Route::resource('patient-indification', PatientIndificationController::class);
        Route::resource('mutu-indicator', MutuIndicatorController::class);
    });
});

Route::get('check-time', function () {
    return date('Y-m-d H:i:s');
});
