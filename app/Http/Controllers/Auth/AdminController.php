<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Chip;
use App\Models\Log;
use App\Models\User;
use App\Models\UserInRooms;

class AdminController extends Controller
{
    public function show()
    {
        if(Auth::User()->isAdmin()) {
            $chips = Chip::whereNotNull('user_id')
                ->orderBy('created_at', 'desc')
                ->get();
            $chipsUnassigned = Chip::whereNull('user_id')
               ->orderBy('created_at', 'desc')
               ->get();
            $logs = Log::orderBy('created_at', 'desc')->get();
            $users = User::orderBy('updated_at', 'desc')->get();
            $userInRooms = UserInRooms::orderBy('created_at', 'desc')->get();

            return view('admin', [
                'chips' => $chips,
                'chipsUnassigned' => $chipsUnassigned,
                'logs' => $logs,
                'users' => $users,
                'userInRooms' => $userInRooms
            ]);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function deleteChip(Chip $chip)
    {
        $chip->delete();
        return redirect()->back()->with('success', 'Chip deleted.');
    }

    public function assignUserToChip(Request $request, Chip $chip)
    {
        $new_chip_name = $request->input('chip_name');
        $user_id = $request->input('user_id');

        $chip->update([
            'name' => $new_chip_name,
            'user_id' => $user_id,
        ]);

        return redirect()->back()->with('success', 'Chip assigned.');
    }
}
