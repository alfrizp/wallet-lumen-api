<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ApiController;

class AuthController extends ApiController {

    protected function generateToken(User $user) {
        $payload = [
            'iss' => env('JWT_ISS'),
            'sub' => $user->id,
            'iat' => Carbon::now()->timestamp,
            'exp' => Carbon::now()->addDays(15)->timestamp,
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function login(User $user, LoginRequest $request) {
        $response = [];

        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            $response['message'] = __('auth.login.fail');
            return $this->errorResponse($response, 400);
        }

        if (Hash::check($request->input('password'), $user->password)) {
            $response['message'] = __('auth.login.success');
            $response['data'] = [
                'token' => $this->generateToken($user)
            ];

            return $this->successResponse($response, 200);
        }

        $response['message'] = __('auth.login.fail');
        return $this->errorResponse($response, 400);
    }
}
