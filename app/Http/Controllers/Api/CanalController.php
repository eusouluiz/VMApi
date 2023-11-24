<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Models\CanalResource;
use App\Models\Canal;
use Illuminate\Http\Request;
use Validator;

class CanalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $canal = Canal::all();

        if ($canal->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => CanalResource::collection($canal)], 404);
        }

        return response()->json(CanalResource::collection($canal), 200);
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

        $canal = Canal::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => new CanalResource($canal)], 200);
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
        
        $canal = Canal::with('cargos')->find($id);

        if (!$canal) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json(new CanalResource($canal), 200);
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
        $canal = Canal::find($id);

        if (!$canal) {
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

        $canal->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => new CanalResource($canal)], 200);
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
        $canal = Canal::find($id);

        if (!$canal) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $canal->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
