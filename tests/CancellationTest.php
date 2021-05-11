<?php

namespace CSWeb\Tests;

use CSWeb\GlobalPayments\AbstractTransaction;
use CSWeb\GlobalPayments\Cancellation;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CancellationTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $data = [
            'amount'           => 10.00,
            'order'            => 'ABC123456123',
            'merchantCode'     => rand(100000000000000, 999999999999999),
            'merchantTerminal' => '001',
            'merchantKey'      => 'qwertyasdf0123456789',
        ];

        $cancellation = new Cancellation($data);

        $this->assertEquals(1000, $cancellation->getAmount());
        $this->assertEquals($data['order'], $cancellation->getOrder());
        $this->assertEquals($data['merchantCode'], $cancellation->getMerchantCode());
        $this->assertEquals($data['merchantTerminal'], $cancellation->getMerchantTerminal());
        $this->assertEquals($data['merchantKey'], $cancellation->getMerchantKey());

        $this->assertInstanceOf(AbstractTransaction::class, $cancellation);
    }

    public function testCancellationAmountValidation()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('O campo valor deve conter um valor numérico.');

        $data = [
            'amount'           => 'ABC',
            'order'            => 'ABC123456123',
            'merchantCode'     => rand(100000000000000, 999999999999999),
            'merchantTerminal' => '001',
            'merchantKey'      => 'qwertyasdf0123456789',
        ];

        new Cancellation($data);
    }

    public function testOrderValidation()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('O campo código deve conter apenas letras e números .');

        $data = [
            'amount'           => 10,
            'order'            => 'ABC@123456123',
            'merchantCode'     => rand(100000000000000, 999999999999999),
            'merchantTerminal' => '001',
            'merchantKey'      => 'qwertyasdf0123456789',
        ];

        new Cancellation($data);
    }

    public function testMerchantCodeValidation()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('código da loja deve ter 15 dígitos');

        $data = [
            'amount'           => 10,
            'order'            => 'ABC123456123',
            'merchantCode'     => rand(1000000000000000, 9999999999999999),
            'merchantTerminal' => '001',
            'merchantKey'      => 'qwertyasdf0123456789',
        ];

        new Cancellation($data);
    }

    public function testMerchantTerminalValidation()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('O campo terminal deve conter um valor numérico.');

        $data = [
            'amount'           => 10,
            'order'            => 'ABC123456123',
            'merchantCode'     => rand(100000000000000, 999999999999999),
            'merchantTerminal' => 'a0001',
            'merchantKey'      => 'qwertyasdf0123456789',
        ];

        new Cancellation($data);
    }

    public function testMerchantKeyValidation()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('O campo chave de acesso é obrigatório.');

        $data = [
            'amount'           => 10,
            'order'            => 'ABC123456123',
            'merchantCode'     => rand(100000000000000, 999999999999999),
            'merchantTerminal' => '001',
        ];

        new Cancellation($data);
    }

    public function testXmlGeneration()
    {
        $data = [
            'amount'           => 10.00,
            'order'            => 'ABC123456123',
            'merchantCode'     => 292931924100909,
            'merchantTerminal' => '001',
            'merchantKey'      => 'qwertyasdf0123456789',
        ];

        $stubfile     = file_get_contents(__DIR__ . '/stubs/cancelamento.xml');
        $cancellation = new Cancellation($data);

        $this->assertEquals($stubfile, $cancellation->toXml());
    }
}