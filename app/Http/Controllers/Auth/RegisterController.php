<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends ApiController
{
    public function register(RegisterRequest $registerRequest)
    {
        $registerRequest['password'] = bcrypt($registerRequest['password']);
        User::create($registerRequest->all());

        return $this->showMessage(__('auth.register.success'));
    }
}
