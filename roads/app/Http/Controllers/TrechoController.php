<?php

namespace App\Http\Controllers;

use App\Models\Trecho; // Importe o modelo Trecho
use Illuminate\Http\Request;

class TrechoController extends Controller
{
    public function index()
    {
        // Retornar todos os registros da tabela 'trechos'
        return response()->json(Trecho::all());
    }

    public function store(Request $request)
    {
        // Validar os dados recebidos do formulário
        $validatedData = $request->validate([
            'data_referencia' => 'required|date',
            'uf_id' => 'required|exists:ufs,id',
            'rodovia_id' => 'required|exists:rodovias,id',
            'tipo_trecho' => 'required|in:A,B,C', // Adicione outros tipos conforme necessário
            'quilometragem_inicial' => 'required|numeric',
            'quilometragem_final' => 'required|numeric|gt:quilometragem_inicial',
        ]);

        // Salvar os dados na tabela 'trechos'
        $trecho = Trecho::create($validatedData);

        // Retornar uma resposta de sucesso (pode ser personalizado conforme necessário)
        return response()->json(['message' => 'Trecho cadastrado com sucesso', 'trecho' => $trecho]);
    }
}
