<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class With implements Rule
{
    /**
     * @var array
     */
    protected $values;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($values)
    {
        $this->values = $values;
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
        if (! $value) {
            return true;
        }

        $values = explode(',', $value);

        foreach ($values as $value) {
            if (! in_array($value, $this->values, true)) {
                return false;
            }
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
        return 'The :attribute must be one of the following types: '.implode(', ', $this->values).'.';
    }
}
