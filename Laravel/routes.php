<?php

/**
 * prefix admin/json-objects
 * as admin.jsonObjects.
 */

use Illuminate\Support\Facades\Route;
use Src\Modules\JsonObjects\Laravel\Controllers\DirController;
use Src\Modules\JsonObjects\Laravel\Controllers\ItemController;

Route::group(['prefix' => 'admin/json-objects', 'as' => 'admin.jsonObjects.'], function(){
    Route::get('/dir', [DirController::class, 'dir'])->name('dir');
    Route::post('/new-dir', [DirController::class, 'newDir'])->name('newDir');
    Route::post('/rename-dir', [DirController::class, 'renameDir'])->name('renameDir');
    Route::post('/delete-dir', [DirController::class, 'deleteDir'])->name('deleteDir');

    Route::get('/item', [ItemController::class, 'item'])->name('item');
    Route::post('/edit-item', [ItemController::class, 'editItem'])->name('editItem');
    Route::post('/new-item', [ItemController::class, 'newItem'])->name('newItem');
    Route::post('/rename-item', [ItemController::class, 'renameItem'])->name('renameItem');
    Route::post('/delete-item', [ItemController::class, 'deleteItem'])->name('deleteItem');
});