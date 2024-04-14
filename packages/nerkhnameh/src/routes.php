<?php

use Illuminate\Support\Facades\Route;
use Mkhodroo\DateConvertor\Controllers\SDate;
use Mkhodroo\Nerkhnameh\Controllers\NerkhnamehRegistrationInfoController;
use Mkhodroo\Nerkhnameh\Controllers\RegisterController;
use Mkhodroo\Nerkhnameh\Controllers\UploadFinPaymentController;
use Mkhodroo\Voip\Controllers\VoipController;

Route::name('nerkhnameh.')->prefix('nerkhnameh')->middleware(['web'])->group(function(){
    Route::get('', [RegisterController::class, 'registerForm'])->name('registerForm');
    Route::post('register', [RegisterController::class, 'register'])->name('register');

    Route::name('registration.')->prefix('registration')->group(function(){
        Route::get('', [NerkhnamehRegistrationInfoController::class, 'listForm'])->name('listForm');
        Route::get('list', [NerkhnamehRegistrationInfoController::class, 'list'])->name('list');
        Route::post('get', [NerkhnamehRegistrationInfoController::class, 'getView'])->name('getView');
    });

    Route::name('finPayment.')->prefix('fin-payment')->group(function(){
        Route::get('', [UploadFinPaymentController::class, 'uploadForm'])->name('uploadForm');
        Route::post('check', [UploadFinPaymentController::class, 'check'])->name('check');
        Route::post('upload', [UploadFinPaymentController::class, 'upload'])->name('upload');
    });


});