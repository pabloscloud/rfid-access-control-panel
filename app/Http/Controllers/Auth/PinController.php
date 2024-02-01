<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chip;
use App\Models\Log;
use App\Models\UserInRooms;

class PinController extends Controller
{
    public function updatePin(Request $r)
    {
        $pin = random_int(100000, 999999);

        $r->user()->forceFill([
            'pin' => Hash::make($pin),
            'attempts' => '0',
        ])->save();

        return back()->with('pin', $pin);
    }
}
