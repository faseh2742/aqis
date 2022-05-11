<?php

namespace App\Rules;

use App\Aptemplate;
use Illuminate\Contracts\Validation\Rule;

class UniqueNoc implements Rule
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
        $noc = serialize($value);

        $aptemplate = Aptemplate::where("noc", $noc)->first();

        if ($aptemplate) {
            return false;
        } else {
            return true;
        }


    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The template for this noc already exists.';
    }
}
