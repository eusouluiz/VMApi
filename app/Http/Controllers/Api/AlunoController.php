<?php

namespace App\Http\Controllers;

use App\Http\Resources\Models\AlunoResource;
use App\Models\Responsavel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AlunoController extends AuthenticatedController
{
    /**
     * Get alunos by responsavel.
     *
     * @param Request $request
     *
     * @return ResourceCollection
     */
    public function getUser(Request $request, Responsavel $responsavel): ResourceCollection
    {
        return AlunoResource::collection($responsavel->alunos);
    }
}
