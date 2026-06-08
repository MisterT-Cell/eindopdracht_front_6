<?php

namespace App\Http\Controllers;

use App\Models\Afspraak;
use Illuminate\Http\Request;

class AfspraakController extends Controller
{
    public function index()
    {
        return response()->json(Afspraak::orderBy('datum')->orderBy('tijd')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'naam' => 'required|string',
            'datum' => 'required|date',
            'tijd' => 'required',
            'dienst' => 'required|string',
            'opmerking' => 'nullable|string',
        ]); 

        $afspraak = Afspraak::create($data);

        return response()->json($afspraak, 201);
    }

    public function show($id)
    {
        $afspraak = Afspraak::findOrFail($id);
        return response()->json($afspraak);
    }

    public function update(Request $request, $id)
    {
        $afspraak = Afspraak::findOrFail($id);

        $data = $request->validate([
            'naam' => 'required|string',
            'datum' => 'required|date',
            'tijd' => 'required',
            'dienst' => 'required|string',
            'opmerking' => 'nullable|string',
        ]);

        $afspraak->update($data);

        return response()->json($afspraak);
    }

    public function destroy($id)
    {
        $afspraak = Afspraak::findOrFail($id);
        $afspraak->delete();

        return response()->json(['bericht' => 'Afspraak verwijderd.']);
    }
}