<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aviso;
use App\Models\Responsavel;
use Validator;

class AvisoResponsavelController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show', 'store', 'update', 'destroy']]);
    }

    /**
     * Associar um aviso a um responsável.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aviso_id' => 'required|exists:avisos,id',
            'responsavel_id' => 'required|exists:responsaveis,id',
            'ind_visualizacao' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $aviso = Aviso::find($request->aviso_id);
        $responsavel = Responsavel::find($request->responsavel_id);

        // Verifica se o aviso já está associado ao responsável
        if ($aviso->responsaveis()->where('responsavel_id', $responsavel->id)->exists()) {
            return response()->json(['msg' => 'O responsável já está associado a este aviso.'], 400);
        }

        $aviso->responsaveis()->attach($responsavel, ['ind_visualizacao' => $request->input('ind_visualizacao', false)]);

        return response()->json(['msg' => 'Responsável associado com sucesso ao aviso.'], 200);
    }
}
