<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Models\FuncionarioResource;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $funcionarios = Funcionario::all()->load('user', 'cargo');

        if ($funcionarios->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => FuncionarioResource::collection($funcionarios)], 404);
        }

        return response()->json(FuncionarioResource::collection($funcionarios), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id'  => 'required',
           
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $funcionario = Funcionario::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => new FuncionarioResource($funcionario)], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Funcionario $funcionario
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Funcionario $funcionario)
    {
      
        $funcionario->loadMissing('user', 'cargo');

        return response()->json(new FuncionarioResource($funcionario), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id'  => 'required',
         
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $funcionario->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => new FuncionarioResource($funcionario)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $funcionario->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
