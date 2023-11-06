<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Validator;

class AlunoController extends Controller
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
        $aluno = Aluno::all();

        if ($aluno->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $aluno], 404);
        }

        return response()->json($aluno, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'nome' => 'required',
            'cgm'  => 'required|unique:alunos',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $aluno = Aluno::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => $aluno], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Aluno $aluno
     * @param mixed             $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aluno = Aluno::find($id);

        if (!$aluno) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($aluno, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Aluno        $aluno
     * @param mixed                    $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $aluno = Aluno::find($id);

        if (!$aluno) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'nome' => 'required',
            'cgm'  => 'required|unique:alunos,cgm,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $aluno->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $aluno], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Aluno $aluno
     * @param mixed             $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aluno = Aluno::find($id);

        if (!$aluno) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $aluno->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
