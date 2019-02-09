<?php

namespace App\Http\Requests\Auth;

use Pearl\RequestValidate\RequestAbstract;
use App\Rules\OldPassword;

class ChangePasswordRequest extends RequestAbstract {
    public function rules() {
        return [
            'old_password'          => ['required', new OldPassword],
            'password'              => 'required|between:6,15|confirmed',
            'password_confirmation' => 'required',
        ];
    }
}
