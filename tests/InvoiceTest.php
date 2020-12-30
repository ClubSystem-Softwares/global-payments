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
        $std = new stdClass();

        $std->Ds_Amount             = '1000';
        $std->Ds_Currency           = '986';
        $std->Ds_Order              = '6980eVlWfRri';
        $std->Ds_Signature          = 'DB5EB7B8299854D1C2B48FDEA013715CD0CAA0D2F38844FFF0DE0AC914CAE25A';
        $std->Ds_MerchantCode       = '012005733649001';
        $std->Ds_Terminal           = '1';
        $std->Ds_Response           = '0000';
        $std->Ds_AuthorisationCode  = '656141';
        $std->Ds_TransactionType    = 'A';
        $std->Ds_SecurePayment      = '0';
        $std->Ds_Language           = '9';
        $std->Ds_Card_Type          = 'C';
        $std->Ds_MerchantData       = new stdClass();
        $std->Ds_Card_Country       = '724';
        $std->Ds_Nsu                = '656141';
        $std->Ds_Card_Brand         = '1';
        $std->Ds_ProcessedPayMethod = '3';

        $invoice = new Invoice($std);

        $this->assertEquals($std->Ds_Amount, $invoice->amount);
        $this->assertEquals($std->Ds_Currency, $invoice->currency);
        $this->assertEquals($std->Ds_Order, $invoice->order);
        $this->assertEquals($std->Ds_Signature, $invoice->signature);
        $this->assertEquals($std->Ds_MerchantCode, $invoice->merchantCode);
        $this->assertEquals($std->Ds_Terminal, $invoice->terminal);
        $this->assertEquals($std->Ds_Response, $invoice->response);
        $this->assertEquals($std->Ds_AuthorisationCode, $invoice->authorisationCode);
        $this->assertEquals($std->Ds_TransactionType, $invoice->transactionType);
        $this->assertEquals($std->Ds_SecurePayment, $invoice->securePayment);
        $this->assertEquals($std->Ds_Language, $invoice->language);
        $this->assertEquals($std->Ds_Card_Type, $invoice->cardType);
        $this->assertEquals($std->Ds_Card_Country, $invoice->cardCountry);
        $this->assertEquals($std->Ds_Nsu, $invoice->nsu);
        $this->assertEquals($std->Ds_Card_Brand, $invoice->cardBrand);
        $this->assertEquals($std->Ds_ProcessedPayMethod, $invoice->processedPayMethod);
    }
}