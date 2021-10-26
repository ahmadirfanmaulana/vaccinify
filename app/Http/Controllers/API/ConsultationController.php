<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Society;
use Illuminate\Http\Request;
use Validator;

class ConsultationController extends Controller
{
    //
    function __construct (Consultation $consultation, Society $society) {
        $this->consultation = $consultation;
        $this->user = $society;
    }

    public function index (Request $request) {
        $user = $this->user->where('login_tokens', $request->token)->first();
        if (!$user  || !$request->token) return response()->json(['message' => 'Unauthorized user'], 401);

        $consultation = $this->consultation->where('society_id', $user->id)->with(['doctor'])->first();
        return response()->json([
            'consultation' => $consultation
        ], 200);
    }

    public function store (Request $request) {
        $user = $this->user->where('login_tokens', $request->token)->first();
        if (!$user  || !$request->token) return response()->json(['message' => 'Unauthorized user'], 401);

        // validator
        $consultation = $this->consultation->where('society_id', $user->id)->first();
        if ($consultation) return response()->json(['message' => 'Request failed. You have done consultation.']);

        $this->consultation->create([
            'society_id' => $user->id,
            'disease_history' => $request->disease_history,
            'current_symptoms' => $request->current_symptoms,
        ]);

        return response()->json(['message' => 'Request consultation sent successful'], 200);
    }
}
