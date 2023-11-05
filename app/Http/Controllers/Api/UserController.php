<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
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
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => $users], 404);
        }

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'nome'     => 'required',
            'cpf'      => 'required|unique:users',
            'telefone' => 'nullable',
            'tipo'     => 'required',
            'email'    => 'unique:users|nullable',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create($data);

        return response()->json(['msg' => 'Registro cadastrado com sucesso', 'data' => $user], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        return response()->json($user, 200);
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
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $data = $request->all();

        $validator = Validator::make($data, [
            'nome'     => 'required',
            'cpf'      => 'required|unique:users,cpf,' . $id,
            'telefone' => 'nullable',
            'tipo'     => 'required',
            'email'    => 'unique:users,email,' . $id . '|nullable',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user->update([
            'nome'     => $data['nome'],
            'cpf'      => $data['cpf'],
            'telefone' => $data['telefone'],
            'tipo'     => $data['tipo'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $user->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
