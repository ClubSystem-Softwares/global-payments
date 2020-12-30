<?php

namespace CSWeb\Tests\Factories;

use CSWeb\GlobalPayments\Factories\ValidationFactory;
use Illuminate\Support\Arr;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidationFactoryTest
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\Tests\Factories
 */
class ValidationFactoryTest extends TestCase
{
    public function testFactoryInstance()
    {
        $factory = ValidationFactory::make();

        $this->assertInstanceOf(Factory::class, $factory);
    }

    public function testDataValidation()
    {
        $this->expectExceptionMessage('The given data was invalid');
        $this->expectException(ValidationException::class);

        $factory = ValidationFactory::make();

        $factory->validate([
            'some_data' => null
        ], [
            'some_data' => 'required'
        ]);
    }

    public function testValidationMessage()
    {
        $factory = ValidationFactory::make();
        $message = null;

        try {
            $factory->validate([], [
                'some_data' => 'required'
            ]);
        } catch (ValidationException $e) {
            $message = Arr::get($e->errors(), 'some_data.0');
        }

        $this->assertEquals('O campo some data é obrigatório.', $message);
    }
}