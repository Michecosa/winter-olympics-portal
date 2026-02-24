<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\Country;
use App\Models\Discipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AthleteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::with(['athletes' => function($query) {
            $query->orderBy('last_name', 'asc');
        }])->get();

        return view('admin.athletes.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get();
        $disciplines = Discipline::orderBy('name')->get();

        return view('admin.athletes.create', compact('countries', 'disciplines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $athlete = new Athlete();

        $athlete->first_name = $data['first_name'];
        $athlete->last_name = $data['last_name'];
        $athlete->country_id = $data['country_id'];
        $athlete->birth_date = $data['birth_date'];
        $athlete->bio = $data['bio'];

        $athlete->save();

        if (array_key_exists('disciplines', $data)) {
            $athlete->disciplines()->sync($data['disciplines']);
        } else {
            // Teoricamente non serve ma mi sono affezionata e quindi resta qui
            $athlete->disciplines()->sync([]);
        }
        return redirect()->route("athletes.show", $athlete->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Athlete $athlete)
    {
        # dd($athlete);
        return view('admin.athletes.show', compact('athlete'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Athlete $athlete)
    {
        $countries = Country::orderBy('name', 'asc')->get();
        $disciplines = Discipline::orderBy('name', 'asc')->get();

        return view('admin.athletes.edit', compact('athlete', 'countries', 'disciplines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $athlete = Athlete::findOrFail($id);

        $athlete->first_name = $data['first_name'];
        $athlete->last_name = $data['last_name'];
        $athlete->country_id = $data['country_id'];
        $athlete->birth_date = $data['birth_date'];
        $athlete->bio = $data['bio'];

        $athlete->save();

        if (array_key_exists('disciplines', $data)) {
            $athlete->disciplines()->sync($data['disciplines']);
        } else {
            $athlete->disciplines()->sync([]);
        }

        return redirect()->route("athletes.show", $athlete->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $athlete = Athlete::findOrFail($id);

        $athlete->disciplines()->detach();
        $athlete->delete();

        return redirect()->route('athletes.index');
    }
}
