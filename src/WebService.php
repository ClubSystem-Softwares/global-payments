<?php

namespace CSWeb\GlobalPayments;

use CSWeb\GlobalPayments\Interfaces\Serializable;
use GuzzleHttp\Client;

/**
 * Class Http
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
class WebService
{
    protected $client;

    public function __construct(bool $sandbox = false)
    {
        $endpoint = $sandbox
            ? 'https://sis-t.redsys.es:25443' // Sandbox
            : 'https://sisw.globalpaybrasil.com.br'; // Produção

        $this->client = new Client([
            'base_uri' => $endpoint,
        ]);
    }

    public function send(Serializable $serializable): string
    {
        $response = $this->client->post('/sis/services/SerClsWSEntrada', [
            'body'    => $serializable->toXml(),
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
            'curl'    => [
                CURLOPT_SSL_VERIFYPEER => false,
            ],
        ]);

        return $response->getBody()->getContents();
    }
}