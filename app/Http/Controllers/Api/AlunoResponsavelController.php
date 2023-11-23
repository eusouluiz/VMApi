<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AlunoResponsavel;
use DB;
use Illuminate\Http\Request;
use Validator;

class AlunoResponsavelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $alunoResponsavel = DB::table('aluno_responsavel')
            ->join('alunos AS A', 'aluno_responsavel.aluno_id', '=', 'A.id')
            ->join('responsaveis AS R', 'aluno_responsavel.responsavel_id', '=', 'R.id')
            ->join('users AS U', 'R.user_id', '=', 'U.id')
            ->select(
                'aluno_responsavel.*',
                'A.nome as aluno_nome',
                'U.nome as responsavel_nome'
            )
            ->get();

        if ($alunoResponsavel->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $alunoResponsavel], 404);
        }

        return response()->json($alunoResponsavel, 200);
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
            'aluno_id'       => 'required|exists:alunos,id',
            'responsavel_id' => 'required|exists:responsaveis,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $alunoId = $request->input('aluno_id');
        $responsavelId = $request->input('responsavel_id');

        $existeRegistro = AlunoResponsavel::where('aluno_id', $alunoId)
            ->where('responsavel_id', $responsavelId)
            ->first();

        if ($existeRegistro) {
            return response()->json(['msg' => 'Essa combinação de aluno e responsável já existe.', 'data' => $existeRegistro], 400);
        }

        $data = [
            'aluno_id'       => $alunoId,
            'responsavel_id' => $responsavelId,
        ];

        $alunoResponsavel = AlunoResponsavel::create($data);

        return response()->json(['msg' => 'Associação cadastrada com sucesso', 'data' => $alunoResponsavel], 200);
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
        $alunoResponsavel = DB::table('aluno_responsavel')
            ->join('alunos AS A', 'aluno_responsavel.aluno_id', '=', 'A.id')
            ->join('responsaveis AS R', 'aluno_responsavel.responsavel_id', '=', 'R.id')
            ->join('users AS U', 'R.user_id', '=', 'U.id')
            ->select(
                'aluno_responsavel.*',
                'A.nome as aluno_nome',
                'U.nome as responsavel_nome'
            )
            ->where('aluno_responsavel.id', '=', $id)
            ->first();

        if (!$alunoResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($alunoResponsavel, 200);
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
        $alunoResponsavel = AlunoResponsavel::find($id);

        if (!$alunoResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $validator = Validator::make($request->all(), [
            'aluno_id'       => 'required|exists:alunos,id',
            'responsavel_id' => 'required|exists:responsaveis,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $alunoResponsavel->update($request->only(['aluno_id', 'responsavel_id']));

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $alunoResponsavel], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($alunoId, $responsavelId)
    {
        $alunoResponsavel = AlunoResponsavel::where('aluno_id', $alunoId)
            ->where('responsavel_id', $responsavelId)
            ->first();

        if (!$alunoResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $alunoResponsavel->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
