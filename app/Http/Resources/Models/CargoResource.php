<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\BaseResource;
use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoResource extends BaseResource
{
    /**
     * Current resource.
     *
     * @var Cargo
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'cargo_id'        => $this->resource->id,
            'nome'            => $this->resource->nome,
            'descricao'       => $this->resource->descricao,
            'funcionalidades' => FuncionalidadeResource::collection($this->whenLoaded('funcionalidades')),
            'canais'          => CanalResource::collection($this->whenLoaded('canais')),
            'funcionarios'    => FuncionarioResource::collection($this->whenLoaded('funcionarios')),
        ];
    }
}
