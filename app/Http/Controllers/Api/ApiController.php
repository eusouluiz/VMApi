<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\UnauthenticatedController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ApiController extends UnauthenticatedController
{
    /**
     * Get the swagger UI.
     *
     * @param Request $request
     *
     * @return View
     */
    public function getApi(Request $request): View
    {
        return view('api.swagger.ui');
    }

    /**
     * Get the API documentation.
     *
     * @param Request $request
     *
     * @return string
     */
    public function getApiDocumentation(Request $request): string
    {
        return File::get(resource_path() . '/api/documentation.yaml');
    }
}
