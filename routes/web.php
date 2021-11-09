<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\ReplyController;
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

Route::get('/', [ReplyController::class, 'index']);

Route::resource('reply', ReplyController::class);

Route::group(['as' => 'reply.', 'prefix' => 'reply'], function () {
    Route::post('/upload', [ReplyController::class, 'upload'])->name('upload');
    /*
    Route::get('/', [ReplyController::class, 'index'])->name('index');
    Route::get('/create', [ReplyController::class, 'create'])->name('create');
    Route::get('/{reply}', [ReplyController::class, 'edit'])->name('edit');
    Route::post('/', [ReplyController::class, 'store'])->name('store');
    Route::put('/{reply}', [ReplyController::class, 'update'])->name('update');
    Route::delete('/{reply}', [ReplyController::class, 'destroy'])->name('destroy');
    */
});

Route::delete('/media/{uuid}', MediaController::class)->name('media.destroy');
