<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description', 'color',
        'user_id',
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
