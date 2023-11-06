<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AvisoResponsavel;
use Validator;
use DB;

class AvisoResponsavelController extends Controller
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
        $avisoResponsavel = DB::table('aviso_responsavel')
            ->join('avisos AS A', 'aviso_responsavel.aviso_id', '=', 'A.id')
            ->join('responsaveis AS R', 'aviso_responsavel.responsavel_id', '=', 'R.id')
            ->select('aviso_responsavel.*', 'A.texto as aviso_texto', 'R.nome as responsavel_nome')
            ->get();

        if ($avisoResponsavel->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $avisoResponsavel], 404);
        }

        return response()->json($avisoResponsavel, 200);
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
            'aviso_id' => 'required|exists:avisos,id',
            'responsavel_id' => 'required|exists:responsaveis,id',
            'ind_visualizacao' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $avisoId = $request->input('aviso_id');
        $responsavelId = $request->input('responsavel_id');

        // Verifica se já existe um registro com a mesma combinação de aviso_id e responsavel_id
        $existeRegistro = AvisoResponsavel::where('aviso_id', $avisoId)
            ->where('responsavel_id', $responsavelId)
            ->first();

        // Caso exista, ele retorna o data com as informações do cadastro
        if ($existeRegistro) {
            return response()->json(['msg' => 'Essa combinação de aviso e responsável já existe.', 'data' => $existeRegistro], 400);
        }

        $indVisualizacao = $request->input('ind_visualizacao', false);

        $data = [
            'aviso_id' => $avisoId,
            'responsavel_id' => $responsavelId,
            'ind_visualizacao' => $indVisualizacao,
        ];

        $avisoResponsavel = AvisoResponsavel::create($data);

        return response()->json(['msg' => 'Associação cadastrada com sucesso', 'data' => $avisoResponsavel], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $avisoResponsavel = DB::table('aviso_responsavel')
            ->join('avisos AS A', 'aviso_responsavel.aviso_id', '=', 'A.id')
            ->join('responsaveis AS R', 'aviso_responsavel.responsavel_id', '=', 'R.id')
            ->select('aviso_responsavel.*', 'A.texto as aviso_texto', 'R.nome as responsavel_nome')
            ->where('aviso_responsavel.id', '=', $id)
            ->first();

        if (!$avisoResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($avisoResponsavel, 200);
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
        $avisoResponsavel = AvisoResponsavel::find($id);

        if (!$avisoResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $validator = Validator::make($request->all(), [
            'aviso_id' => 'required|exists:avisos,id',
            'responsavel_id' => 'required|exists:responsaveis,id',
            'ind_visualizacao' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $request->only(['aviso_id', 'responsavel_id', 'ind_visualizacao']);

        $avisoResponsavel->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $avisoResponsavel], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $avisoResponsavel = AvisoResponsavel::find($id);

        if (!$avisoResponsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $avisoResponsavel->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
