<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\BaseResource;
use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaResource extends BaseResource
{
    /**
     * Current resource.
     *
     * @var Turma
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
            'turma_id'  => $this->resource->id,
            'nome'      => $this->resource->nome,
            'descricao' => $this->resource->descricao,
            'alunos'    => AlunoResource::collection($this->whenLoaded('alunos')),
            'avisos'    => AvisoResource::collection($this->whenLoaded('avisos')),
        ];
    }
}
