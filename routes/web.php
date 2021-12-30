<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FaviconContorller;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\TagController;

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

Route::get('/', function () {
    return view('welcome');
});



/**
 * Backend Routes
 */

Auth::routes();


// Social Login Routes
Route::get('login/facebook', [SocialLoginController::class, 'facebookRedirect'])->name('facebook.redirect');
Route::get('login/facebook/callback', [SocialLoginController::class, 'loginWithFacebook'])->name('login.with.facebook');


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    // users routes
    Route::prefix('users')->group(function () {
        Route::resource('/list', UserController::class);
        Route::post('/admin-edit-store', [UserController::class, 'updateUser']);
        Route::get('/admin-status-update/{id}/{val}', [UserController::class, 'updateUserStatus']);
        Route::get('/trash-list', [UserController::class, 'listUserTrash'])->name('users.trash');
        Route::get('/admin-trash-update/{id}/{val}', [UserController::class, 'updateUserTrash']);
        Route::post('/delete', [UserController::class, 'deleteByAjax'])->name('users.delete.by-ajax');
    });

    // User Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/view', [UserController::class, 'viewProfile'])->name('profile-view.profile');
        Route::get('/edit/{id}', [UserController::class, 'editProfile'])->name('profile-edit.profile');
        Route::post('/update', [UserController::class, 'updateProfile'])->name('update-user-profile.profile');
        Route::post('/update-password', [UserController::class, 'updatePassword'])->name('update-password.profile');
    });

    // roles routes
    Route::prefix('roles')->group(function () {
        Route::resource('/role-list', RoleController::class);
        Route::post('/role-edit-store', [RoleController::class, 'updateRole']);
        Route::get('/role-status-update/{id}/{val}', [RoleController::class, 'updateRoleStatus']);
        Route::get('/role-trash-list', [RoleController::class, 'listRoleTrash'])->name('roles.trash');
        Route::get('/role-trash-update/{id}/{val}', [RoleController::class, 'updateRoleTrash']);
        Route::post('/delete', [RoleController::class, 'deleteByAjax'])->name('roles.delete.by-ajax');
    });

    // categories routes
    Route::prefix('categories')->group(function () {
        Route::resource('/category-list', CategoryController::class);
        Route::get('/sub-category-list', [CategoryController::class, 'subCategoryList'])->name('sub-category-list.index');
        Route::post('/category-edit-store', [CategoryController::class, 'updateCategory']);
        Route::get('/category-status-update/{id}/{val}', [CategoryController::class, 'updateCategoryStatus']);
        Route::get('/category-trash-list', [CategoryController::class, 'listCategoryTrash'])->name('categories.trash');
        Route::get('/sub-category-trash-list', [CategoryController::class, 'listSubCategoryTrash'])->name('sub-categories.trash');
        Route::get('/category-trash-update/{id}/{val}', [CategoryController::class, 'updateCategoryTrash']);
        Route::post('/delete', [CategoryController::class, 'deleteByAjax'])->name('categories.delete.by-ajax');
    });

    // tags routes
    Route::prefix('tags')->group(function () {
        Route::resource('/tag-list', TagController::class);
        Route::post('/tag-edit-store', [TagController::class, 'updateTag']);
        Route::get('/tag-status-update/{id}/{val}', [TagController::class, 'updateTagStatus']);
        Route::get('/tag-trash-list', [TagController::class, 'listTagTrash'])->name('tags.trash');
        Route::get('/tag-trash-update/{id}/{val}', [TagController::class, 'updateTagTrash']);
        Route::post('/delete', [TagController::class, 'deleteByAjax'])->name('tags.delete.by-ajax');
    });

    // language routes
    Route::prefix('languages')->group(function () {
        Route::resource('/language-list', LanguageController::class);
        Route::post('/language-edit-store', [LanguageController::class, 'updateLanguage']);
        Route::get('/language-status-update/{id}/{val}', [LanguageController::class, 'updateLanguageStatus']);
        Route::get('/language-trash-list', [LanguageController::class, 'listLanguageTrash'])->name('languages.trash');
        Route::get('/language-trash-update/{id}/{val}', [LanguageController::class, 'updateLanguageTrash']);
        Route::post('/delete', [LanguageController::class, 'deleteByAjax'])->name('languages.delete.by-ajax');
    });

    // posts routes
    Route::prefix('posts')->group(function () {
        Route::resource('/post-list', PostController::class);
        Route::post('/post-edit-store', [PostController::class, 'updatePost']);
        Route::get('/post-status-update/{id}/{val}', [PostController::class, 'updatePostStatus']);
        Route::get('/post-trash-list', [PostController::class, 'listPostTrash'])->name('posts.trash');
        Route::get('/post-trash-update/{id}/{val}', [PostController::class, 'updatePostTrash']);
        Route::get('/post-thumbnail-update/{id}/{val}', [PostController::class, 'updatePostThumbnail']);
        Route::post('/delete', [PostController::class, 'deleteByAjax'])->name('posts.delete.by-ajax');
    });


    // logos routes
    Route::prefix('logos')->group(function () {
        Route::resource('/logo-list', LogoController::class);
        Route::post('/logo-edit-store', [LogoController::class, 'updateLogo']);
        Route::get('/logo-status-update/{id}/{val}', [LogoController::class, 'updateLogoStatus']);
        Route::get('/logo-trash-list', [LogoController::class, 'listLogoTrash'])->name('logos.trash');
        Route::get('/logo-trash-update/{id}/{val}', [LogoController::class, 'updateLogoTrash']);
        Route::post('/delete', [LogoController::class, 'deleteByAjax'])->name('logos.delete.by-ajax');
    });


    // logos routes
    Route::prefix('favicons')->group(function () {
        Route::resource('/favicon-list', FaviconContorller::class);
        Route::post('/edit-updte', [FaviconContorller::class, 'updateFavicon']);
        Route::get('/favicon-status-update/{id}/{val}', [FaviconContorller::class, 'updateFaviconStatus']);
        Route::get('/favicon-trash-list', [FaviconContorller::class, 'listFaviconTrash'])->name('favicons.trash');
        Route::get('/favicon-trash-update/{id}/{val}', [FaviconContorller::class, 'updateFaviconTrash']);
        Route::post('/delete', [FaviconContorller::class, 'deleteByAjax'])->name('favicons.delete.by-ajax');
    });

});

