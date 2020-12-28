<?php

namespace CSWeb\GlobalPayments;

use CSWeb\GlobalPayments\Validation\ValidatesTransaction;

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
}