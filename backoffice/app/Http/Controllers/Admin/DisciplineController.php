<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\Discipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $availableSports = Discipline::select('sport')
            ->distinct()
            ->orderBy('sport', 'asc')
            ->pluck('sport');

        return view('admin.disciplines.index', compact('disciplines', 'availableSports'));
    }

    /**
     * Show the form for creating a new resource.
     */
        public function create()
        {
            $athletes = Athlete::orderBy('first_name', 'asc')->get();

            $availableSports = Discipline::select('sport')
                ->distinct()
                ->orderBy('sport', 'asc')
                ->pluck('sport');
            
            return view("admin.disciplines.create", compact('athletes', 'availableSports'));
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $newDiscipline = new Discipline();

        $newDiscipline->name = $data['name'];
        $newDiscipline->sport = $data['sport'];
        $newDiscipline->description = $data['description'];

        if ($request->hasFile('cover_image')) {
            $img_path = Storage::putFile('disciplines_images', $request->file('cover_image'));
            $newDiscipline->cover_image = $img_path;
        }
        $newDiscipline->save();

        if (array_key_exists('athletes', $data)) {
            $newDiscipline->athletes()->attach($data['athletes']);
        }

        return redirect()->route("disciplines.show", $newDiscipline->id);
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
        $athletes = Athlete::orderBy('first_name', 'asc')->get();
        $discipline = Discipline::findOrFail($id); 

        $availableSports = Discipline::select('sport')
            ->distinct()
            ->orderBy('sport', 'asc')
            ->pluck('sport');

        return view("admin.disciplines.edit", compact('athletes', 'discipline', 'availableSports'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $discipline = Discipline::findOrFail($id);

        $discipline->name = $data['name'];
        $discipline->sport = $data['sport'];
        $discipline->description = $data['description'];

        if ($request->hasFile('cover_image')) {
            if ($discipline->cover_image) {
                Storage::delete($discipline->cover_image);
            }

            $img_path = Storage::putFile('disciplines_images', $request->file('cover_image'));
            $discipline->cover_image = $img_path;
        }

        $discipline->save();

        if (array_key_exists('athletes', $data)) {
            $discipline->athletes()->sync($data['athletes']);
        } else {
            $discipline->athletes()->sync([]);
        }

        return redirect()->route("disciplines.show", $discipline->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discipline $discipline)
    {
        if ($discipline->cover_image && !str_starts_with($discipline->cover_image, 'http')) {
            Storage::delete($discipline->cover_image);
        }

        $discipline->athletes()->detach();
        $discipline->delete();

        return redirect()->route("disciplines.index");
    }
}
