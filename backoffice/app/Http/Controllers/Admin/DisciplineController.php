<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discipline;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    public function index(Request $request)
    {
        $query = Discipline::query();
        if ($request->has('search') && $request->search != '') {
            # WHERE (name LIKE ... OR sport LIKE ...) ...
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sport', 'like', '%' . $request->search . '%');
            });
        }
        # ... AND sport = ...
        if ($request->has('sport') && $request->sport != '') {
            $query->where('sport', $request->sport);
        }

        $disciplines = $query->orderBy('name', 'asc')->get();

        return view('admin.disciplines.index', compact('disciplines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $discipline = Discipline::find($id);

        # dd($discipline->athletes);
        return view('admin.disciplines.show', compact('discipline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
