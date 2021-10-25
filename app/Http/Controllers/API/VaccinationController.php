<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Society;
use App\Models\Vaccination;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    //
    function __construct (Consultation $consultation, Society $society, Vaccination $vaccination) {
        $this->consultation = $consultation;
        $this->user = $society;
        $this->vaccination = $vaccination;
    }

    public function index (Request $request) {
        $user = $this->user->where('login_tokens', $request->token)->first();
        if (!$user) return response()->json(['message' => 'Unauthorized user'], 401);

        $first = $this->vaccination->where('society_id', $user->id)->with(['spot.regional', 'vaccine', 'doctor', 'officer'])->first();
        $second = $this->vaccination->where('society_id', $user->id)->with(['spot.regional', 'vaccine', 'doctor', 'officer'])->skip(1)->first();

        return response()->json([
            'first' => $first,
            'second' => $second,
        ], 200);
    }

    public function store (Request $request) {
        $user = $this->user->where('login_tokens', $request->token)->first();
        if (!$user) return response()->json(['message' => 'Unauthorized user'], 401);

        // < 30 day
        $vaccination = $this->vaccination->where('society_id', $user->id)->first();
        if ($vaccination) {
            $now = date_create($request->date);
            $date = date_create($vaccination->date);
            $diff = date_diff($now, $date);
            $diff_day = $diff->d + ($diff->m * 30) + ($diff->y * 12 * 30);

            if ($diff_day < 30) {
                return response()->json(['message' => 'Wait at least +30 days from the day of the first vaccination'], 401);
            }
        }
        $vaccination_count = $this->vaccination->where('society_id', $user->id)->count();
        if ($vaccination_count >= 2) {
            return response()->json(['message' => 'You have been 2x vaccinated'], 401);
        }

        $vaccination = $this->vaccination->create([
            'dose' => $vaccination ? 2 : 1,
            'date' => $request->date,
            'society_id' => $user->id,
            'spot_id' => $request->spot_id,
        ]);

        return response()->json(['message' => 'Register vaccination success'], 200);

    }
}
