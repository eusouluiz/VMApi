<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CargoFuncionalidade;
use Validator;
use DB;

class CargoFuncionalidadeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cargoFuncionalidade = DB::table('cargo_funcionalidade')
            ->join('cargos AS C', 'cargo_funcionalidade.cargo_id', '=', 'C.id')
            ->join('funcionalidades AS F', 'cargo_funcionalidade.funcionalidade_id', '=', 'F.id')
            ->select('cargo_funcionalidade.*', 'C.nome as cargo_nome', 'F.nome as funcionalidade_nome')
            ->get();

        if ($cargoFuncionalidade->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $cargoFuncionalidade], 404);
        }

        return response()->json($cargoFuncionalidade, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cargo_id' => 'required|exists:cargos,id',
            'funcionalidade_id' => 'required|exists:funcionalidades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $cargoId = $request->input('cargo_id');
        $funcionalidadeId = $request->input('funcionalidade_id');

        $existeRegistro = CargoFuncionalidade::where('cargo_id', $cargoId)
            ->where('funcionalidade_id', $funcionalidadeId)
            ->first();

        if ($existeRegistro) {
            return response()->json(['msg' => 'Essa combinação de cargo e funcionalidade já existe.', 'data' => $existeRegistro], 400);
        }

        $data = [
            'cargo_id' => $cargoId,
            'funcionalidade_id' => $funcionalidadeId,
        ];

        $cargoFuncionalidade = CargoFuncionalidade::create($data);

        return response()->json(['msg' => 'Associação cadastrada com sucesso', 'data' => $cargoFuncionalidade], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $cargoFuncionalidade = DB::table('cargo_funcionalidade')
            ->join('cargos AS C', 'cargo_funcionalidade.cargo_id', '=', 'C.id')
            ->join('funcionalidades AS F', 'cargo_funcionalidade.funcionalidade_id', '=', 'F.id')
            ->select('cargo_funcionalidade.*', 'C.nome as cargo_nome', 'F.nome as funcionalidade_nome')
            ->where('cargo_funcionalidade.id', '=', $id)
            ->first();

        if (!$cargoFuncionalidade) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($cargoFuncionalidade, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $cargoFuncionalidade = CargoFuncionalidade::find($id);

        if (!$cargoFuncionalidade) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $validator = Validator::make($request->all(), [
            'cargo_id' => 'required|exists:cargos,id',
            'funcionalidade_id' => 'required|exists:funcionalidades,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $cargoFuncionalidade->update($request->only(['cargo_id', 'funcionalidade_id']));

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $cargoFuncionalidade], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $cargoFuncionalidade = CargoFuncionalidade::find($id);

        if (!$cargoFuncionalidade) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $cargoFuncionalidade->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
