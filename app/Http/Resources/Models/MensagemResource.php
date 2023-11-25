<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\BaseResource;
use App\Models\Mensagem;
use Illuminate\Http\Request;

class MensagemResource extends BaseResource
{
    /**
     * Current resource.
     *
     * @var Mensagem
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
            'mensagem_id'       => $this->resource->id,
            'texto'             => $this->resource->texto,
            'arquivo'           => $this->resource->arquivo,
            'lida'              => $this->resource->lida,
            'data_leitura'      => $this->resource->data_leitura,
            'data_envio'        => $this->resource->data_envio,
            'canal_responsavel_id' => $this->resource->canal_responsavel_id,
            'user'              => new UserResource($this->whenLoaded('user')),
            'canal_responsavel' => new CanalResponsavelResource($this->whenLoaded('canal_responsavel')),
        ];
    }
}
