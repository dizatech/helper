<?php

namespace Dizatech\Helper\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NationalCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $valid = true;

        if (!preg_match('/^[0-9]{10}$/', $value)) { //accept only 10 digit strings
            $valid = false;
        }

        //reject strings with 10 same digits
        if ($valid) {
            for ($d=0; $d<=9; $d++) {
                if (preg_match("/[{$d}]{10}/", $value)) {
                    $valid = false;
                    break;
                }
            }
        }

        if ($valid) {
            $control_digit = substr($value, 9, 1);
            $multiplier = 2;
            $sum = 0;
            for ($i=8; $i>=0; $i--) {
                $sum += substr($value, $i, 1) * $multiplier++;
            }
            $remainder = $sum % 11;
            if (
                ($remainder < 2 && $control_digit != $remainder) ||
                ($remainder >= 2 && $control_digit != (11 - $remainder))
            ) {
                $valid = false;
            }
        }

        if (!$valid) {
            $fail("SOME THING");
        }
    }
}
