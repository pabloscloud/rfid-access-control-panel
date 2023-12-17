<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chip;
use App\Models\Log;

class AdminController extends Controller
{
    public function show()
    {
        if(Auth::User()->isAdmin()) {
            $chips = Chip::orderBy('created_at', 'desc')->get();
            $logs = Log::orderBy('created_at', 'desc')->get();

            return view('admin', [
                'chips' => $chips,
                'logs' => $logs,
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }
}
