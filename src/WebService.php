<?php

namespace CSWeb\GlobalPayments;

use CSWeb\GlobalPayments\Interfaces\GlobalPaymentInterface;
use DOMDocument;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\{ClientException, ServerException};
use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;

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

    protected $logger;

    public function __construct(bool $sandbox = false, LoggerInterface $logger = null)
    {
        $this->logger = $logger;

        $endpoint = $sandbox
            ? 'https://sis-t.redsys.es:25443' // Sandbox
            : 'https://sisw.globalpaybrasil.com.br'; // Produção

        $this->client = new Client([
            'base_uri' => $endpoint,
        ]);
    }

    public function send(GlobalPaymentInterface $payment): string
    {
        try {
            $response = $this->client->post('/sis/services/SerClsWSEntrada', [
                'body'    => $payment->toXml(),
                'headers' => [
                    'Content-Type' => 'text/xml',
                    'SOAPAction'   => $payment->action(),
                ],
                'curl'    => [
                    CURLOPT_SSL_VERIFYPEER => false,
                ],
            ]);

            return $this->parseWebserviceSuccessResponse(
                $response->getBody()->getContents()
            );

        } catch (ClientException | ServerException $e) {
            $this->parseResponseError(
                $e->getResponse()->getBody()->getContents()
            );
        }
    }

    protected function parseResponseError(string $error)
    {
        if ($this->logger) {
            $this->logger->error($error);
        }

        $dom = new DOMDocument();
        $dom->loadXML($error);

        $fails = $dom->getElementsByTagName('faultstring');

        if ($fails) {
            foreach ($fails as $row) {
                throw new ServiceException(Str::after($row->nodeValue, ': '));
            }
        }

        throw new ServiceException('An error ocurred during your request. Please try again');
    }

    protected function parseWebserviceSuccessResponse(string $message): string
    {
        $dom = new DOMDocument();
        $dom->loadXML($message);

        $xml = json_decode(json_encode(simplexml_load_string($dom->textContent)));

        if (Str::contains($xml->CODIGO, 'SIS')) {
            ServiceException::throwInternalError($xml->CODIGO);
        }


        var_dump();
        die();

        var_dump(json_decode(json_encode()));
        die();
    }
}