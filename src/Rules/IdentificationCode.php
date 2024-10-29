<?php

namespace Dizatech\Helper\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IdentificationCode implements ValidationRule
{
    const InvalidCodes = [
        '0000000000',
        '1111111111',
        '2222222222',
        '3333333333',
        '4444444444',
        '5555555555',
        '6666666666',
        '7777777777',
        '8888888888',
        '9999999999'
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->checkRealPerson($value) && !$this->checkLegalPerson($value)) {
            $fail('کد/شناسه ملی ارسالی معتبر نیست.');
        }
    }

    protected function checkRealPerson($value)
    {
        if (is_numeric($value) && preg_match('/^[0-9]{10}$/', $value) && !in_array($value, self::InvalidCodes)) {
            $sum = 0;
            $check_number = substr($value, 9, 1);
            $multiplier = 2;
            for ($i = 8; $i >= 0; $i--) {
                $sum += substr($value, $i, 1) * $multiplier++;
            }
            $remaining = $sum % 11;
            if ($remaining >= 2) {
                $remaining = 11 - $remaining;
            }
            if ($check_number != $remaining) {
                return false;
            }
        } else {
            return false;
        }

        return true;
    }

    protected function checkLegalPerson($value)
    {
        if (is_numeric($value) && preg_match('/^[0-9]{11}$/', $value)) {
            $array_numbers = str_split($value);
            $control_number = array_pop($array_numbers);
            $const_plus = $array_numbers[9] + 2;
            $const_cross = [29, 27, 23, 19, 17, 29, 27, 23, 19, 17];
            $i = 0;
            $sum = 0;
            foreach ($const_cross as $const_cross_item) {
                $sum = (($array_numbers[$i] + $const_plus) * $const_cross_item) + $sum;
                $i++;
            }
            $remaining = $sum % 11;
            if ($remaining == 10){
                $remaining = 0;
            }
            if ($remaining != $control_number) {
                return false;
            }
        } else {
            return false;
        }

        return true;
    }
}
