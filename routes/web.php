<?php

use App\Http\Controllers\HomebudgetController;
use App\Models\HomeBudget;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;

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

Route::get('/', function () {
    return view('homebudget.index');
});


Route::get('/', [HomebudgetController::class, 'index'])->name('index');
Route::get('/dashboard', [HomebudgetController::class, 'dashboard'])->name('dashboard');
Route::post('/post', [HomebudgetController::class, 'store'])->name('store');
Route::get('/edit/{id}', [HomebudgetController::class, 'edit'])->name('homebudget.edit');
Route::put('/update', [HomebudgetController::class, 'update'])->name('homebudget.update');
Route::post('/destroy/{id}', [HomebudgetController::class, 'destroy'])->name('homebudget.destroy');
Route::get('/calendar', [HomebudgetController::class, 'calendar'])->name('calendar');
Route::get('/balance', [HomebudgetController::class, 'balance'])->name('balance');
Route::get('/homebudget/g_make', [GroupController::class, 'create'])->name('groups.create');
Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
Route::post('/groups/confirm', [GroupController::class, 'confirm'])->name('groups.confirm');
Route::post('/participation/save-user', [HomebudgetController::class, 'participation_save_user'])->name('participation.save_user');

// 参加フォームを表示
// Route::get('/participation', [HomebudgetController::class, 'participation_form'])->name('participation_form');
Route::get('/participation', [HomebudgetController::class, 'participation_form'])->name('participation.form');

// 確認画面を表示
Route::post('/participation/confirm', [HomebudgetController::class, 'participation_confirm'])->name('participation.confirm');

// 完了画面を表示
Route::post('/participation/complete', [HomebudgetController::class, 'participation_complete'])->name('participation.complete');

