<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Models\MensagemResource;
use App\Models\Mensagem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MensagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $mensagem = Mensagem::all();

        return response()->json(MensagemResource::collection($mensagem), 200);
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
        if ($request->data_leitura !== null) {
            $request->merge(['data_leitura' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_leitura)->format('Y-m-d H:i:s')]);
        }

        if ($request->data_envio !== null) {
            $request->merge(['data_envio' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_envio)->format('Y-m-d H:i:s')]);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'texto'                => 'nullable',
            'arquivo'              => 'nullable',
            'lida'                 => 'boolean',
            'data_leitura'         => 'nullable',
            'data_envio'           => 'required',
            'user_id'              => 'required',
            'canal_responsavel_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $mensagem = Mensagem::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => new MensagemResource($mensagem)], 200);
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
        $mensagem = Mensagem::find($id);

        if (!$mensagem) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json(new MensagemResource($mensagem), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if ($request->data_leitura !== null) {
            $request->merge(['data_leitura' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_leitura)->format('Y-m-d H:i:s')]);
        }

        if ($request->data_envio !== null) {
            $request->merge(['data_envio' => Carbon::createFromFormat('d/m/Y H:i:s', $request->data_envio)->format('Y-m-d H:i:s')]);
        }

        $mensagem = Mensagem::find($id);

        if (!$mensagem) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'texto'                => 'nullable',
            'arquivo'              => 'nullable',
            'lida'                 => 'boolean',
            'data_leitura'         => 'nullable',
            'data_envio'           => 'required',
            'user_id'              => 'required',
            'canal_responsavel_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $mensagem->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => new MensagemResource($mensagem)], 200);
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
        $mensagem = Mensagem::find($id);

        if (!$mensagem) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $mensagem->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
