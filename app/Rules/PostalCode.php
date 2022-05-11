<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PostalCode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return preg_match('/^[AaBbCcEeGgHhJ-Nj-nPpRrSsTtVvXxYy][0-9][AaBbCcEeGgHhJ-Nj-nPpRrSsTtV-Zv-z][ ][0-9][AaBbCcEeGgHhJ-Nj-nPpRrSsTtV-Zv-z][0-9]$/', $value);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The postal code should be in A1A 1A1 format.';
    }
}
