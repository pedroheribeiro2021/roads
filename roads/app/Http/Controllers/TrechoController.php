<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trecho;
use App\Models\Rodovia;
use App\Models\Uf;
use Inertia\Inertia;

class TrechoController extends Controller
{
    public function create()
    {
        $ufs = Uf::all();
        $rodovias = Rodovia::all();

        return Inertia::render('Trechos/Create', [
            'ufs' => $ufs,
            'rodovias' => $rodovias,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_referencia' => 'required|date',
            'uf_id' => 'required|integer',
            'rodovia_id' => 'required|integer',
            'quilometragem_inicial' => 'required|numeric',
            'quilometragem_final' => 'required|numeric',
            'geo' => 'required|json',
        ]);

        $trecho = new Trecho([
            'data_referencia' => $request->data_referencia,
            'uf_id' => $request->uf_id,
            'rodovia_id' => $request->rodovia_id,
            'quilometragem_inicial' => $request->quilometragem_inicial,
            'quilometragem_final' => $request->quilometragem_final,
            'geo' => $request->geo,
        ]);

        $trecho->save();

        // return response()->json($trecho, 201);
        return redirect()->route('trechos.create')->with('success', 'Trecho cadastrado com sucesso!');
    }

    public function index()
    {
        $trechos = Trecho::all();
        return response()->json($trechos);
    }
}
