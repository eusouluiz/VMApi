<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Models\LembreteResource;
use App\Models\Lembrete;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class LembreteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $lembretes = Lembrete::all();

        if ($lembretes->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => LembreteResource::collection($lembretes)], 404);
        }

        return response()->json(LembreteResource::collection($lembretes), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->data_lembrete !== null) {
            $request->merge(['data_lembrete' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_lembrete)->format('Y-m-d H:i:s')]);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'titulo'        => 'required',
            'texto'         => 'nullable',
            'data_lembrete' => 'required',
            'aviso_id'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $lembrete = Lembrete::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => new LembreteResource($lembrete)], 200);
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
        $lembrete = Lembrete::find($id);

        if (!$lembrete) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json(new LembreteResource($lembrete), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http Request  $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->data_lembrete !== null) {
            $request->merge(['data_lembrete' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_lembrete)->format('Y-m-d H:i:s')]);
        }

        $lembrete = Lembrete::find($id);

        if (!$lembrete) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'titulo'        => 'required',
            'texto'         => 'nullable',
            'data_lembrete' => 'required',
            'aviso_id'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $lembrete->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => new LembreteResource($lembrete)], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $lembrete = Lembrete::find($id);

        if (!$lembrete) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $lembrete->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
