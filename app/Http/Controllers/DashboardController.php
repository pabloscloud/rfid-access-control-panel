<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function show()
    {
        $chips = Auth::user()->chips()->orderBy('created_at', 'desc')->get();
        $logs = Auth::user()->logs()->orderBy('created_at', 'desc')->get();
        $userInRooms = Auth::user()->userInRooms()->get();

        return view('dashboard', [
            'chips' => $chips,
            'logs' => $logs,
            'userInRooms' => $userInRooms,
        ]);
    }
}
