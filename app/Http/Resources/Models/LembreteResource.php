<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\BaseResource;
use App\Models\Lembrete;
use Illuminate\Http\Request;

class LembreteResource extends BaseResource
{
    /**
     * Current resource.
     *
     * @var Lembrete
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
            'lembrete_id'   => $this->resource->id,
            'titulo'        => $this->resource->titulo,
            'texto'         => $this->resource->texto,
            'data_lembrete' => $this->resource->data_lembrete,
            'aviso'         => new AvisoResource($this->whenLoaded('aviso')),
        ];
    }
}
