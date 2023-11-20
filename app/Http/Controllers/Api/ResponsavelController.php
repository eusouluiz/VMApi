<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Models\ResponsavelResource;
use App\Models\Responsavel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResponsavelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $responsaveis = Responsavel::all()->load('user');

        if ($responsaveis->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => ResponsavelResource::collection($responsaveis)], 404);
        }

        return response()->json(ResponsavelResource::collection($responsaveis), 200);
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
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $responsavel = Responsavel::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => new ResponsavelResource($responsavel)], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Responsavel $responsavel
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Responsavel $responsavel)
    {
        $responsavel->loadMissing('user', 'alunos');

        return response()->json(new ResponsavelResource($responsavel), 200);
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
        $responsavel = Responsavel::find($id);

        if (!$responsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $responsavel->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => new ResponsavelResource($responsavel)], 200);
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
        $responsavel = Responsavel::find($id);

        if (!$responsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $responsavel->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
