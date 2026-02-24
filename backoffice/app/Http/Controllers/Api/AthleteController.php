<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use Illuminate\Http\Request;

class AthleteController extends Controller
{
    public function index()
    {
        $athletes = Athlete::with(['country', 'disciplines'])->get();

        return response()->json([
            'success' => true,
            'data'    => $athletes
        ], 200);
    }

    public function show(string $id)
    {
        $athlete = Athlete::with(['country', 'disciplines'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $athlete
        ], 200);
    }
}
