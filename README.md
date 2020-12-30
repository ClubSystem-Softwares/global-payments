# CSWEB GlobalPayments

Este package foi desenvolvido para uso do webservice
disponibilizado pela empresa GlobalPayments

Manual de instruções utilizado:
https://developers.globalpagamentos.com.br/api-portal/pt-br/content/e-commerce-webservice

#Instalação

Para realizar a instalação, utilize o composer

```shell
$ composer require csweb/global-payments
```

Até o momento, este package é compatível com a versão 5.8 do Laravel.
Este pacote pode e deve ser testado fora do laravel framework.

# Utilização

Para utilização, você precisa fazer o seguinte

```php
<?php

require_once __DIR__ . './vendor/autoload.php';

use CSWeb\GlobalPayments\Transaction;
use CSWeb\GlobalPayments\WebService;

$transaction = new Transaction([
    'amount'           => 10.00,
    'order'            => $yourOrderNumber,
    'cardHolder'       => 'Matheus Lopes Santos',
    'cardNumber'       => '4111 1111 1111 1111',
    'cvv'              => 123,
    'expiryDate'       => new DateTime(),
    'merchantCode'     => $yourMerchantCode,
    'merchantTerminal' => $yourMerchantTerminal,
    'merchantKey'      => $yourMerchantKey,
]);

$invoice = (new WebService())->send($transaction);
```

Em caso de ocorrer qualquer erro durante a chamada, o sistema irá
lançar diversas exceptions. Fique de olho nisso.

Em geral, o campo __merchantTerminal__ deve ser preenchido com o valor
*001*.

A global payments disponibiliza uma key de testes: __qwertyasdf0123456789__

Para utilização do __sandbox__, basta chamar a classe webservice
passando como parâmetro o valor `true`

```php
$invoice = (new WebService(true))->send(...);
```

Caso contrário, será apontado para o endpoint de produção automaticamente

## Contribuições

Todas as contribuições são muito bem vindas. Deixe seu pull request :)