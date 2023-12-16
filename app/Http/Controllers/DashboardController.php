<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function show()
    {
        $chips = Auth::user()->chips;
        $logs = Auth::user()->logs;

        return view('dashboard', [
            'chips' => $chips,
            'logs' => $logs,
        ]);
    }
}
