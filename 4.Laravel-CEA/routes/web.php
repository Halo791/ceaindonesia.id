<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/profil/riwayat', [SiteController::class, 'riwayat'])->name('profil.riwayat');
Route::get('/blog', [SiteController::class, 'blog'])->name('blog.index');
Route::get('/blog/{id}', [SiteController::class, 'blogShow'])->name('blog.show');
Route::get('/travel', [SiteController::class, 'placeholder'])->defaults('title', 'Travel')->name('travel');
Route::get('/lifestyle', [SiteController::class, 'placeholder'])->defaults('title', 'Lifestyle')->name('lifestyle');
Route::get('/nft', [SiteController::class, 'placeholder'])->defaults('title', 'NFT')->name('nft');
Route::get('/index-{variant}', [SiteController::class, 'placeholder'])
    ->whereNumber('variant')
    ->defaults('title', 'Homepage Variant')
    ->name('home.variant');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [SiteController::class, 'admin'])->name('index');
    Route::get('/{section}', [SiteController::class, 'adminSection'])->name('section');
    Route::get('/{section}/{slug}', [SiteController::class, 'adminItem'])->name('item');
});
