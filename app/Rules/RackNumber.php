<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RackNumber implements Rule
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
        $result = preg_match('/[A-Ma-m][AaBbCcGg][0-9]/', $value);
        if ($result == 1) {

            $aisle = strtoupper(substr($value, 0, 1));
            $value = substr($value, 2);
            $array = [];

            $end = 575;
            if ($aisle == "G" || $aisle == "H") {
                $end = 425;
            } else if ($aisle == "I" || $aisle == "J") {
                $end = 675;
            } else if ($aisle == "K") {
                $end = 725;
            }

            for ($i = 100; $i <= $end; $i += 25) $array[] = $i;
            return in_array($value, $array);
        }
        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be rack number format.';
    }
}
