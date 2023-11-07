<?php

namespace App\Http\Controllers\Api;

use App\Models\Responsavel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ResponsavelController extends Controller
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
        $responsavel = Responsavel::all();

        if ($responsavel->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $responsavel], 404);
        }

        return response()->json($responsavel, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $responsavel = Responsavel::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => $responsavel], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $responsavel = Responsavel::find($id);

        if (!$responsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($responsavel, 200);
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
        $responsavel = Responsavel::find($id);

        if (!$responsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $responsavel->update($data);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $responsavel], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http Response
     */
    public function destroy($id)
    {
        $responsavel = Responsavel::find($id);

        if (!$responsavel) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $responsavel->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
