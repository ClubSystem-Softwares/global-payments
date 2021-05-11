<?php

namespace CSWeb\Tests;

use CSWeb\GlobalPayments\Invoice;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Class InvoiceTest
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\Tests
 */
class InvoiceTest extends TestCase
{
    public function testInvoiceHydratation()
    {
        $data = [
            'amount'             => '1000',
            'currency'           => '986',
            'order'              => '6980eVlWfRri',
            'signature'          => 'DB5EB7B8299854D1C2B48FDEA013715CD0CAA0D2F38844FFF0DE0AC914CAE25A',
            'merchantCode'       => '012005733649001',
            'terminal'           => '1',
            'response'           => '0000',
            'authorisationCode'  => '656141',
            'transactionType'    => 'A',
            'securePayment'      => '0',
            'language'           => '9',
            'cardType'           => 'C',
            'merchantData'       => [],
            'cardCountry'        => '724',
            'nsu'                => '656141',
            'cardBrand'          => '1',
            'processedPayMethod' => '3',
        ];

        $invoice = new Invoice($data);

        $this->assertEquals($data['amount'], $invoice->amount);
        $this->assertEquals($data['currency'], $invoice->currency);
        $this->assertEquals($data['order'], $invoice->order);
        $this->assertEquals($data['signature'], $invoice->signature);
        $this->assertEquals($data['merchantCode'], $invoice->merchantCode);
        $this->assertEquals($data['terminal'], $invoice->terminal);
        $this->assertEquals($data['response'], $invoice->response);
        $this->assertEquals($data['authorisationCode'], $invoice->authorisationCode);
        $this->assertEquals($data['transactionType'], $invoice->transactionType);
        $this->assertEquals($data['securePayment'], $invoice->securePayment);
        $this->assertEquals($data['language'], $invoice->language);
        $this->assertEquals($data['cardType'], $invoice->cardType);
        $this->assertEquals($data['cardCountry'], $invoice->cardCountry);
        $this->assertEquals($data['nsu'], $invoice->nsu);
        $this->assertEquals($data['cardBrand'], $invoice->cardBrand);
        $this->assertEquals($data['processedPayMethod'], $invoice->processedPayMethod);
    }
}