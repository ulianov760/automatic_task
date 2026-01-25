<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.
Route::group(
    [
        'prefix' => config('backpack.base.route_prefix', 'admin'),
        'middleware' => array_merge(
            (array)config('backpack.base.web_middleware', 'web'),
            (array)config('backpack.base.middleware_key', 'admin')
        ),
        'namespace' => 'App\Http\Controllers\Admin',
    ],
    function () {
        Route::crud('', 'TeamCrudController');
        Route::crud('groups', 'GroupCrudController');
        Route::crud('employees', 'EmployeeCrudController');
        Route::crud('posts', 'PostCrudController');
        Route::crud('roles', 'RoleCrudController');
        Route::crud('priorities', 'PriorityCrudController');
        Route::crud('statuses', 'StatusCrudController');
        Route::crud('tasks', 'TaskCrudController');
        Route::crud('companies', 'CompanyCrudController');
        Route::crud('payment-statuses', 'PaymentStatusCrudController');
        Route::crud('vacation-statuses', 'VacationStatusCrudController');
        Route::crud('type-transactions', 'TypeTransactionCrudController');
        Route::crud('settlements', 'SettlementCrudController');
        Route::crud('vacations', 'VacationCrudController');
        Route::crud('my-vacations', 'MyVacationCrudController');


        //Route::redirect('dashboard','/admin');
    }
);
