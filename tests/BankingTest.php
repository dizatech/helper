<?php

use Dizatech\Helper\Banking\Pasargad;
use PHPUnit\Framework\TestCase;

class BankingTest extends TestCase
{
    public function testBankingPasargadParseAccountNumber()
    {
        $account_numbers = [
            '2868000135222951'  => ['286', '8000', '13522295', '1'],
            '286115145443761'   => ['286', '115', '14544376', '1'],
            '286110128065441'   => ['286', '110', '12806544', '1'],
            '3398100124775521'  => ['339', '8100', '12477552', '1'],
            '39068000131234251' => ['3906', '8000', '13123425', '1'],
            '390680001'         => false,
            '777888131234251'   => false,
            '123456'            => false,
        ];
        
        foreach ($account_numbers as $account_number => $parts) {
            $parsed = Pasargad::parseAccountNumber($account_number);
            if ($parts === false) {
                $this->assertFalse($parsed);
            } else {
                $this->assertEquals($parts[0], $parsed->branch);
                $this->assertEquals($parts[1], $parsed->type);
                $this->assertEquals($parts[2], $parsed->customer);
                $this->assertEquals($parts[3], $parsed->counter);
                $this->assertEquals(implode(".", $parts), $parsed->formatted);
            }
        }
    }
}