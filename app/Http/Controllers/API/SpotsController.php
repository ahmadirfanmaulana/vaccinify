<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Society;
use App\Models\Spot;
use App\Models\Vaccination;
use Illuminate\Http\Request;

class SpotsController extends Controller
{
    //
    function __construct (Consultation $consultation, Society $society, Vaccination $vaccination, Spot $spot) {
        $this->consultation = $consultation;
        $this->user = $society;
        $this->vaccination = $vaccination;
        $this->spot = $spot;
    }

    public function index (Request $request) {
        $user = $this->user->where('login_tokens', $request->token)->first();
        if (!$user) return response()->json(['message' => 'Unauthorized user'], 401);

        $spots = $this->spot->where('regional_id', $user->regional_id)->get();
        return response()->json([
            'regional' => $user->regional,
            'spots' => $spots,
        ], 200);
    }

    public function show (Request $request, Spot $spot) {
        $user = $this->user->where('login_tokens', $request->token)->first();
        if (!$user) return response()->json(['message' => 'Unauthorized user'], 401);

        if (!$request->date) $request->date = date('Y-m-d');

        $spot = $this->spot->where('id', $spot->id)->first();
        $spot->vaccinations_count = $this->vaccination->whereDate('date', $request->date)->where('spot_id', $spot->id)->count();
        $spot = collect($spot)->forget('available_vaccines');

        return response()->json([
            'date' => date('F j, Y', strtotime($request->date)),
            'spot' => $spot,
        ], 200);
    }
}
