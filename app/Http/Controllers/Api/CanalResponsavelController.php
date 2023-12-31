<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Models\CanalResponsavelResource;
use App\Models\CanalResponsavel;
use App\Models\Mensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CanalResponsavelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $canalResponsavel = CanalResponsavel::with('canal', 'responsavel.user')->get();

        return response()->json(CanalResponsavelResource::collection($canalResponsavel), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function store(Request $request)

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'canal_id'       => 'required|exists:canais,id',
            'responsavel_id' => 'required|exists:responsaveis,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $canalId = $request->input('canal_id');
        $responsavelId = $request->input('responsavel_id');

        // Verifica se já existe um registro com a mesma combinação de canal_id e responsavel_id
        $existeRegistro = CanalResponsavel::with('canal', 'responsavel')->where('canal_id', $canalId)->where('responsavel_id', $responsavelId)->first();

        if ($existeRegistro) {
            return response()->json([
                'msg'  => 'Essa combinação de canal e responsável já existe.',
                'data' => new CanalResponsavelResource($existeRegistro),
            ], 400);
        }

        $data = [
            'canal_id'       => $canalId,
            'responsavel_id' => $responsavelId,
        ];

        $canalResponsavel = CanalResponsavel::create($data);

        // Carregar os relacionamentos necessários
        $canalResponsavel->load('canal', 'responsavel.user');

        // Usar o resource para formatar a resposta
        return response()->json([
            'msg'  => 'Registro cadastrado com sucesso',
            'data' => new CanalResponsavelResource($canalResponsavel),
        ], 200);
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
        $canalResponsavel = CanalResponsavel::with('canal', 'responsavel.user')->find($id);

        if (!$canalResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json(new CanalResponsavelResource($canalResponsavel), 200);
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
        $canalResponsavel = CanalResponsavel::find($id);

        if (!$canalResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'canal_id'       => 'required|exists:canais,id',
            'responsavel_id' => 'required|exists:responsaveis,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $canalResponsavel->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $canalResponsavel], 200);
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
        $canalResponsavel = CanalResponsavel::find($id);

        if (!$canalResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        Mensagem::where('canal_responsavel_id', $id)->delete();

        $canalResponsavel->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
