<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Discipline;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    public function index(Request $request)
    {
        $query = Discipline::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sport', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('sport')) {
            $query->where('sport', $request->sport);
        }

        $disciplines = $query->with('athletes.country')
            ->orderBy('name', 'asc')
            ->get();

        
        return response()->json([
            'success' => true,
            'data' => $disciplines
        ], 200);
    }

    public function show(string $id)
    {
        $discipline = Discipline::with('athletes.country')->find($id);

        if (!$discipline) {
            return response()->json([
                'success' => false,
                'message' => 'Disciplina non trovata'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $discipline
        ], 200);
    }
}
