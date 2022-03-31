<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductiveController;

Route::controller(ProductiveController::class)->group(function () {
    Route::get('/', 'index')->name('productive');
    Route::get('/projects', 'projects')->name('productive.projects');
    Route::get('/create', 'create')->name('productive.create');
    Route::post('/create', 'store')->name('productive.store');

    Route::get('/createtask/{projectId}', 'createTask')->name('productive.createTask');
    Route::post('/storetask', 'storeTask')->name('productive.storeTask');

    Route::get('/show/{id}', 'show')->name('productive.show');
});
