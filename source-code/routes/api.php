<?php

use App\Http\Controllers\Admin\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('get-data', [ReportController::class, 'getData']);
Route::post('create-report', [ReportController::class, 'createReport']);
