<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CanalResponsavel;
use Validator;
use DB;

class CanalResponsavelController extends Controller
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
        $canalResponsavel = DB::table('canal_responsavel')
            ->join('canais AS C', 'canal_responsavel.canal_id', '=', 'C.id')
            ->join('responsaveis AS R', 'canal_responsavel.responsavel_id', '=', 'R.id')
            ->select('canal_responsavel.*', 'C.nome as canal_nome', 'R.nome as responsavel_nome')
            ->get();

        if ($canalResponsavel->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $canalResponsavel], 404);
        }

        return response()->json($canalResponsavel, 200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'canal_id' => 'required|exists:canais,id',
            'responsavel_id' => 'required|exists:responsaveis,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $canalId = $request->input('canal_id');
        $responsavelId = $request->input('responsavel_id');

        // Verifica se já existe um registro com a mesma combinação de canal_id e responsavel_id
        $existeRegistro = CanalResponsavel::where('canal_id', $canalId)->where('responsavel_id', $responsavelId)->first();

        // Caso exista, ele retorna o data com as informações do cadastro
        if ($existeRegistro) {
            return response()->json(['msg' => 'Essa combinação de canal e responsável já existe.', 'data' => $existeRegistro], 400);
        }

        $data = [
            'canal_id' => $canalId,
            'responsavel_id' => $responsavelId,
        ];

        $canalResponsavel = CanalResponsavel::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => $canalResponsavel], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
       
        $canalResponsavel = DB::table('canal_responsavel')
        ->join('canais AS C', 'canal_responsavel.canal_id', '=', 'C.id')
        ->join('responsaveis AS R', 'canal_responsavel.responsavel_id', '=', 'R.id')
        ->select('canal_responsavel.*', 'C.nome as canal_nome', 'R.nome as responsavel_nome')
        ->where('canal_responsavel.id', '=', $id)
        ->first();

        if (!$canalResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($canalResponsavel, 200);
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
        $canalResponsavel = CanalResponsavel::find($id);

        if (!$canalResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'canal_id' => 'required|exists:canais,id',
            'responsavel_id' => 'required|exists:responsaveis,id'
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $canalResponsavel = CanalResponsavel::find($id);

        if (!$canalResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $canalResponsavel->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
