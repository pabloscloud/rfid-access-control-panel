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

class ApiController extends Controller
{
    public function updateKey(Request $r)
    {
        $token = Str::random(60);

        $r->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return back()->with('token', $token);
    }

    public function showChip(Request $r)
    {
        if (Auth::guard('api')->user()->isAdmin()){
            $chip = Chip::where('uid', $r->uid)->first();
            if($chip){
                return response()->json(['message' => 'Here\'s your chip! Eat it or whatever..', 'data' => $chip], 200);
            } else {
                return response()->json(['message' => 'No such chip. Add it first!'], 404);
            }
        } else {
            return response()->json(['error' => 'Forbidden :/'], 403);
        }
    }

    public function addChip(Request $r)
    {
        if (Auth::guard('api')->user()->isAdmin()) {
            try {
                $chip = Chip::create([
                    'name' => $r->query('name'),
                    'uid' => $r->query('uid'),
                    'user_id' => $r->query('user'),
                ]);
                return response()->json(['message' => 'Chip created successfully :)', 'data' => $chip], 201);
            } catch (\Illuminate\Database\QueryException $e) {
                // Unique constraint violation handling
                if ($e->errorInfo[1] == 1062) {
                    return response()->json(['error' => 'Chip conflicts with an existing chip :/'], 409);
                }
                // Other database-related errors
                return response()->json(['error' => 'Failed to create chip :/'], 500);
            }
        } else {
            return response()->json(['error' => 'Forbidden :/'], 403);
        }
    }

    public function addLog(Request $r)
    {
        if (Auth::guard('api')->user()->isAdmin()) {
            try {
                $chip = Chip::where('uid', $r->uid)->first();

                if ($chip) {
                    $pin = $r->query('pin');
                    $user = $chip->user;
                    $userInRooms = UserInRooms::where('user_id', $user->id);

                    if ($pin) {
                        if($user->attempts < 3) {
                            $success = Hash::check($pin, $user->pin);

                            if ($success) {
                                if ($userInRooms->count() <= 0) {
                                    UserInRooms::create([
                                        'user_id' => $user->id,
                                    ]);
                                }

                                $log = Log::create([
                                    'user_id' => $user->id,
                                    'chip_id' => $chip->id,
                                    'success' => $success,
                                ]);

                                return response()->json(['message' => 'Log created successfully. User added to room!', 'data' => $log], 201);
                            } else {
                                $user->update([
                                    'attempts' => $user->attempts + 1,
                                ]);

                                $log = Log::create([
                                    'user_id' => $user->id,
                                    'chip_id' => $chip->id,
                                    'success' => $success,
                                ]);

                                return response()->json(['message' => 'Log created successfully. Wrong pin!', 'data' => $log], 201);
                            }
                        } else {
                            return response()->json(['error' => 'Too many unsuccessful attempts!'], 429);
                        }
                    } else {
                        if ($userInRooms) {
                            $userInRooms->delete();

                            return response()->json(['message' => 'User removed from room!'], 201);
                        } else {
                            return response()->json(['message' => 'User not in here.'], 201);
                        }
                    }
                } else {
                    return response()->json(['error' => 'No such chip. Add it first!'], 404);
                }
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['error' => 'Failed to create log :/', 'data' => $e], 500);
            }
        } else {
            return response()->json(['error' => 'Forbidden :/'], 403);
        }
    }
}
