<?php

namespace CSWeb\GlobalPayments;

use CSWeb\GlobalPayments\Interfaces\GlobalPaymentInterface;
use CSWeb\GlobalPayments\Validation\ValidatesTransaction;
use DateTime;
use DOMDocument;
use Illuminate\Support\Str;

/**
 * Class Transacao
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
class Transaction implements GlobalPaymentInterface
{
    const TRANSACTION_TYPE = 'A';

    const TRANSACTION_TYPE_3DS = 0;

    const TRANSACTION_TYPE_PRE = 1;

    const ACCOUNT_TYPE_CREDITO = '01';

    const ACCOUNT_TYPE_DEBITO = '02';

    const PLAN_TYPE_VISTA = '01';

    const PLAN_TYPE_PARCELADO = '02';

    protected $amount;

    protected $order;

    protected $merchantCode;

    protected $merchantTerminal;

    protected $merchantKey;

    protected $currency = 986;

    protected $cardHolder;

    protected $cardNumber;

    protected $expiryDate;

    protected $cvv;

    protected $transactionType = self::TRANSACTION_TYPE;

    protected $accountType = self::ACCOUNT_TYPE_CREDITO;

    protected $planType = self::PLAN_TYPE_VISTA;

    protected $installments = 1;

    public function __construct(array $data)
    {
        $validator = new ValidatesTransaction($data);
        $validator->validate();

        foreach ($data as $property => $value) {
            if (property_exists($this, $property)) {
                $method = 'set' . Str::title($property);
                $this->{$method}($value);
            }
        }
    }

    public function action(): string
    {
        return 'trataPeticion';
    }

    public function getCardHolder(): string
    {
        return $this->cardHolder;
    }

    public function setCardHolder(string $cardHolder): Transaction
    {
        $this->cardHolder = $cardHolder;

        return $this;
    }

    public function getPlanType(): string
    {
        return $this->planType;
    }

    public function setPlanType(string $planType): Transaction
    {
        if (!in_array($planType, [self::PLAN_TYPE_VISTA, self::PLAN_TYPE_PARCELADO])) {
            throw new ValidationException('A forma de pagamento é inválida');
        }

        $this->planType = $planType;

        return $this;
    }

    public function getInstallments(): int
    {
        return $this->installments;
    }

    public function setInstallments(int $installments): Transaction
    {
        $this->installments = $installments;

        return $this;
    }

    public function getSignature(): string
    {
        $string = $this->getAmount()
                . $this->getOrder()
                . $this->getMerchantCode()
                . $this->getCurrency()
                . $this->getCardNumber()
                . $this->getCvv()
                . $this->getTransactionType()
                . $this->getMerchantKey();

        return hash('sha256', $string);
    }

    public function toXml(): string
    {
        $soapenvNS = 'http://schemas.xmlsoap.org/soap/envelope/';
        $webNS     = 'http://webservice.sis.sermepa.es';

        $dom = new DOMDocument('1.0', 'utf-8');

        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = true;

        $envelope = $dom->createElementNS($soapenvNS, 'soapenv:Envelope');
        $envelope->setAttribute('xmlns:web', $webNS);

        $header = $dom->createElement('soapenv:Header');
        $envelope->appendChild($header);

        $body         = $dom->createElement('soapenv:Body');
        $web          = $dom->createElement('web:trataPeticion');
        $dadosEntrada = $dom->createElement('web:datoEntrada');

        $cdata = $dom->createCDATASection(
            $this->getTransactionData()
        );

        $dadosEntrada->appendChild($cdata);
        $web->appendChild($dadosEntrada);
        $body->appendChild($web);
        $envelope->appendChild($body);

        $dom->appendChild($envelope);

        return $dom->saveXML();
    }

    private function getTransactionData()
    {
        $dom = new DOMDocument();

        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = true;

        $dados      = $dom->createElement('DATOSENTRADA');
        $amount     = $dom->createElement('DS_MERCHANT_AMOUNT', $this->getAmount());
        $order      = $dom->createElement('DS_MERCHANT_ORDER', $this->getOrder());
        $merchant   = $dom->createElement('DS_MERCHANT_MERCHANTCODE', $this->getMerchantCode());
        $terminal   = $dom->createElement('DS_MERCHANT_TERMINAL', $this->getMerchantTerminal());
        $currency   = $dom->createElement('DS_MERCHANT_CURRENCY', $this->getCurrency());
        $cardNumber = $dom->createElement('DS_MERCHANT_PAN', $this->getCardNumber());
        $expiryDate = $dom->createElement('DS_MERCHANT_EXPIRYDATE', $this->getExpiryDate()->format('ym'));
        $cvv        = $dom->createElement('DS_MERCHANT_CVV2', $this->getCvv());
        $type       = $dom->createElement('DS_MERCHANT_TRANSACTIONTYPE', $this->getTransactionType());
        $account    = $dom->createElement('DS_MERCHANT_ACCOUNTTYPE', $this->getAccountType());
        $signature  = $dom->createElement('DS_MERCHANT_MERCHANTSIGNATURE', $this->getSignature());

        $dados->appendChild($amount);
        $dados->appendChild($order);
        $dados->appendChild($merchant);
        $dados->appendChild($terminal);
        $dados->appendChild($currency);
        $dados->appendChild($cardNumber);
        $dados->appendChild($expiryDate);
        $dados->appendChild($cvv);
        $dados->appendChild($type);
        $dados->appendChild($account);
        $dados->appendChild($signature);

        $dom->appendChild($dados);

        return $dom->saveXML($dados);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(float $amount): Transaction
    {
        $this->amount = ($amount * 100);

        return $this;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function setOrder(string $order): Transaction
    {
        $this->order = $order;

        return $this;
    }

    public function getMerchantCode(): int
    {
        return $this->merchantCode;
    }

    public function setMerchantCode(int $merchantCode): Transaction
    {
        $this->merchantCode = $merchantCode;

        return $this;
    }

    public function getMerchantTerminal(): int
    {
        return $this->merchantTerminal;
    }

    public function setMerchantTerminal(int $merchantTerminal): Transaction
    {
        $this->merchantTerminal = $merchantTerminal;

        return $this;
    }

    public function getMerchantKey(): string
    {
        return $this->merchantKey;
    }

    public function setMerchantKey(string $key): Transaction
    {
        $this->merchantKey = $key;

        return $this;
    }

    public function getCurrency(): int
    {
        return $this->currency;
    }

    public function setCurrency(int $currency): Transaction
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function setCardNumber($cardNumber): Transaction
    {
        $this->cardNumber = preg_replace('/[^0-9]/', '', $cardNumber);

        return $this;
    }

    public function getExpiryDate(): DateTime
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(DateTime $expiryDate): Transaction
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function getCvv(): string
    {
        return $this->cvv;
    }

    public function setCvv(string $cvv): Transaction
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function setTransactionType(string $transactionType): Transaction
    {
        if (!in_array($transactionType, [
            self::TRANSACTION_TYPE,
            self::TRANSACTION_TYPE_3DS,
            self::TRANSACTION_TYPE_PRE,
        ])) {
            throw new ValidationException('O tipo de transação não foi definido.');
        }

        $this->transactionType = $transactionType;

        return $this;
    }

    public function getAccountType(): string
    {
        return $this->accountType;
    }

    public function setAccountType(string $accountType): Transaction
    {
        if (!in_array($accountType, [self::ACCOUNT_TYPE_CREDITO, self::ACCOUNT_TYPE_DEBITO])) {
            throw new ValidationException('O tipo de pagamento passado é inválido');
        }

        $this->accountType = $accountType;

        return $this;
    }
}