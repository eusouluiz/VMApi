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
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'funcionario_id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'cargo_id' => $this->resource->cargo_id,
            'cargo'          => new CargoResource($this->whenLoaded('cargo')),
            'user'           => new UserResource($this->whenLoaded('user')),
        ];
    }
}
