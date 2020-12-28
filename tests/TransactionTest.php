<?php

namespace CSWeb\Tests;

use CSWeb\GlobalPayments\Transacao;
use CSWeb\GlobalPayments\ValidationException;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * Class TransactionTest
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\Tests
 */
class TransactionTest extends TestCase
{
    public function testBasicValidation()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo parcelas não pode conter um valor superior a 12');

        $data = [
            'amount'       => 10.00,
            'order'        => 'ABC123456123',
            'cardHolder'   => 'Matheus Lopes Santos',
            'cardNumber'   => '4111 1111 1111 1111',
            'cvv'          => 123,
            'expiryDate'   => new DateTime(),
            'installments' => 15,
        ];

        $transacao = new Transacao($data);
    }


}