<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class Unique implements Rule
{
    /**
     * @var \App\User
     */
    protected $user;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var int|null
     */
    protected $ignore;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(User $user, $table, $ignore = null)
    {
        $this->user = $user;

        $this->table = $table;
        
        $this->ignore = $ignore;
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
        return ! in_array($value, $this->user->{$this->table}->whereNotIn('id', $this->ignore)->pluck($attribute)->all());
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
