<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Canal;
use App\Models\Cargo;
use Validator;

class CanalCargoController extends Controller
{
 

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show', 'store', 'update', 'destroy']]);
    }

    /**
     * Associar um cargo a um canal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'canal_id' => 'required|exists:canais,id',
            'cargo_id' => 'required|exists:cargos,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $canal = Canal::find($request->canal_id);
        $cargo = Cargo::find($request->cargo_id);

        // Verifica se o cargo já está associado ao canal
        if ($canal->cargos()->where('cargo_id', $cargo->id)->exists()) {
            return response()->json(['msg' => 'O cargo já está associado a este canal.'], 400);
        }

        $canal->cargos()->attach($cargo);

        return response()->json(['msg' => 'Cargo associado com sucesso ao canal.'], 200);
    }
}
