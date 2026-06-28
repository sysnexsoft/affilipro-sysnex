<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\WebSettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\Admin as Admin;


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
Route::get('/product/{slug}', [HomeController::class,'productDetails'])->name('product.details');
Route::get('/categories', [HomeController::class,'categories'])->name('categories');
Route::get('/review', [HomeController::class,'review'])->name('review');
Route::get('/compare', [ComparisonController::class,'index'])->name('compare');
Route::post('/compare/add/{id}', [ComparisonController::class, 'add'])->name('compare.add');
Route::post('/compare/remove/{id}', [ComparisonController::class, 'remove'])->name('compare.remove');
Route::post('/compare/clear', [ComparisonController::class, 'clear'])->name('compare.clear');
Route::get('/blog', [HomeController::class,'blog'])->name('blogs');
Route::get('/blog/{slug}', [HomeController::class,'blogDetails'])->name('blog.details');
Route::get('/blog-live-search', [HomeController::class,'blogSearch'])->name('blog.search');

Route::get('/currency-switch/{code}', [Admin\CurrencyController::class,'switchCurrency'])->name('currency.switch');
/*Route::get('/products',[ProductController::class,'index']);
Route::get('/product/{slug}', [ProductController::class,'details']);
Route::get('/category/{slug}', [ProductController::class,'categoryProducts']);
Route::post('/review/store', [ProductController::class,'submitReview']);
Route::get('/buy/{id}', [ProductController::class,'affiliateRedirect']);
Route::post('/compare/add/{id}', [ProductController::class,'addCompare']);
Route::post('/compare/remove/{id}', [ProductController::class,'removeCompare']);
Route::get('/compare', [ProductController::class,'compare']);
Route::get('/compare/clear', [ProductController::class,'clearCompare']);*/
Route::redirect('/admin', '/admin/login');
Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuthController::class,'login'])->name('login');
    Route::post('/login-confirm', [AdminAuthController::class, 'loginConfirm'])->name('login.submit');

    // Authenticated routes (web guard)
    Route::middleware('auth:web')->group(function () {
        Route::get('/dashboard', [DashboardController::class,'dashboard'])->name('admin.dashboard');

        Route::get('/product', [Admin\ProductController::class,'index'])->name('admin.product.index');
        Route::get('/product/create', [Admin\ProductController::class,'create'])->name('admin.product.create');
        Route::post('/product/store', [Admin\ProductController::class,'store'])->name('admin.product.store');
        Route::get('/product/edit/{id}', [Admin\ProductController::class,'edit'])->name('admin.product.edit');
        Route::post('/product/update/{id}', [Admin\ProductController::class,'update'])->name('admin.product.update');
        Route::post('/product/delete', [Admin\ProductController::class,'destroy'])->name('admin.product.delete');
        Route::delete('product/gallery-image/{id}', [Admin\ProductController::class, 'deleteGalleryImage'])->name('admin.product.deleteGalleryImage');
        Route::resource('products/compare-fields', Admin\ComparisonFieldController::class)->names('admin.compare-fields')->except(['create', 'show', 'edit']);
        Route::get('products/get-fields-by-categories', [App\Http\Controllers\Admin\ComparisonFieldController::class, 'getFieldsByCategories'])->name('admin.products.getFieldsByCategories');
        // Category
        Route::get('/category', [Admin\CategoryController::class,'index'])->name('admin.category.index');
        Route::post('/category/store', [Admin\CategoryController::class,'store'])->name('admin.category.store');
        Route::post('/category/update/{id}', [Admin\CategoryController::class,'update'])->name('admin.category.update');
        Route::post('/category/delete', [Admin\CategoryController::class,'destroy'])->name('admin.category.delete');

        Route::name('admin.')->group(function () {
            Route::resource('blogs-categories', Admin\BlogCategoryController::class);
            Route::resource('blogs', Admin\BlogController::class);
        });
        Route::get('/currency', [Admin\CurrencyController::class, 'index'])->name('admin.currency.index');
        Route::post('/currency/store', [Admin\CurrencyController::class, 'store'])->name('admin.currency.store');
        Route::put('/currency/update/{id}', [Admin\CurrencyController::class, 'update'])->name('admin.currency.update');
        Route::delete('/currency/delete/{id}', [Admin\CurrencyController::class, 'destroy'])->name('admin.currency.delete');

        // Brand
        Route::get('/brand', [Admin\BrandController::class,'index'])->name('admin.brand.index');
        Route::post('/brand/store', [Admin\BrandController::class,'store'])->name('admin.brand.store');
        Route::post('/brand/update/{id}', [Admin\BrandController::class,'update'])->name('admin.brand.update');
        Route::post('/brand/delete', [Admin\BrandController::class,'destroy'])->name('admin.brand.delete');

        Route::prefix('cms')->name('admin.cms.')->group(function () {
            Route::get('reviews', [Admin\ProductReviewController::class, 'index'])->name('reviews.index');
            Route::post('reviews', [Admin\ProductReviewController::class, 'store'])->name('reviews.store');
            Route::put('reviews/{id}', [Admin\ProductReviewController::class, 'update'])->name('reviews.update');
            Route::delete('reviews/{id}', [Admin\ProductReviewController::class, 'destroy'])->name('reviews.destroy');
        });


        Route::prefix('logs')->name('admin.logs.')->group(function () {
            Route::get('clicks', [Admin\AnalyticsController::class, 'trafficLogs'])->name('clicks');
            Route::get('reports', [Admin\AnalyticsController::class, 'performanceReports'])->name('reports');
        });

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
Route::get('/sync-permission', function () {

    \Illuminate\Support\Facades\Artisan::call('db:seed', [
        '--class' => 'Database\\Seeders\\PermissionSeeder',
        '--force' => true,
    ]);

    return 'Permissions & Roles synced successfully!';
});


