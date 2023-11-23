<?php

namespace App\Http\Controllers\Api;

use App\Enums\TipoUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\Models\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json(['msg' => 'Nenhum registro encontrado', 'data' => UserResource::collection($users)], 404);
        }

        return response()->json(UserResource::collection($users), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();

        $tiposValidos = implode(', ', [TipoUser::Responsavel->value, TipoUser::Funcionario->value, TipoUser::Ambos->value]);

        $validator = Validator::make($data, [
            'nome'     => 'required',
            'cpf'      => 'required|max:11|unique:users',
            'telefone' => 'nullable|max:12',
            'tipo'     => ['required', Rule::in(TipoUser::Responsavel->value, TipoUser::Funcionario->value, TipoUser::Ambos->value)],
            'email'    => 'nullable|email',
            'password' => 'required|min:8',
        ], [
            'tipo.in' => "O tipo selecionado é inválido. Os tipos válidos são: {$tiposValidos}.",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();

        $responsavelId = null;
        $funcionarioId = null;

        if ($user->tipo == TipoUser::Responsavel || $user->tipo == TipoUser::Ambos) {
            $responsavel = $user->responsavel()->create();
            $responsavelId = $responsavel->id;
        }

        if ($user->tipo == TipoUser::Funcionario || $user->tipo == TipoUser::Ambos) {
            $funcionario = $user->funcionario()->create();
            $funcionarioId = $funcionario->id;
        }

        $responseData = [
            'msg' => 'Registro cadastrado com sucesso',
            'data' => [
                'user_id' => $user->id,
                'nome' => $user->nome,
                'cpf' => $user->cpf,
                'telefone' => $user->telefone,
                'tipo' => $user->tipo,
                'email' => $user->email,
                'language' => $user->language,
                'responsavel_id' => $responsavelId,
                'funcionario_id' => $funcionarioId,
            ],
        ];

        return response()->json($responseData, 200);
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
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $user->loadMissing('responsavel', 'funcionario.cargo.funcionalidades');

        return response()->json(new UserResource($user), 200);
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

        $tiposValidos = implode(', ', [TipoUser::Responsavel->value, TipoUser::Funcionario->value, TipoUser::Ambos->value]);

        $validator = Validator::make($data, [
            'nome'     => 'required',
            'cpf'      => 'required|max:11|unique:users,cpf,' . $user->id,
            'telefone' => 'nullable|max:12',
            'tipo'     => ['required', Rule::in([TipoUser::Responsavel->value, TipoUser::Funcionario->value, TipoUser::Ambos->value])],
            'email'    => 'nullable',
            'password' => 'nullable|min:8',
        ], [
            'tipo.in' => "O tipo selecionado é inválido. Os tipos válidos são: {$tiposValidos}.",
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
        ]);

        if (isset($data['password'])) {
            $user->update([
                'password' => Hash::make($data['password']),
            ]);
        }

        return response()->json(['msg' => 'Registro atualizado com sucesso!', 'data' => new UserResource($user)], 200);
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
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Registro não encontrado!'], 404);
        }

        $user->delete();

        return response()->json(['msg' => 'Registro removido com sucesso!'], 200);
    }
}
