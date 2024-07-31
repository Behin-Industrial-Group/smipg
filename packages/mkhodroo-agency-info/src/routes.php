<?php

use App\Models\FinInfo;
use App\Models\HidroModel;
use App\Models\KamFesharModel;
use App\Models\MarakezModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mkhodroo\AgencyInfo\Controllers\AgencyController;
use Mkhodroo\AgencyInfo\Controllers\AgencyDocsController;
use Mkhodroo\AgencyInfo\Controllers\AgencyListController;
use Mkhodroo\AgencyInfo\Controllers\CreateAgencyController;
use Mkhodroo\AgencyInfo\Controllers\DebtController;
use Mkhodroo\AgencyInfo\Controllers\QueryController;
use Mkhodroo\AgencyInfo\Models\AgencyInfo;
use Mkhodroo\Cities\Controllers\CityController;
use Mkhodroo\UserRoles\Controllers\GetRoleController;
use Rap2hpoutre\FastExcel\FastExcel;

Route::name('agencyInfo.')->prefix('agency-info')->middleware(['web', 'auth', 'access'])->group(function () {
    
    Route::get('create-form', [CreateAgencyController::class, 'view'])->name('createForm');
    Route::post('create', [CreateAgencyController::class, 'create'])->name('create');
    Route::get('list-form', [AgencyListController::class, 'view'])->name('listForm');
    Route::get('list', [AgencyListController::class, 'list'])->name('list');
    Route::post('filter-list', [AgencyListController::class, 'filterList'])->name('filterList');
    Route::get('edit/{parent_id}', [AgencyController::class, 'view'])->name('editForm');
    Route::post('edit', [AgencyController::class, 'edit'])->name('edit');
    Route::post('foreman-edit', [AgencyController::class, 'foremanEdit'])->name('foremanEdit');
    Route::post('partner-edit', [AgencyController::class, 'foremanEdit'])->name('partnerEdit');
    Route::post('additional-docs-edit', [AgencyController::class, 'foremanEdit'])->name('additionalDocsEdit');
    Route::post('fin-edit', [AgencyController::class, 'finEdit'])->name('finEdit');
    Route::post('inspection-edit', [AgencyController::class, 'InspectionEdit'])->name('InspectionEdit');
    Route::post('docs-edit', [AgencyDocsController::class, 'docsEdit'])->name('docsEdit');
    Route::post('delete-info', [AgencyController::class, 'deleteByKey'])->name('deleteByKey');
});

Route::prefix('/bedehi')->group(function () {
    Route::get('/', [DebtController::class, 'bedehiHomePage']);
    Route::post('/confirm-debt', [DebtController::class, 'confirmForm'])->name('confirmForm');
    Route::post('/', [DebtController::class, 'confirmBedehi'])->name('confirm-bedehi');
    Route::post('/pay', [DebtController::class, 'pay'])->name('pay');
    Route::get('/callback', [DebtController::class, 'callback'])->name('callback');
});


Route::prefix('api/agencies')->group(function(){
    Route::get('{type?}', [AgencyListController::class, 'getValidAgencies']);
});

Route::name('query.')->prefix('query')->group(function(){
    Route::get('', [QueryController::class, 'agencyEditor'])->name('agencyEditor');
});
