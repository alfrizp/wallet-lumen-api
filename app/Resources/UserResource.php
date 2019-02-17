<?php

namespace App\Resources;

class UserResource extends ApiResource
{
    protected $message;
    protected $code;

    public function __construct($resource, $message = '', $code = 200)
    {
        parent::__construct($resource);

        $this->message = $message;
        $this->code = $code;
    }

    public function toArray($request)
    {
        $user = $this->resource;

        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'created_at' => (int) $user->created_at->timestamp,
            'updated_at' => (int) $user->updated_at->timestamp,
            'categories' => CategoryResource::collection($user->categories),
        ];
    }
}
