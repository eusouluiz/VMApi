<?php

namespace App\Http\Controllers\Api;

use App\Models\Aviso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Enums\PrioridadeAviso;


class AvisoController extends Controller
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
        $aviso = Aviso::all();

        if ($aviso->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $aviso], 404);
        }

        return response()->json($aviso, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->data_publicacao !== null) {
            $request->merge(['data_publicacao' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_publicacao)->format('Y-m-d H:i:s')]);
        }
    
        if ($request->data_expiracao !== null) {
            $request->merge(['data_expiracao' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_expiracao)->format('Y-m-d H:i:s')]);
        }
    
        $data = $request->all();
    
        $validator = Validator::make($data, [
            'texto' => 'nullable',
            'arquivo' => 'nullable',
            'data_publicacao' => 'required|date',
            'data_expiracao' => 'nullable|date',
            'prioridade' => ['nullable', Rule::in([PrioridadeAviso::Baixa->value, PrioridadeAviso::Media->value, PrioridadeAviso::Alta->value])],
            'funcionario_id' => 'required|uuid',
            'canal_id' => 'required|uuid',
        ], [
            'prioridade.in' => 'O valor da prioridade é inválido. Valores válidos: 1 (Alta), 2 (Média), 3 (Baixa).',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        $aviso = Aviso::create($data);
    
        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => $aviso], 200);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aviso = Aviso::find($id);

        if (!$aviso) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($aviso, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http Response
     */
    public function update(Request $request, $id)
    {

        if ($request->data_publicacao !== null) {
            $request->merge(['data_publicacao' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_publicacao)->format('Y-m-d H:i:s')]);
        }


        if ($request->data_expiracao !== null) {
            $request->merge(['data_expiracao' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_expiracao)->format('Y-m-d H:i:s')]);
        }


        $aviso = Aviso::find($id);

        if (!$aviso) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'texto' => 'nullable',
            'arquivo' => 'nullable',
            'data_publicacao' => 'required',
            'data_expiracao' => 'nullable',
            'prioridade' => ['nullable', Rule::in([PrioridadeAviso::Alta->value, PrioridadeAviso::Media->value, PrioridadeAviso::Baixa->value])],
            'funcionario_id' => 'required',
            'canal_id' => 'required',
        ], [
            'prioridade.in' => 'O valor da prioridade é inválido. Valores válidos: 1 (Alta), 2 (Média), 3 (Baixa).',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $aviso->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $aviso], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http Response
     */
    public function destroy($id)
    {
        $aviso = Aviso::find($id);

        if (!$aviso) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $aviso->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
