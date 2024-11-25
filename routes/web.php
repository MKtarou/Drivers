<?php

use App\Http\Controllers\HomebudgetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CombinedMeterController; // 追加

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;


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
Route::get('/homebudget/invitationCode', [InvitationController::class, 'show'])->name('invitationCode.show');
// Route::get('/setting', [SettingController::class, 'create'])->name('setting.create');
// Route::post('/setting/confirm', [SettingController::class, 'confirm'])->name('setting.confirm');
// Route::get('/setting/confirm_page', [SettingController::class, 'confirmPage'])->name('setting.confirm_page');
// Route::post('/setting/store', [SettingController::class, 'store'])->name('setting.store');

// Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
// Route::post('/setting/personal', [SettingController::class, 'updatePersonal'])->name('setting.update.personal');
// Route::post('/setting/group', [SettingController::class, 'updateGroup'])->name('setting.update.group');

Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
Route::post('/setting/personal', [SettingController::class, 'updatePersonal'])->name('setting.update.personal');
Route::post('/setting/group', [SettingController::class, 'updateGroup'])->name('setting.update.group');

Route::group(['middleware' => ['storeGroupId']], function () {
    // このグループ内のすべてのルートにミドルウェアが適用されます
    Route::get('/dashboard', [HomebudgetController::class, 'dashboard'])->name('dashboard');
    // その他のルート
});

Route::get('/test-session', [TestController::class, 'checkSession']);


// 参加フォームを表示
Route::get('/participation', [HomebudgetController::class, 'participation_form'])->name('participation.form');

// 確認画面を表示
Route::post('/participation/confirm', [HomebudgetController::class, 'participation_confirm'])->name('participation.confirm');

// 完了画面を表示
Route::post('/participation/complete', [HomebudgetController::class, 'participation_complete'])->name('participation.complete');

// ----------------------------------------
// Combined Meter Route を追加
// ----------------------------------------
Route::get('/combined-meter', [CombinedMeterController::class, 'index'])->name('combined.meter');

//ログアウト処理
Route::get('/logout', function () {
    // セッションをすべて削除
    session()->flush();
    // 未参加画面にリダイレクト
    return redirect()->route('nogroup');
})->name('logout');

// 未参加画面のルート
Route::get('/nogroup', function () {
    return view('homebudget.nogroup'); // 未参加画面のBladeファイル
})->name('nogroup');

Route::get('/user/register', [UserController::class, 'create'])->name('user.register.form');
Route::post('/user/register', [UserController::class, 'store'])->name('user.register');
