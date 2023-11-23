<?php

namespace App\Http\Resources\Models;

use App\Http\Resources\BaseResource;
use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoResource extends BaseResource
{
    /**
     * Current resource.
     *
     * @var Aluno
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
            'aluno_id'     => $this->resource->id,
            'cgm'          => $this->resource->cgm,
            'nome'         => $this->resource->nome,
            'turma_id'     => $this->resource->turma_id,
            'turma'        => new TurmaResource($this->whenLoaded('turma')),
            'canais'       => CanalResource::collection($this->whenLoaded('canais')),
            'responsaveis' => ResponsavelResource::collection($this->whenLoaded('responsaveis')),
        ];
    }
}
