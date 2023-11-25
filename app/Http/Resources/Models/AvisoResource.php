<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\BaseResource;
use App\Models\Aviso;
use Illuminate\Http\Request;

class AvisoResource extends BaseResource
{
    /**
     * Current resource.
     *
     * @var Aviso
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
            'aviso_id'        => $this->resource->id,
            'titulo'          => $this->resource->titulo,
            'texto'           => $this->resource->texto,
            'arquivo'         => $this->resource->arquivo,
            'data_publicacao' => $this->resource->data_publicacao,
            'data_expiracao'  => $this->resource->data_expiracao,
            'prioridade'      => $this->resource->prioridade,
            'canal_id'      => $this->resource->canal_id,
            'funcionario'     => new FuncionarioResource($this->whenLoaded('funcionario')),
            'canal'           => new CanalResource($this->whenLoaded('canal')),
        ];
    }
}
