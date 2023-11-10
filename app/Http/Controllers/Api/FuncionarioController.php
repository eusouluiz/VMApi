<?php

namespace App\Http\Controllers\Api;

use App\Models\Funcionario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;

class FuncionarioController extends Controller
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
        $funcionarios = DB::table('funcionarios AS F')
            ->join('users AS U', 'F.user_id', '=', 'U.id')
            ->select('F.*', 'U.nome as user_nome')
            ->get();

        if ($funcionarios->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $funcionarios], 404);
        }

        return response()->json($funcionarios, 200);
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
            'user_id' => 'required',
            'cargo_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $funcionario = Funcionario::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => $funcionario], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $funcionario = DB::table('funcionarios AS F')
            ->join('users AS U', 'F.user_id', '=', 'U.id')
            ->select('F.*', 'U.nome as user_nome')
            ->where('F.id', '=', $id)
            ->first();

        if (!$funcionario) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($funcionario, 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'cargo_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $funcionario->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $funcionario], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $funcionario = Funcionario::find($id);

        if (!$funcionario) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $funcionario->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
