<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\WebSettingController;
use App\Http\Controllers\HomeController;


Route::get('/cc', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    //\Illuminate\Support\Facades\Artisan::call('config:cache');
    return 'Cleared!';
});


Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/about-us', [HomeController::class,'aboutUs'])->name('about-us');
Route::get('/contact-us', [HomeController::class,'contactUs'])->name('contact-us');
Route::get('/product', [HomeController::class,'product'])->name('product');
Route::get('/categories', [HomeController::class,'categories'])->name('categories');
Route::get('/review', [HomeController::class,'review'])->name('review');
Route::get('/compare', [HomeController::class,'compare'])->name('compare');
Route::get('/blog', [HomeController::class,'blog'])->name('blog');

Route::redirect('/admin', '/admin/login');
Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuthController::class,'login'])->name('login');
    Route::post('/login-confirm', [AdminAuthController::class, 'loginConfirm'])->name('login.submit');

    // Authenticated routes (web guard)
    Route::middleware('auth:web')->group(function () {
        Route::get('/dashboard', [DashboardController::class,'dashboard'])->name('admin.dashboard');
        Route::get('/role-permission', [RolePermissionController::class,'index'])->name('admin.role.permission');
        Route::get('/role-permission/create', [RolePermissionController::class,'create'])->name('admin.role.permission.create');
        Route::post('/role-permission/store', [RolePermissionController::class,'store'])->name('admin.role.permission.store');
        Route::get('/role-permission/edit/{id}', [RolePermissionController::class,'edit'])->name('admin.role.permission.edit');
        Route::post('/role-permission/update/{id}', [RolePermissionController::class,'update'])->name('admin.role.permission.update');
        Route::post('/role-permission/delete', [RolePermissionController::class,'delete'])->name('admin.role.permission.delete');




        Route::controller(\App\Http\Controllers\Admin\UserController::class)->group(function (){
            Route::get('/users','index')->name('admin.user.index');
            Route::post('/user/store','store')->name('admin.user.store');
            Route::post('/user/update/{id}','update')->name('admin.user.update');
            Route::post('/user/delete','delete')->name('admin.user.delete');
        });
        Route::get('/settings', [WebSettingController::class, 'index'])->name('admin.setting');
        Route::post('/settings-update', [WebSettingController::class, 'settingsUpdate'])->name('admin.setting.update');
        Route::get('/reset-password', [AdminAuthController::class, 'resetPasswordIndex'])->name('admin.reset.password');
        Route::post('/reset-password/update', [AdminAuthController::class, 'resetPasswordUpdate'])->name('admin.reset.password.submit');
        Route::get('/profile', [AdminAuthController::class, 'profile'])->name('admin.profile');
        Route::post('/profile-update', [AdminAuthController::class, 'profileUpdate'])->name('admin.profile.update');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });

});



