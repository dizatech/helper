<?php

namespace Dizatech\Helper\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Iban implements ValidationRule
{
    protected $has_country_code;

    public function __construct($has_country_code=false)
    {
        $this->has_country_code = $has_country_code;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $length = $this->has_country_code ? 26 : 24;
        if (strlen($value) != $length) {
            $fail("IBAN must be {$length} caharcters long.");
            return;
        }
        $country_code = $this->has_country_code ? substr($value, 0, 2) : '';
        if ($this->has_country_code && $country_code != 'IR') {
            $fail("IBAN should start with IR.");
            return;
        }
        $iban = "IR" . preg_replace('/[^0-9]/', '', $value);
        $iban = substr($iban, 4) . substr($iban, 0, 4);
        $iban_numeric = '';
        foreach (str_split($iban) as $char) {
            $iban_numeric .= is_numeric($char) ? $char : ord($char) - 55;
        }

        if (bcmod($iban_numeric, '97') !== '1') {
            $fail("IBAN is not valid.");
        }
    }
}
