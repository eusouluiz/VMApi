<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\BaseResource;
use App\Models\Canal;
use Illuminate\Http\Request;

class CanalResource extends BaseResource
{
    /**
     * Current resource.
     *
     * @var Canal
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
            'canal_id'  => $this->resource->id,
            'nome'      => $this->resource->nome,
            'descricao' => $this->resource->descricao,
            'cargos'    => CargoResource::collection($this->whenLoaded('cargos')),
            'aluno'     => AlunoResource::collection($this->whenLoaded('aluno')),
            'avisos'    => AvisoResource::collection($this->whenLoaded('avisos')),
            'mensagens' => MensagemResource::collection($this->whenLoaded('mensagens')),
        ];
    }
}
