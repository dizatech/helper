<?php

namespace Dizatech\Helper\Banking;

use stdClass;

class Pasargad
{
    public static function parseAccountNumber($account_number) : object|bool
    {
        preg_match('/^(\d{3,4})(8000|8100|115|110)(\d+)(\d)$/', $account_number, $matches);
        if (count($matches) != 5) {
            return false;
        }
        
        $parsed= new stdClass();
        $parsed->branch = $matches[1];
        $parsed->type = $matches[2];
        $parsed->customer = $matches[3];
        $parsed->counter = $matches[4];
        $parsed->formatted = sprintf("%d.%d.%d.%d", $matches[1], $matches[2], $matches[3], $matches[4]);

        return $parsed;
    }
}