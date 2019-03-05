<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Unique implements Rule
{
    protected $user;
    
    protected $table;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user, $table)
    {
        $this->user = $user;

        $this->table = $table;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $table = $this->table;

        if ($this->user->$table()->where($attribute, $value)->first()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
