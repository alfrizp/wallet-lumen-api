<?php

namespace App\Transformers;

use Carbon\Carbon;
use App\Models\Category;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    public function transform(Category $category)
    {
        return [
            'category_id' => (int)$category->id,
            'name' => (string)$category->name,
            'description' => (string)$category->description,
            'color' => isset($category->color) ? (string)$category->color : null,
            'created_at' => (int)(new Carbon($category->created_at))->timestamp,
            'updated_at' => (int)(new Carbon($category->updated_at))->timestamp,
            // 'creator' => isset($category->creator) ? $category->creator : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'category_id' => 'id',
            'name' => 'name',
            'description' => 'description',
            'color' => 'color',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'category_id' => 'id',
            'name' => 'name',
            'description' => 'description',
            'color' => 'color',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
