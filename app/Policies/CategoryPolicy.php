<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewCategory($user, Category $category)
    {
        // return true;
        return $user->id === $category->user_id;
    }

    public function update(User $user, Category $category)
    {
        // Update $user authorization to update $category here.
        return $user->id == $category->user_id;
    }

    public function delete(User $user, Category $category)
    {
        // Update $user authorization to delete $category here.
        return $user->id == $category->user_id && $category->transactions->isEmpty();
    }
}
