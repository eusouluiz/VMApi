<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\BaseResource;
use App\Models\Funcionalidade;
use Illuminate\Http\Request;

class FuncionalidadeResource extends BaseResource
{
    /**
     * Current resource.
     *
     * @var Funcionalidade
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
            'funcionalidade_id' => $this->resource->id,
            'nome'              => $this->resource->nome,
            'descricao'         => $this->resource->descricao,
            'cargos'            => CargoResource::collection($this->whenLoaded('cargos')),
        ];
    }
}
