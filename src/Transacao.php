<?php

namespace CSWeb\GlobalPayments;

use CSWeb\GlobalPayments\Validation\ValidatesTransaction;
use DateTime;

/**
 * Class Transacao
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
class Transacao
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
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(float $amount): Transacao
    {
        $this->amount = ($amount * 100);

        return $this;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function setOrder(string $order): Transacao
    {
        $this->order = $order;

        return $this;
    }

    public function getMerchantCode(): int
    {
        return $this->merchantCode;
    }

    public function setMerchantCode(int $merchantCode): Transacao
    {
        $this->merchantCode = $merchantCode;

        return $this;
    }

    public function getMerchantTerminal(): int
    {
        return $this->merchantTerminal;
    }

    public function setMerchantTerminal(int $merchantTerminal): Transacao
    {
        $this->merchantTerminal = $merchantTerminal;

        return $this;
    }

    public function getCurrency(): int
    {
        return $this->currency;
    }

    public function setCurrency(int $currency): Transacao
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCardHolder(): string
    {
        return $this->cardHolder;
    }

    public function setCardHolder(string $cardHolder): Transacao
    {
        $this->cardHolder = $cardHolder;

        return $this;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function setCardNumber($cardNumber): Transacao
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getExpiryDate(): DateTime
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(DateTime $expiryDate): Transacao
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function getCvv(): string
    {
        return $this->cvv;
    }

    public function setCvv(string $cvv): Transacao
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function setTransactionType(string $transactionType): Transacao
    {
        if (!in_array($transactionType, [
            self::TRANSACTION_TYPE,
            self::TRANSACTION_TYPE_3DS,
            self::TRANSACTION_TYPE_PRE
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

    public function setAccountType(string $accountType): Transacao
    {
        if (!in_array($accountType, [self::ACCOUNT_TYPE_CREDITO, self::ACCOUNT_TYPE_DEBITO])) {
            throw new ValidationException('O tipo de pagamento passado é inválido');
        }

        $this->accountType = $accountType;

        return $this;
    }

    public function getPlanType(): string
    {
        return $this->planType;
    }

    public function setPlanType(string $planType): Transacao
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

    public function setInstallments(int $installments): Transacao
    {
        $this->installments = $installments;

        return $this;
    }
}