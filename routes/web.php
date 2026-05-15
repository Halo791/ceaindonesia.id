<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/language/{locale}', [SiteController::class, 'switchLanguage'])
    ->whereIn('locale', ['id', 'en'])
    ->name('language.switch');
Route::get('/profil/riwayat', [SiteController::class, 'riwayat'])->name('profil.riwayat');
Route::get('/blog', [SiteController::class, 'blog'])->name('blog.index');
Route::get('/blog/{id}', [SiteController::class, 'blogShow'])->name('blog.show');
Route::get('/halaman/{slug}', [SiteController::class, 'dynamicPage'])->name('dynamic.page');
Route::get('/update/{slug}', [SiteController::class, 'publicUpdate'])->name('public.update');
Route::get('/travel', [SiteController::class, 'placeholder'])->defaults('title', 'Travel')->name('travel');
Route::get('/lifestyle', [SiteController::class, 'placeholder'])->defaults('title', 'Lifestyle')->name('lifestyle');
Route::get('/nft', [SiteController::class, 'placeholder'])->defaults('title', 'NFT')->name('nft');
Route::get('/index-{variant}', [SiteController::class, 'placeholder'])
    ->whereNumber('variant')
    ->defaults('title', 'Homepage Variant')
    ->name('home.variant');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [SiteController::class, 'admin'])->name('index');
        Route::get('/pages', [SiteController::class, 'adminPages'])->name('pages.index');
        Route::get('/pages/create', [SiteController::class, 'createAdminPage'])->name('pages.create');
        Route::post('/pages', [SiteController::class, 'storeAdminPage'])->name('pages.store');
        Route::get('/pages/{page}/edit', [SiteController::class, 'editAdminPage'])->name('pages.edit');
        Route::put('/pages/{page}', [SiteController::class, 'updateAdminPage'])->name('pages.update');
        Route::delete('/pages/{page}', [SiteController::class, 'destroyAdminPage'])->name('pages.destroy');
        Route::get('/updates', [SiteController::class, 'adminUpdates'])->name('updates.index');
        Route::get('/updates/create', [SiteController::class, 'createAdminUpdate'])->name('updates.create');
        Route::post('/updates', [SiteController::class, 'storeAdminUpdate'])->name('updates.store');
        Route::get('/updates/{update}/edit', [SiteController::class, 'editAdminUpdate'])->name('updates.edit');
        Route::put('/updates/{update}', [SiteController::class, 'updateAdminUpdate'])->name('updates.update');
        Route::delete('/updates/{update}', [SiteController::class, 'destroyAdminUpdate'])->name('updates.destroy');
        Route::post('/{section}/{slug}/{child}/{leaf}', [SiteController::class, 'updateAdminNestedLeaf'])->name('nested.leaf.update');
        Route::post('/{section}/{slug}/{child}', [SiteController::class, 'updateAdminNestedItem'])->name('nested.item.update');
        Route::post('/{section}', [SiteController::class, 'updateAdminSection'])->name('section.update');
        Route::post('/{section}/{slug}', [SiteController::class, 'updateAdminItem'])->name('item.update');
        Route::get('/{section}/{slug}/{child}/{leaf}', [SiteController::class, 'adminNestedLeaf'])->name('nested.leaf');
        Route::get('/{section}/{slug}/{child}', [SiteController::class, 'adminNestedItem'])->name('nested.item');
        Route::get('/{section}', [SiteController::class, 'adminSection'])->name('section');
        Route::get('/{section}/{slug}', [SiteController::class, 'adminItem'])->name('item');
    });
});

Route::get('/{section}', [SiteController::class, 'publicSection'])
    ->whereIn('section', ['profil', 'regio', 'siar', 'aksi', 'koneksi', 'kolektif'])
    ->name('public.section');

Route::get('/{section}/{slug}/{child}/{leaf}', [SiteController::class, 'publicNestedLeaf'])
    ->whereIn('section', ['regio'])
    ->name('public.nested.leaf');

Route::get('/{section}/{slug}/{child}', [SiteController::class, 'publicNestedItem'])
    ->whereIn('section', ['regio'])
    ->name('public.nested.item');

Route::get('/{section}/{slug}', [SiteController::class, 'publicItem'])
    ->whereIn('section', ['profil', 'regio', 'siar', 'aksi', 'koneksi'])
    ->name('public.item');
