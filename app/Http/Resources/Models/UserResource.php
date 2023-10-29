<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\BaseResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserResource extends BaseResource
{
    /**
     * Current resource.
     *
     * @var User
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array<string, bool|string>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id'        => $this->resource->id,
            'nome'           => $this->resource->name,
            'cpf'            => $this->resource->cpf,
            'telefone'       => $this->resource->telefone,
            'tipo'           => $this->resource->tipo,
            'email'          => $this->resource->email,
            'language'       => $this->resource->language,
            'email_verified' => $this->resource->email_verified,
            'responsavel'    => new ResponsavelResource($this->whenLoaded('responsavel')),
            'funcionario'    => new FuncionarioResource($this->whenLoaded('funcionario')),
        ];
    }
}
