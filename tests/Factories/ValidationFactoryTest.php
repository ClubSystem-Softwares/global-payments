<?php

namespace CSWeb\Tests\Factories;

use CSWeb\GlobalPayments\Factories\ValidationFactory;
use Illuminate\Validation\Factory;
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
}