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

    public function testGettersAndSetters()
    {
        $data = [
            'amount'           => 10.00,
            'order'            => 'ABC123456123',
            'cardHolder'       => 'Matheus Lopes Santos',
            'cardNumber'       => '4111 1111 1111 1111',
            'cvv'              => 123,
            'expiryDate'       => new DateTime(),
            'merchantCode'     => 1234567,
            'merchantTerminal' => 12301233,
        ];

        $transacao = new Transacao($data);

        $this->assertEquals(1000, $transacao->getAmount());
        $this->assertEquals($data['order'], $transacao->getOrder());
        $this->assertEquals($data['cardHolder'], $transacao->getCardHolder());
        $this->assertEquals(4111111111111111, $transacao->getCardNumber());
        $this->assertEquals($data['cvv'], $transacao->getCvv());
        $this->assertInstanceOf(DateTime::class, $transacao->getExpiryDate());
        $this->assertEquals($data['merchantCode'], $transacao->getMerchantCode());
        $this->assertEquals($data['merchantTerminal'], $transacao->getMerchantTerminal());
        $this->assertEquals(Transacao::TRANSACTION_TYPE, $transacao->getTransactionType());
        $this->assertEquals(Transacao::ACCOUNT_TYPE_CREDITO, $transacao->getAccountType());
        $this->assertEquals(Transacao::PLAN_TYPE_VISTA, $transacao->getPlanType());
    }


    public function testXmlResponse()
    {
        $data = [
            'amount'           => 10.00,
            'order'            => 'ABC123456123',
            'cardHolder'       => 'Matheus Lopes Santos',
            'cardNumber'       => '4111 1111 1111 1111',
            'cvv'              => 123,
            'expiryDate'       => new DateTime(),
            'merchantCode'     => 1234567,
            'merchantTerminal' => 12301233,
            'merchantKey'      => 'qwertyasdf0123456789',
        ];

        $transacao = new Transacao($data);

        echo $transacao->toXml();
        /*var_dump();*/
        die();
    }
}