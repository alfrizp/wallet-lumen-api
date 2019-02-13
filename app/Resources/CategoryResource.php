<?php

namespace App\Resources;

class CategoryResource extends ApiResource
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
        $category = $this->resource;

        return [
            'id' => (int) $category->id,
            'name' => (string) $category->name,
            'description' => (string) $category->description,
            'color' => isset($category->color) ? (string) $category->color : null,
            'created_at' => (int) $category->created_at->timestamp,
            'updated_at' => (int) $category->updated_at->timestamp,
        ];
    }
}
