<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
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
        return preg_match_all('/\d?\d? ?[(]?[1-9]\d{2}[)]? ?[-]? ?\d{3} ?[-]? ?\d{4}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The phone number should be in 123-456-7890 or 1234567890 format. Country code is optional for North American numbers.';
    }

    public function formatPhoneNumber($number)
    {
        preg_match_all('/\d?\d? ?[(]?[1-9]\d{2}[)]? ?[-]? ?\d{3} ?[-]? ?\d{4}$/', $number, $matches);
        $number = "";
        foreach ($matches[0] as $match) {
            $number .= $match;
        }
        $numlength = strlen($number);
        if ($numlength == 10 && $number != 0) {
            $number = 1 . $number;
        }
        return $number;
    }
}
