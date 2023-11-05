<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\Funcionalidade;
use Validator;

class CargoFuncionalidadeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show', 'store', 'update', 'destroy']]);
    }

    /**
     * Associar uma funcionalidade a um cargo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cargo_id' => 'required|exists:cargos,id',
            'funcionalidade_id' => 'required|exists:funcionalidades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $cargo = Cargo::find($request->cargo_id);
        $funcionalidade = Funcionalidade::find($request->funcionalidade_id);

        // Verifica se a funcionalidade já está associada ao cargo
        if ($cargo->funcionalidades()->where('funcionalidade_id', $funcionalidade->id)->exists()) {
            return response()->json(['msg' => 'A funcionalidade já está associada a este cargo.'], 400);
        }

        $cargo->funcionalidades()->attach($funcionalidade);

        return response()->json(['msg' => 'Funcionalidade associada com sucesso ao cargo.'], 200);
    }
}
