<?php

namespace CSWeb\GlobalPayments;

use CSWeb\GlobalPayments\Factories\ValidationFactory;

/**
 * Class Validator
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
abstract class Validator
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public abstract function rules(): array;

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
            $message = array_shift($errors)[0];

            throw new ValidationException($message);
        }
    }
}