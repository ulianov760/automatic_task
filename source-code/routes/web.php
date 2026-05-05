<?php

use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

//Route::get('/',[SiteController::class,'index']);
//Route::get('/category',[SiteController::class,'category']);
//Route::get('/equipment/{id}',[SiteController::class,'equipment']);
//Route::get("/search",[SiteController::class,'search']);
Route::group([
                 'prefix'     => config('backpack.base.route_prefix', 'admin'),
                 'middleware' => array_merge(
                     (array) config('backpack.base.web_middleware', 'web'),
                     (array) config('backpack.base.middleware_key', 'admin')
                 ),
             ], function () {
    Route::put('backup/create', [\App\Http\Controllers\Admin\BackupCustomController::class, 'create'])->name('backup.store');

});
