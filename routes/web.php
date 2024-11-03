<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CampController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tool', [HomeController::class, 'tools'])->name('tools');
Route::get('/recomendation', [HomeController::class, 'showform'])->name('recomends');
Route::post('/proces-recommendation',[HomeController::class, 'recomend'])->name('proces.recommendation');
Route::get('/recomend-result', [HomeController::class, 'showRecommendationResult'])->name('recomend.result');
Route::post('/save-recommendation', [HomeController::class, 'saveRecommendation'])->name('save.recommendation');

Route::get('/login', [CampController::class, 'login'])->name('login');
Route::get('/logout', [CampController::class, 'logout'])->name('logout');
Route::post('/action-login', [CampController::class, 'ActionLogin'])->name('actionlogin');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [CampController::class, 'dashboard'])->name('dashboard');
    Route::get('/data', [CampController::class, 'index'])->name('data');
    Route::post('/data/store', [CampController::class, 'store'])->name('data.store');
    Route::put('/data/update/{id}', [CampController::class, 'update'])->name('data.update');
    Route::delete('/data/delete/{id}', [CampController::class, 'destroy'])->name('data.delete');
    Route::get('/result',[CampController::class, 'result'])->name('result');
    Route::get('/profile',[CampController::class, 'profile'])->name('profile');
    Route::post('/action-profile',[CampController::class, 'ActionProfile'])->name('actionprofile');
    Route::delete('/recommendation/{id}/delete', [CampController::class, 'deleteRecommendation'])->name('recommendation.delete');
    Route::post('/change-password', [CampController::class, 'changePassword'])->name('change.password');

});


