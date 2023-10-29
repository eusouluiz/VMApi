<?php

namespace App\Http\Controllers\Api;

use App\Models\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CargoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show', 'store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargo = Cargo::all();

        if ($cargo->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $cargo], 404);
        }

        return response()->json($cargo, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'nome' => 'required',
            'descricao' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $cargo = Cargo::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => $cargo], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($cargo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'nome' => 'required',
            'descricao' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $cargo->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $cargo], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cargo = Cargo::find($id);

        if (!$cargo) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $cargo->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
