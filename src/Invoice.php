<?php

namespace CSWeb\GlobalPayments;

use Illuminate\Support\Str;
use stdClass;

/**
 * Class Invoice
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
class Invoice
{
    public $amount;

    public $currency;

    public $order;

    public $signature;

    public $merchantCode;

    public $terminal;

    public $response;

    public $authorisationCode;

    public $transactionType;

    public $securePayment;

    public $language;

    public $cardType;

    public $cardCountry;

    public $nsu;

    public $cardBrand;

    public $processedPayMethod;

    public function __construct(stdClass $data)
    {
        $this->hydrate($data);
    }

    public function hydrate(stdClass $data)
    {
        $data = json_decode(json_encode($data), true);

        foreach ($data as $property => $value) {
            $property = str_replace(['Ds_', '_'], '', $property);
            $property = Str::camel($property);

            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}