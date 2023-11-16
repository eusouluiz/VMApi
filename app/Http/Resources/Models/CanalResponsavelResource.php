<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\BaseResource;
use App\Models\CanalResponsavel;
use Illuminate\Http\Request;

class CanalResponsavelResource extends BaseResource
{
    /**
     * Current resource.
     *
     * @var CanalResponsavel
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
            'canal_responsavel_id' => $this->resource->id,
            'canal'                => new CanalResource($this->whenLoaded('canal')),
            'responsavel'          => new ResponsavelResource($this->whenLoaded('responsavel')),
        ];
    }
}
