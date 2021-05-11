<?php

namespace CSWeb\GlobalPayments;

use CSWeb\GlobalPayments\Factories\ValidationFactory;
use Illuminate\Support\Arr;
use InvalidArgumentException;

/**
 * Class Validator
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
abstract class Validator
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    abstract public function rules(): array;

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [];
    }

    public function validate(): bool
    {
        try {
            $factory = ValidationFactory::make();
            $factory->validate(
                $this->data,
                $this->rules(),
                $this->messages(),
                $this->attributes()
            );

            return true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors  = $e->errors();
            $message = Arr::first($errors);

            throw new InvalidArgumentException($message[0]);
        }
    }
}
