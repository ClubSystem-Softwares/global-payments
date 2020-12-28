<?php

namespace CSWeb\Tests\Validation;

use CSWeb\GlobalPayments\Validation\ValidatesTransaction;
use CSWeb\GlobalPayments\ValidationException;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatesTransactionTest
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\Tests\Validation
 */
class ValidatesTransactionTest extends TestCase
{
    public function testTransactionValidation()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo valor é obrigatório');

        $data = [
            'order'      => 123456,
            'cardHolder' => 'Matheus Lopes Santos',
            'cardNumber' => '4111 1111 1111 1111',
            'cvv'        => '123',
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }
}