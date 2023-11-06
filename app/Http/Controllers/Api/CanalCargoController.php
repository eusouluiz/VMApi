<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CanalCargo;
use Validator;
use DB;

class CanalCargoController extends Controller
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
        $canalCargo = DB::table('canal_cargo')
            ->join('canais AS C', 'canal_cargo.canal_id', '=', 'C.id')
            ->join('cargos AS CR', 'canal_cargo.cargo_id', '=', 'CR.id')
            ->select('canal_cargo.*', 'C.nome as canal_nome', 'CR.nome as cargo_nome')
            ->get();

        if ($canalCargo->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $canalCargo], 404);
        }

        return response()->json($canalCargo, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'canal_id' => 'required|exists:canais,id',
            'cargo_id' => 'required|exists:cargos,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $canalId = $request->input('canal_id');
        $cargoId = $request->input('cargo_id');

        $existeRegistro = CanalCargo::where('canal_id', $canalId)
            ->where('cargo_id', $cargoId)
            ->first();

        if ($existeRegistro) {
            return response()->json(['msg' => 'Essa combinação de canal e cargo já existe.', 'data' => $existeRegistro], 400);
        }

        $data = [
            'canal_id' => $canalId,
            'cargo_id' => $cargoId,
        ];

        $canalCargo = CanalCargo::create($data);

        return response()->json(['msg' => 'Associação cadastrada com sucesso', 'data' => $canalCargo], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $canalCargo = DB::table('canal_cargo')
            ->join('canais AS C', 'canal_cargo.canal_id', '=', 'C.id')
            ->join('cargos AS CR', 'canal_cargo.cargo_id', '=', 'CR.id')
            ->select('canal_cargo.*', 'C.nome as canal_nome', 'CR.nome as cargo_nome')
            ->where('canal_cargo.id', '=', $id)
            ->first();

        if (!$canalCargo) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($canalCargo, 200);
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
        $canalCargo = CanalCargo::find($id);

        if (!$canalCargo) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $validator = Validator::make($request->all(), [
            'canal_id' => 'required|exists:canais,id',
            'cargo_id' => 'required|exists:cargos,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $canalCargo->update($request->only(['canal_id', 'cargo_id']));

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $canalCargo], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $canalCargo = CanalCargo::find($id);

        if (!$canalCargo) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $canalCargo->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
