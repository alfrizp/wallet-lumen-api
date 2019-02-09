<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Http\Controllers\ApiController;
use App\Rules\OldPassword;
use App\Http\Requests\Auth\ChangePasswordRequest;

class ChangePasswordController extends ApiController {
    public function __construct() {
        $this->middleware('jwt.auth');
    }

    public function update(ChangePasswordRequest $changePasswordRequest) {
        $user = request()->user();
        $user->password = bcrypt(request()->password);
        $user->save();

        return $this->showMessage(__('auth.password_changed'));
    }
}
