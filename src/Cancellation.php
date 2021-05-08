<?php

namespace CSWeb\GlobalPayments;

/**
 * Cancellation
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
class Cancellation implements Interfaces\GlobalPaymentInterface
{
    public const CURRENCY = 986;

    public const TRANSACTION_TYPE = 3;

    protected $amount;

    protected $order;

    protected $merchantCode;

    protected $merchantKey;

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

    public function setAmount(float $amount): Cancellation
    {
        $this->amount = ($amount * 100);

        return $this;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function setOrder(string $order): Cancellation
    {
        $this->order = $order;

        return $this;
    }

    public function getMerchantCode(): string
    {
        return $this->merchantCode;
    }

    public function setMerchantCode(string $merchantCode): Cancellation
    {
        $this->merchantCode = $merchantCode;

        return $this;
    }

    public function getMerchantKey(): string
    {
        return $this->merchantKey;
    }

    public function setMerchantKey(string $key): Cancellation
    {
        $this->merchantKey = $key;

        return $this;
    }

    public function getSignature(): string
    {
        $string = $this->getAmount()
            . $this->getOrder()
            . $this->getMerchantCode()
            . self::CURRENCY
            . self::TRANSACTION_TYPE
            . $this->getMerchantKey();

        return hash('sha256', $string);
    }
}