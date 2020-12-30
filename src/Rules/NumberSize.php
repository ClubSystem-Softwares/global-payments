<?php

namespace CSWeb\GlobalPayments\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class NumberSize
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments\Rules
 */
class NumberSize implements Rule
{
    protected $size;

    public function __construct(int $size)
    {
        $this->size = $size;
    }

    public function passes($attribute, $value): bool
    {
        return strlen($value) === $this->size;
    }

    public function message(): string
    {
        return ':attribute deve ter ' . $this->size . ' dígitos';
    }
}