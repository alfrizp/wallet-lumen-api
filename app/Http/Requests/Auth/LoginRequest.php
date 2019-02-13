<?php

namespace App\Http\Requests\Auth;

// use Illuminate\Http\Request;
use Pearl\RequestValidate\RequestAbstract;

class LoginRequest extends RequestAbstract
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
