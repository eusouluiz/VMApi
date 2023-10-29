<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\BaseResource;
use App\Models\Responsavel;
use Illuminate\Http\Request;

class FuncionarioResource extends BaseResource
{
    /**
     * Current resource.
     *
     * @var Responsavel
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
            'funcionario_id' => $this->resource->id,
            'nome'           => $this->resource->nome,
            'user'           => new UserResource($this->whenLoaded('user')),
        ];
    }
}
