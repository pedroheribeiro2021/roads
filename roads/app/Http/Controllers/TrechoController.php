<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trecho;
use Illuminate\Support\Facades\Log;

class TrechoController extends Controller
{
    public function store(Request $request)
    {
        Log::info($request->all());
    
        $request->validate([
            'data_referencia' => 'required|date',
            'uf_id' => 'required|integer',
            'rodovia_id' => 'required|integer',
            'quilometragem_inicial' => 'required|numeric',
            'quilometragem_final' => 'required|numeric',
            'geo' => 'required|json',
        ]);
    
        Log::info('Validation passed.');
    
        $trecho = new Trecho([
            'data_referencia' => $request->data_referencia,
            'uf_id' => $request->uf_id,
            'rodovia_id' => $request->rodovia_id,
            'quilometragem_inicial' => $request->quilometragem_inicial,
            'quilometragem_final' => $request->quilometragem_final,
            'geo' => $request->geo,
        ]);
    
        $trecho->save();
    
        Log::info('Trecho saved.');
    
        return response()->json($trecho, 201);
    }    

    public function index()
    {
        $trechos = Trecho::all();
        return response()->json($trechos);
    }
}
