<?php

namespace App\Http\Controllers\Api;

use App\Enums\PrioridadeAviso;
use App\Http\Controllers\Controller;
use App\Http\Resources\Models\AvisoResource;
use App\Models\Aviso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AvisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $avisos = Aviso::with('funcionario', 'turmas', 'lembrete')->get();

        if ($avisos->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => []], 404);
        }

        return response()->json(['data' => AvisoResource::collection($avisos)], 200);
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
        if ($request->data_publicacao !== null) {
            $request->merge(['data_publicacao' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_publicacao)->format('Y-m-d H:i:s')]);
        }

        if ($request->data_expiracao !== null) {
            $request->merge(['data_expiracao' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_expiracao)->format('Y-m-d H:i:s')]);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'titulo'                 => 'required|string|max:255',
            'texto'                  => 'nullable',
            'arquivo'                => 'nullable',
            'data_publicacao'        => 'required|date',
            'data_expiracao'         => 'nullable|date',
            'prioridade'             => ['nullable', Rule::in([PrioridadeAviso::Baixa->value, PrioridadeAviso::Media->value, PrioridadeAviso::Alta->value])],
            'funcionario_id'         => 'required|uuid',
            'canal_id'               => 'required|uuid',
            'lembrete.data_lembrete' => 'nullable',
        ], [
            'prioridade.in' => 'O valor da prioridade é inválido. Valores válidos: 1 (Alta), 2 (Média), 3 (Baixa).',
        ]);

        // validate that if 'lembrete.data.data_lembrete' is set, then 'lembrete.data.data_lembrete' must be a valid date
        $validator->sometimes('lembrete.data_lembrete', 'date', function ($input) {
            return isset($input->lembrete['data_lembrete']);
        });

        if ($validator->fails()) {
            return response()->json([$validator->errors(), $data], 400);
        }

        if (isset($data['lembrete']['data_lembrete'])) {
            $lembrete = $data['lembrete'];
            unset($data['lembrete']);

            $aviso = Aviso::create($data);
            $aviso->lembrete()->create($lembrete);
        } else {
            unset($data['lembrete']);

            $aviso = Aviso::create($data);
        }

        $aviso->load('lembrete');

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => new AvisoResource($aviso)], 200);
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
        $aviso = Aviso::find($id);

        $aviso->load('funcionario', 'turmas', 'lembrete');

        if (!$aviso) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json(new AvisoResource($aviso), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $requesttitulo
     * @param int                      $id
     *
     * @return \Illuminate\Http\JsonResponse
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
            'titulo'                 => 'required|string|max:255',
            'texto'                  => 'nullable',
            'arquivo'                => 'nullable',
            'data_publicacao'        => 'required',
            'data_expiracao'         => 'nullable',
            'prioridade'             => ['nullable', Rule::in([PrioridadeAviso::Alta->value, PrioridadeAviso::Media->value, PrioridadeAviso::Baixa->value])],
            'funcionario_id'         => 'required',
            'canal_id'               => 'required',
            'lembrete.data_lembrete' => 'nullable',
        ], [
            'prioridade.in' => 'O valor da prioridade é inválido. Valores válidos: 1 (Alta), 2 (Média), 3 (Baixa).',
        ]);

        // validate that if 'lembrete.data.data_lembrete' is set, then 'lembrete.data.data_lembrete' must be a valid date
        $validator->sometimes('lembrete.data_lembrete', 'date', function ($input) {
            return isset($input->lembrete['data_lembrete']);
        });

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (isset($data['lembrete']['data_lembrete'])) {
            $lembrete = $data['lembrete'];
            unset($data['lembrete']);

            $aviso->update($data);
            $aviso->lembrete()->updateOrCreate($lembrete);
        } else {
            unset($data['lembrete']);

            $aviso->update($data);
        }

        $aviso->load('lembrete');

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => new AvisoResource($aviso)], 200);
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
        $aviso = Aviso::find($id);

        if (!$aviso) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $aviso->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
