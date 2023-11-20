<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AvisoTurma;
use DB;
use Illuminate\Http\Request;
use Validator;

class AvisoTurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $avisoTurma = DB::table('aviso_turma')
            ->join('avisos AS AV', 'aviso_turma.aviso_id', '=', 'AV.id')
            ->join('turmas AS T', 'aviso_turma.turma_id', '=', 'T.id')
            ->select('aviso_turma.*', 'AV.texto as aviso_texto', 'T.nome as turma_nome')
            ->get();

        if ($avisoTurma->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $avisoTurma], 404);
        }

        return response()->json($avisoTurma, 200);
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
        $validator = Validator::make($request->all(), [
            'aviso_id' => 'required|exists:avisos,id',
            'turma_id' => 'required|exists:turmas,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $avisoId = $request->input('aviso_id');
        $turmaId = $request->input('turma_id');

        $existeRegistro = AvisoTurma::where('aviso_id', $avisoId)
            ->where('turma_id', $turmaId)
            ->first();

        if ($existeRegistro) {
            return response()->json(['msg' => 'Essa combinação de aviso e turma já existe.', 'data' => $existeRegistro], 400);
        }

        $data = [
            'aviso_id' => $avisoId,
            'turma_id' => $turmaId,
        ];

        $avisoTurma = AvisoTurma::create($data);

        return response()->json(['msg' => 'Associação cadastrada com sucesso', 'data' => $avisoTurma], 200);
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
        $avisoTurma = DB::table('aviso_turma')
            ->join('avisos AS AV', 'aviso_turma.aviso_id', '=', 'AV.id')
            ->join('turmas AS T', 'aviso_turma.turma_id', '=', 'T.id')
            ->select('aviso_turma.*', 'AV.texto as aviso_texto', 'T.nome as turma_nome')
            ->where('aviso_turma.id', '=', $id)
            ->first();

        if (!$avisoTurma) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($avisoTurma, 200);
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
        $avisoTurma = AvisoTurma::find($id);

        if (!$avisoTurma) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $validator = Validator::make($request->all(), [
            'aviso_id' => 'required|exists:avisos,id',
            'turma_id' => 'required|exists:turmas,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $avisoTurma->update($request->only(['aviso_id', 'turma_id']));

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $avisoTurma], 200);
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
        $avisoTurma = AvisoTurma::find($id);

        if (!$avisoTurma) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $avisoTurma->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
