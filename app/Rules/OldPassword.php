<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OldPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return app('hash')->check($value, request()->user()->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Old password invalid';
    }
}
