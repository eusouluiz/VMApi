<?php

namespace App\Http\Controllers\Api;

use App\Models\Turma;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class TurmaController extends Controller
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
        $turma = Turma::all();

        if ($turma->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $turma], 404);
        }

        return response()->json($turma, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'nome' => 'required',
            'descricao' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $turma = Turma::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => $turma], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $turma = Turma::find($id);

        if (!$turma) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($turma, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http Response
     */
    public function update(Request $request, $id)
    {
        $turma = Turma::find($id);

        if (!$turma) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'nome' => 'required',
            'descricao' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $turma->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $turma], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $turma = Turma::find($id);

        if (!$turma) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $turma->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
