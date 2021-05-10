<?php

namespace CSWeb\GlobalPayments\Rules;

use DateTime;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class DateRule
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments\Rules
 */
class DateRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return $value instanceof DateTime;
    }

    public function message(): string
    {
        return 'A data de vencimento deve ser um objeto Datetime';
    }
}
