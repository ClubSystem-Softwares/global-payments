<?php

namespace CSWeb\Tests;

use CSWeb\GlobalPayments\{Invoice, Transaction, WebService};
use DateTime;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

/**
 * Class WebServiceTest
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\Tests
 */
class WebServiceTest extends TestCase
{
    public function testWebServiceInstance()
    {
        $ws = new WebService(true);

        $this->assertInstanceOf(WebService::class, $ws);
    }

    public function testTransaction()
    {
        if (!getenv('MERCHANT_CODE') || !getenv('MERCHANT_TERMINAL')) {
            $this->assertTrue(true);
            return;
        }

        $data = [
            'amount'           => 10.00,
            'order'            => rand(1000, 9999) . Str::random(8),
            'cardHolder'       => 'Matheus Lopes Santos',
            'cardNumber'       => '4548812049400004',
            'cvv'              => 123,
            'expiryDate'       => new DateTime(),
            'merchantCode'     => getenv('MERCHANT_CODE'),
            'merchantTerminal' => getenv('MERCHANT_TERMINAL'),
            'merchantKey'      => 'qwertyasdf0123456789',
        ];

        $transaction    = new Transaction($data);
        $globalPayments = new WebService(true);

        $invoice = $globalPayments->send($transaction);

        $this->assertInstanceOf(Invoice::class, $invoice);
        $this->assertEquals($data['amount'] * 100, $invoice->amount);
        $this->assertEquals($data['order'], $invoice->order);
        $this->assertEquals($data['merchantCode'], $invoice->merchantCode);
    }
}