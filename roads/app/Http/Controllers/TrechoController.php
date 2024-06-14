<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trecho;
use App\Models\Uf;
use App\Models\Rodovia;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class TrechoController extends Controller
{
    public function create()
    {
        $ufs = Uf::all();
        $rodovias = Rodovia::all();
        return Inertia::render('Trechos/Create', [
            'ufs' => $ufs,
            'rodovias' => $rodovias
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'data_referencia' => 'required|date',
                'uf_id' => 'required|integer',
                'rodovia_id' => 'required|integer',
                'quilometragem_inicial' => 'required|numeric',
                'quilometragem_final' => 'required|numeric',
                'geo' => 'required|array', // Verifique se o campo geo é um array conforme definido no model
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
    
            return response()->json($trecho, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar o trecho: ' . $e->getMessage()], 500);
        }
    }
    


    public function index()
    {
        $trechos = Trecho::paginate(10); // Implementando paginação
        return Inertia::render('Trechos/Index', ['trechos' => $trechos]);
    }
}
