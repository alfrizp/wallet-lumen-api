<?php

namespace App\Transformers;

use Carbon\Carbon;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'user_id' => (int)$user->id,
            'name' => (string)$user->name,
            'email' => (string)$user->email,
            'created_at' => (int)(new Carbon($user->created_at))->timestamp,
            'updated_at' => (int)(new Carbon($user->updated_at))->timestamp,
        ];
    }
}
