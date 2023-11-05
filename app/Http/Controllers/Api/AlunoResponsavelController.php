<?php

namespace App\Http\Controllers\Api;

use App\Models\Aluno;
use App\Models\Responsavel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class AlunoResponsavelController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show', 'store', 'update', 'destroy']]);
    }

    /**
     * Associar um responsável a um aluno.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'aluno_id' => 'required|exists:alunos,id',
            'responsavel_id' => 'required|exists:responsaveis,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $aluno = Aluno::find($request->aluno_id);
        $responsavel = Responsavel::find($request->responsavel_id);

        // Verifica se o aluno já está associado ao responsável
        if ($aluno->responsaveis()->where('responsavel_id', $responsavel->id)->exists()) {
            return response()->json(['msg' => 'O responsável já está associado a este aluno.'], 400);
        }

        $aluno->responsaveis()->attach($responsavel);

        return response()->json(['msg' => 'Responsável associado com sucesso ao aluno.'], 200);
    }


}
