<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardCrudController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->name('dashboard');

Route::post('/rooms', [DashboardCrudController::class, 'storeRoom'])->name('rooms.store');
Route::put('/rooms/{room}', [DashboardCrudController::class, 'updateRoom'])->name('rooms.update');
Route::delete('/rooms/{room}', [DashboardCrudController::class, 'destroyRoom'])->name('rooms.destroy');

Route::post('/tenants', [DashboardCrudController::class, 'storeTenant'])->name('tenants.store');
Route::put('/tenants/{tenant}', [DashboardCrudController::class, 'updateTenant'])->name('tenants.update');
Route::delete('/tenants/{tenant}', [DashboardCrudController::class, 'destroyTenant'])->name('tenants.destroy');

Route::post('/payments', [DashboardCrudController::class, 'storePayment'])->name('payments.store');
Route::put('/payments/{payment}', [DashboardCrudController::class, 'updatePayment'])->name('payments.update');
Route::delete('/payments/{payment}', [DashboardCrudController::class, 'destroyPayment'])->name('payments.destroy');

Route::post('/utilities', [DashboardCrudController::class, 'storeUtility'])->name('utilities.store');
Route::put('/utilities/{utilityReading}', [DashboardCrudController::class, 'updateUtility'])->name('utilities.update');
Route::delete('/utilities/{utilityReading}', [DashboardCrudController::class, 'destroyUtility'])->name('utilities.destroy');

Route::post('/maintenance', [DashboardCrudController::class, 'storeMaintenance'])->name('maintenance.store');
Route::put('/maintenance/{maintenanceTicket}', [DashboardCrudController::class, 'updateMaintenance'])->name('maintenance.update');
Route::delete('/maintenance/{maintenanceTicket}', [DashboardCrudController::class, 'destroyMaintenance'])->name('maintenance.destroy');

Route::put('/settings', [DashboardCrudController::class, 'updateSettings'])->name('settings.update');
