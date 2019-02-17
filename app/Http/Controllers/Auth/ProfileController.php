<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Resources\UserResource;

class ProfileController extends ApiController
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function show()
    {
        $profile = request()->user;

        return new UserResource($profile, __('auth.profile'));
    }
}
