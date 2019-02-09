<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;

class ProfileController extends ApiController {
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    public function show() {
        $profile = request()->user;

        return $this->showOne($profile, __('auth.profile'));
    }
}
