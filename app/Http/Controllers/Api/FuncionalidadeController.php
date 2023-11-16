<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Models\FuncionalidadeResource;
use App\Models\Funcionalidade;
use Illuminate\Http\Request;
use Validator;

class FuncionalidadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show', 'store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $funcionalidade = Funcionalidade::all();

        if ($funcionalidade->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => FuncionalidadeResource::collection($funcionalidade)], 404);
        }

        return response()->json(FuncionalidadeResource::collection($funcionalidade), 200);
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
            'nome'      => 'required',
            'descricao' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $funcionalidade = Funcionalidade::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => new FuncionalidadeResource($funcionalidade)], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $funcionalidade = Funcionalidade::find($id);

        if (!$funcionalidade) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json(new FuncionalidadeResource($funcionalidade), 200);
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
        $funcionalidade = Funcionalidade::find($id);

        if (!$funcionalidade) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'nome'      => 'required',
            'descricao' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $funcionalidade->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => new FuncionalidadeResource($funcionalidade)], 200);
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
        $funcionalidade = Funcionalidade::find($id);

        if (!$funcionalidade) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $funcionalidade->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
