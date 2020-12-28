<?php

namespace CSWeb\Tests\Validation;

use CSWeb\GlobalPayments\Validation\ValidatesTransaction;
use CSWeb\GlobalPayments\ValidationException;
use DateTime;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatesTransactionTest
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\Tests\Validation
 */
class ValidatesTransactionTest extends TestCase
{
    public function testTransactionValidation()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo valor é obrigatório');

        $data = [
            'order'      => 123456,
            'cardHolder' => 'Matheus Lopes Santos',
            'cardNumber' => '4111 1111 1111 1111',
            'cvv'        => '123',
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testOrderValidation()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo código é obrigatório');

        $data = [
            'amount'     => 0.00,
            'cardHolder' => 'Matheus Lopes Santos',
            'cardNumber' => '4111 1111 1111 1111',
            'cvv'        => '123',
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testOrderAlfaNumValidation()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo código deve conter apenas letras e números');

        $data = [
            'amount'     => 0.00,
            'order'      => '#123456',
            'cardHolder' => 'Matheus Lopes Santos',
            'cardNumber' => '4111 1111 1111 1111',
            'cvv'        => '123',
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testOrderSize()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo código não pode conter mais de 12 caracteres.');

        $data = [
            'amount'     => 0.00,
            'order'      => 'ABC123456123CVV',
            'cardHolder' => 'Matheus Lopes Santos',
            'cardNumber' => '4111 1111 1111 1111',
            'cvv'        => '123',
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testCardHolderName()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo titular é obrigatório');

        $data = [
            'amount'     => 0.00,
            'order'      => 'ABC123456123',
            'cardNumber' => '4111 1111 1111 1111',
            'cvv'        => '123',
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testCardHoldNameLength()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo titular não pode conter mais de 60 caracteres.');

        $data = [
            'amount'     => 0.00,
            'order'      => 'ABC123456123',
            'cardHolder' => Str::random(100),
            'cardNumber' => '4111 1111 1111 1111',
            'cvv'        => '123',
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testCardNumber()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo número do cartão é obrigatório');

        $data = [
            'amount'     => 0.00,
            'order'      => 'ABC123456123',
            'cardHolder' => 'Matheus Lopes Santos',
            'cvv'        => '123',
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testCreditCardValidation()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo número do cartão não pode conter mais de 19 caracteres');

        $data = [
            'amount'     => 0.00,
            'order'      => 'ABC123456123',
            'cardHolder' => 'Matheus Lopes Santos',
            'cardNumber' => '4111 1111 1111 1111 1223',
            'cvv'        => '123',
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testCvv()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo cvv é obrigatório');

        $data = [
            'amount'     => 0.00,
            'order'      => 'ABC123456123',
            'cardHolder' => 'Matheus Lopes Santos',
            'cardNumber' => '4111 1111 1111 1111',
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testCvvLength()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo cvv não pode conter mais de 4 caracteres.');

        $data = [
            'amount'     => 0.00,
            'order'      => 'ABC123456123',
            'cardHolder' => 'Matheus Lopes Santos',
            'cardNumber' => '4111 1111 1111 1111',
            'cvv'        => 12444,
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testExpiryDate()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo data de vencimento é obrigatório');

        $data = [
            'amount'     => 0.00,
            'order'      => 'ABC123456123',
            'cardHolder' => 'Matheus Lopes Santos',
            'cardNumber' => '4111 1111 1111 1111',
            'cvv'        => 1244,
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testExpiryDateFormat()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('A data de vencimento deve ser um objeto Datetime');

        $data = [
            'amount'     => 0.00,
            'order'      => 'ABC123456123',
            'cardHolder' => 'Matheus Lopes Santos',
            'cardNumber' => '4111 1111 1111 1111',
            'expiryDate' => '1120',
            'cvv'        => 1244,
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testInstallments()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo parcelas deve conter um valor numérico.');

        $data = [
            'amount'       => 0.00,
            'order'        => 'ABC123456123',
            'cardHolder'   => 'Matheus Lopes Santos',
            'cardNumber'   => '4111 1111 1111 1111',
            'cvv'          => 123,
            'expiryDate'   => new DateTime(),
            'installments' => 'a',
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }

    public function testMaxInstallments()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('O campo parcelas não pode conter um valor superior a 12');

        $data = [
            'amount'       => 0.00,
            'order'        => 'ABC123456123',
            'cardHolder'   => 'Matheus Lopes Santos',
            'cardNumber'   => '4111 1111 1111 1111',
            'cvv'          => 123,
            'expiryDate'   => new DateTime(),
            'installments' => 15,
        ];

        $validation = new ValidatesTransaction($data);
        $validation->validate();
    }
}