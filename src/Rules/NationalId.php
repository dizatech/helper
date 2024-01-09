<?php

namespace Dizatech\Helper\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NationalId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $valid = true;

        if (!preg_match('/^[0-9]{11}$/', $value)) { //accept only 11 digit strings
            $valid = false;
        }

        if ($valid) {
            $digits = str_split($value);
            $control_digit = array_pop($digits);
            $constant = $digits[9] + 2;
            $multipliers = [29, 27, 23, 19, 17, 29, 27, 23, 19, 17];
            $i = 0;
            $sum = 0;
            for ($i=0; $i<10; $i++) {
                $sum += ($digits[$i] + $constant) * $multipliers[$i];
            }
            $remainder = $sum % 11;
            if ($remainder == 10){
                $remainder = 0;
            }
            if ($remainder != $control_digit) {
                $valid = false;
            }
        }

        if (!$valid) {
            $fail("SOME THING");
        }
    }
}
