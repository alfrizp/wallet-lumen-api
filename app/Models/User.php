<?php

namespace App\Models;

use App\Transformers\UserTransformer;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, SoftDeletes;

    public $transformer = UserTransformer::class;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'deleted_at'
    ];

    public function categories() {
        return $this->hasMany(Category::class);
    }
}
