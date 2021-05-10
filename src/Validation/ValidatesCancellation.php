<?php

namespace CSWeb\GlobalPayments\Validation;

use CSWeb\GlobalPayments\Rules\NumberSize;
use CSWeb\GlobalPayments\Validator;

class ValidatesCancellation extends Validator
{
    public function rules(): array
    {
        return [
            'amount'           => ['required', 'numeric'],
            'order'            => ['required', 'alpha_num', 'max:12'],
            'merchantCode'     => ['required', 'numeric', new NumberSize(15)],
            'merchantTerminal' => ['required', 'numeric', new NumberSize(3)],
            'merchantKey'      => ['required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'amount'           => 'valor',
            'order'            => 'código',
            'merchantCode'     => 'código da loja',
            'merchantTerminal' => 'terminal',
            'merchantKey'      => 'chave de acesso',
        ];
    }
}