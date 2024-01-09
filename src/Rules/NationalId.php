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
        //
    }
}
