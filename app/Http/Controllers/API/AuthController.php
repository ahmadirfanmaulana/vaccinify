<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Society;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    function __construct (Society $society) {
        $this->user = $society;
    }

    public function login(Request $request) {
        $credentials = [
            'id_card_number' => $request->id_card_number,
            'password' => $request->password,
        ];

        if ($user = $this->user->where($credentials)->with(['regional'])->first()) {
            $token = md5($user->id_card_number);
            $user->update(['login_tokens' => $token]);
            $user->token = $token;

            return response()->json($user, 200);
        }

        return response()->json(['message' => 'ID card number or password not correct'], 401);
    }

    public function logout (Request $request) {
        $user = $this->user->where('login_tokens', $request->token)->first();
        if (!$user) return response()->json(['message' => 'Unauthorized user'], 401);

        $user->update(['login_tokens' => NULL]);
        return response()->json(['message' => 'Logout success'], 200);

    }
}
