<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;

class AuthenticatedController extends Controller
{
    use DispatchesJobs;

    /**
     * Current authenticated User.
     *
     * @var User
     */
    protected User $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // For this controller, we require an authenticated user of type User
            if (!$request->user() instanceof User) {
                throw new TranslatableException(
                    500,
                    'Invalid authenticated user type.',
                    'api.ERROR.SOMETHING_WENT_WRONG',
                );
            }

            $this->user = $request->user();

            return $next($request);
        });
    }
}
