<?php

namespace CSWeb\GlobalPayments;

use CSWeb\GlobalPayments\Validation\ValidatesCancellation;
use DOMDocument;
use Illuminate\Support\Str;

/**
 * Cancellation
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
class Cancellation extends AbstractTransaction
{
    public const CURRENCY = 986;

    public const TRANSACTION_TYPE = 3;

    protected $amount;

    protected $order;

    protected $merchantCode;

    protected $merchantKey;

    protected $merchantTerminal;

    public function __construct(array $data)
    {
        (new ValidatesCancellation($data))->validate();

        foreach ($data as $property => $value) {
            if (property_exists($this, $property)) {
                $method = 'set' . Str::title($property);
                $this->{$method}($value);
            }
        }
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

    public function getMerchantTerminal(): string
    {
        return $this->merchantTerminal;
    }

    public function setMerchantTerminal(string $merchantTerminal): Cancellation
    {
        $this->merchantTerminal = $merchantTerminal;

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

    public function getComponentData(): string
    {
        $dom = new DOMDocument();

        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = false;

        $dados     = $dom->createElement('DADOSENTRADA');
        $amount    = $dom->createElement('DS_MERCHANT_AMOUNT', $this->getAmount());
        $order     = $dom->createElement('DS_MERCHANT_ORDER', $this->getOrder());
        $merchant  = $dom->createElement('DS_MERCHANT_MERCHANTCODE', $this->getMerchantCode());
        $currency  = $dom->createElement('DS_MERCHANT_CURRENCY', self::CURRENCY);
        $type      = $dom->createElement('DS_MERCHANT_TRANSACTIONTYPE', self::TRANSACTION_TYPE);
        $terminal  = $dom->createElement('DS_MERCHANT_TERMINAL', $this->getMerchantTerminal());
        $signature = $dom->createElement('DS_MERCHANT_MERCHANTSIGNATURE', $this->getSignature());

        $dados->appendChild($amount);
        $dados->appendChild($order);
        $dados->appendChild($merchant);
        $dados->appendChild($currency);
        $dados->appendChild($type);
        $dados->appendChild($terminal);
        $dados->appendChild($signature);

        $dom->appendChild($dados);

        return $dom->saveXML($dados);
    }
}
