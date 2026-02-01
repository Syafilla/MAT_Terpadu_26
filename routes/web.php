<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArsipImportController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\UserArsipController;
use App\Http\Controllers\AdminRekapAtasNamaController;

Route::get('/', function () {
    return redirect('/login');
});
Route::get('/login', fn () => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth') 
    ->name('logout');

Route::get('/aktivasi', [RegisterController::class, 'index'])->name('aktivasi');
Route::post('/aktivasi/cek', [RegisterController::class, 'check']);
Route::post('/aktivasi/proses', [RegisterController::class, 'activate']);


Route::post('/arsip/import', [ArsipController::class, 'importExcel'])
    ->name('arsip.import');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'index'])
        ->name('admin.dashboard');
    Route::get('/admin/users', [UserController::class, 'userdex'])
        ->name('admin.user');
    Route::get('/admin/users/create', [UserController::class, 'create']);
    Route::post('/admin/users', [UserController::class, 'store']);
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit']);
    Route::put('/admin/users/{id}', [UserController::class, 'update']);
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])
        ->name('admin.users.destroy');
    Route::get('/admin/rekap', [AdminRekapAtasNamaController::class, 'index'])
        ->name('admin.rekap.atasnama');
    Route::get('/admin/rekap/detail', [AdminRekapAtasNamaController::class, 'detail'])
        ->name('admin.rekap.atasnama.detail');
    Route::get('/admin/rekap/download-excel', [AdminRekapAtasNamaController::class, 'downloadExcel'])
        ->name('admin.rekap.download');


});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboardUser'])
        ->name('dashboard');
    Route::get('/siarsip', [ArsipController::class, 'index'])
        ->name('arsip.index');

    Route::get('/siarsip/{tahun}/{tentang}', [ArsipController::class, 'groupForm'])
        ->name('arsip.group.form');

    Route::post('/siarsip/{tahun}/{tentang}', [ArsipController::class, 'groupStore'])
        ->name('arsip.group.store');

    Route::post('/siarsip/import', [ArsipController::class, 'import'])
        ->name('arsip.import');
    Route::get('user/siarsip/create', [ArsipController::class, 'create'])
        ->name('arsip.create');

});


Route::middleware('auth')->group(function () {
    Route::get('/admin/arsip', [ArsipController::class, 'index'])
        ->name('arsip.index');

    Route::get('/admin/arsip/create', [ArsipController::class, 'create'])
        ->name('arsip.create');

    Route::post('/admin/arsip', [ArsipController::class, 'store'])
        ->name('arsip.store');

Route::get('/arsip/{tahun}/{tentang}', [ArsipController::class, 'groupForm'])
    ->name('arsip.group.form');

Route::post('/arsip/{tahun}/{tentang}', [ArsipController::class, 'groupStore'])
    ->name('arsip.group.store');
Route::delete('/arsip/delete-group', [ArsipController::class, 'deleteGroup'])
    ->name('arsip.deleteGroup');

});
Route::middleware('auth')->post(
    '/change-password',
    [AuthController::class, 'changePassword']
)->name('password.change');

