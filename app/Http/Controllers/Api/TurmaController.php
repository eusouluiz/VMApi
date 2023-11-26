<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Models\TurmaResource;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $turma = Turma::all();

        if ($turma->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => TurmaResource::collection($turma)], 404);
        }

        return response()->json(TurmaResource::collection($turma), 200);
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

        $turma = Turma::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => new TurmaResource($turma)], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // $turma = Turma::find($id);

        $turma = Turma::with('alunos')->find($id);

        if (!$turma) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json(new TurmaResource($turma), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $turma = Turma::find($id);

        if (!$turma) {
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

        $turma->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => new TurmaResource($turma)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $turma = Turma::find($id);

        if (!$turma) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        // Atualizar alunos para definir turma_id como null
        $turma->alunos()->update(['turma_id' => null]);

        $turma->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
