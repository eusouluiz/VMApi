<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aviso;
use App\Models\Turma;
use Validator;

class AvisoTurmaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show', 'store', 'update', 'destroy']]);
    }
    /**
     * Associar um aviso a uma turma.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aviso_id' => 'required|exists:avisos,id',
            'turma_id' => 'required|exists:turmas,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $aviso = Aviso::find($request->aviso_id);
        $turma = Turma::find($request->turma_id);

        // Verifica se o aviso já está associado à turma
        if ($aviso->turmas()->where('turma_id', $turma->id)->exists()) {
            return response()->json(['msg' => 'A turma já está associada a este aviso.'], 400);
        }

        $aviso->turmas()->attach($turma);

        return response()->json(['msg' => 'Turma associada com sucesso ao aviso.'], 200);
    }
}
