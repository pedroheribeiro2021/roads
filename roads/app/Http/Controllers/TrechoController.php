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
    $request->validate([
        'data_referencia' => 'required|date',
        'uf_id' => 'required|integer',
        'rodovia_id' => 'required|integer',
        'quilometragem_inicial' => 'required|numeric',
        'quilometragem_final' => 'required|numeric',
    ]);

    // Montar a URL da API do DNIT com os parâmetros do formulário
    $url = sprintf(
        'https://servicos.dnit.gov.br/sgplan/apigeo/rotas/espacializarlinha?br=%s&tipo=%s&uf=%s&data=%s&kmi=%s&kmf=%s',
        $request->rodovia_id,
        'tipo_especifico', // Substituir pelo tipo específico desejado
        $request->uf_id,
        $request->data_referencia,
        $request->quilometragem_inicial,
        $request->quilometragem_final
    );

    // Realizar a requisição GET à API do DNIT
    $response = Http::get($url);

    if ($response->successful()) {
        $geo = $response->body();
    } else {
        return response()->json(['error' => 'Erro ao buscar GeoJSON na API do DNIT'], 500);
    }

    // Salvar o trecho no banco de dados
    $trecho = new Trecho([
        'data_referencia' => $request->data_referencia,
        'uf_id' => $request->uf_id,
        'rodovia_id' => $request->rodovia_id,
        'quilometragem_inicial' => $request->quilometragem_inicial,
        'quilometragem_final' => $request->quilometragem_final,
        'geo' => $geo,
    ]);

    $trecho->save();

    return response()->json($trecho, 201);
}


    public function index()
    {
        $trechos = Trecho::paginate(10); // Implementando paginação
        return Inertia::render('Trechos/Index', ['trechos' => $trechos]);
    }
}
