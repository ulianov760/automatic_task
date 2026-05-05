<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BackupCustomController extends Controller
{
    public function create()
    {
        $artisan = base_path('artisan');
        exec("start /B php $artisan backup:run --only-db > nul 2>&1");

        return response()->json([
                                    'status' => 'success',
                                    'message' => 'Процесс резервного копирования запущен в фоновом режиме.'
                                ]);
    }
}
