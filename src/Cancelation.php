<?php

namespace CSWeb\GlobalPayments;

/**
 * Class Cancelation
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
class Cancelation implements Interfaces\GlobalPaymentInterface
{
    public const CURRENCY = 986;

    public const TRANSACTION_TYPE = 3;

    protected $amount;

    protected $order;

    protected $merchantCode;

    public function action(): string
    {
        return 'trataPeticion';
    }

    public function toXml(): string
    {
        // TODO: Implement toXml() method.
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(float $amount): Cancelation
    {
        $this->amount = ($amount * 100);

        return $this;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function setOrder(string $order): Cancelation
    {
        $this->order = $order;

        return $this;
    }

    public function getMerchantCode(): string
    {
        return $this->merchantCode;
    }

    public function setMerchantCode(string $merchantCode): Cancelation
    {
        $this->merchantCode = $merchantCode;

        return $this;
    }
}