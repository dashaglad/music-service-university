<?php

use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\SongController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckOwnership;
use App\Http\Middleware\HavePermissions;
use App\Models\Permissions\PermissionCode;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(LoginController::class)->group(function () {
    Route::post('login', 'login')
        ->withoutMiddleware(Authenticate::class)
        ->name('api.login');
    Route::post('logout', 'logout')->name('api.logout');
});

Route::post('register', [RegisterController::class, 'register'])
    ->withoutMiddleware(Authenticate::class)
    ->name('api.register');

Route::prefix('users')->controller(UserController::class)
    ->group(function () {
        Route::get('current', 'getCurrentUser')->name('users.current');
    });

Route::prefix('albums')->name('api.albums.')->group(function () {
    Route::controller(AlbumController::class)->group(function () {
        Route::middleware(HavePermissions::permissions(PermissionCode::AccessMusicCollection))
            ->group(function () {
                Route::get('popular', 'getPopularAlbums')->name('popular');
                Route::get('latest', 'getLatestAlbums')->name('latest');
                Route::get('{albumId}', 'getAlbum')->whereNumber('albumId')->name('album');
                Route::get('', 'getAlbums')->name('all');
            });

        Route::middleware(HavePermissions::permissions(PermissionCode::ManageOwnLibrary))->group(function () {
            Route::post('{albumId}/like', 'likeAlbum')->whereNumber('albumId')->name('like');
            Route::post('{albumId}/unlike', 'unlikeAlbum')->whereNumber('albumId')->name('unlike');
            Route::get('favorite', 'getFavoriteAlbums')->name('favorite');
            Route::get('own', 'getOwnAlbums')->name('own');
        });

        Route::middleware([HavePermissions::permissions(PermissionCode::ManageOwnAlbums)])->group(function () {
            Route::put('create', 'createAlbum')->name('create');
            Route::post('{albumId}/edit', 'updateAlbum')
                ->middleware(CheckOwnership::class)
                ->whereNumber('albumId')
                ->name('update');
            Route::delete('{albumId}/delete', 'deleteAlbum')
                ->middleware(CheckOwnership::class)
                ->whereNumber('albumId')
                ->name('delete');
        });
    });

    Route::controller(SongController::class)
        ->middleware(HavePermissions::permissions(PermissionCode::ManageOwnAlbums))
        ->middleware(CheckOwnership::class)
        ->group(function () {
            Route::post('{albumId}/songs/create', 'createSong')->whereNumber('albumId')->name('songs.create');
            Route::delete('{albumId}/songs/{songId}', 'deleteSong')->whereNumber(['albumId', 'songId'])->name(
                'songs.delete'
            );
        });
});

Route::prefix('songs')->name('songs.')->controller(SongController::class)->group(function () {
    Route::middleware(HavePermissions::permissions(PermissionCode::ManageOwnLibrary))->group(function () {
        Route::post('{songId}/like', 'likeSong')->whereNumber('songId')->name('like');
        Route::post('{songId}/unlike', 'unlikeSong')->whereNumber('songId')->name('unlike');

        Route::get('favorite', 'getFavoriteSongs')->name('favorite');
    });
});





