<?php

namespace App\Http\Controllers;

use App\Http\Resources\Models\UserResource;
use Illuminate\Http\Request;

class UserController extends AuthenticatedController
{
    /**
     * Get authenticated user details.
     *
     * @param Request $request
     *
     * @return UserResource
     */
    public function getUser(Request $request): UserResource
    {
        return new UserResource($this->user->load('responsavel', 'funcionario'));
    }
}
