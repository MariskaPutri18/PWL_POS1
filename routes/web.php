<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']); // <-- Ganti dari GET ke POST
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']); // <-- pakai PUT untuk update
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); //Menampilkan form edit dengan ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); //Menampilkan form update dengan ajax
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
    Route::delete('/{id}/delete_ajax',[UserController::class, 'delete_ajax']); //Untuk hapus data user ajax
    Route::delete('/{id}', [UserController::class, 'destroy']); // <-- pakai DELETE untuk delete
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);          // menampilkan halaman awal level
    Route::post("/list", [LevelController::class, 'list']);      // menampilkan data level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah level
    Route::post('/', [LevelController::class, 'store']);         // menyimpan data level baru
    Route::get('/{id}', [LevelController::class, 'show']);       // menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);  // menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); //Menampilkan form edit dengan ajax
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); //Menampilkan form update dengan ajax
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
    Route::delete('/{id}/delete_ajax',[LevelController::class, 'delete_ajax']); //Untuk hapus data user ajax
    Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']); // menampilkan halaman awal kategori
    Route::post("/list", [KategoriController::class, 'list']); // menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']); // menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class, 'store']); // menyimpan data kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']); // menyimpan perubahan data kategori
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); //Menampilkan form edit dengan ajax
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); //Menampilkan form update dengan ajax
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
    Route::delete('/{id}/delete_ajax',[KategoriController::class, 'delete_ajax']); //Untuk hapus data user ajax
    Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data kategori
});


Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']);
    Route::post('/list', [SupplierController::class, 'list']);
    Route::get('/create', [SupplierController::class, 'create']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::get('/{id}', [SupplierController::class, 'show']);
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);
    Route::put('/{id}', [SupplierController::class, 'update']);
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); //Menampilkan form edit dengan ajax
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); //Menampilkan form update dengan ajax
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); //untuk tampilkan form confirm delete user ajax
    Route::delete('/{id}/delete_ajax',[SupplierController::class, 'delete_ajax']); //Untuk hapus data user ajax
    Route::delete('/{id}', [SupplierController::class, 'destroy']);
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

?>
