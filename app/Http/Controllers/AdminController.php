<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chip;
use App\Models\Log;
use App\Models\UserInRooms;

class AdminController extends Controller
{
    public function show()
    {
        if(Auth::User()->isAdmin()) {
            $chips = Chip::orderBy('created_at', 'desc')->get();
            $logs = Log::orderBy('created_at', 'desc')->get();
            $userInRooms = UserInRooms::orderBy('created_at', 'desc')->get();

            return view('admin', [
                'chips' => $chips,
                'logs' => $logs,
                'userInRooms' => $userInRooms
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }
}
