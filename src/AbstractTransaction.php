<?php

namespace CSWeb\GlobalPayments;

use DOMDocument;

/**
 * Class AbstractTransaction
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
abstract class AbstractTransaction implements Interfaces\GlobalPaymentInterface
{
    public function action(): string
    {
        return 'trataPeticion';
    }

    abstract public function getComponentData(): string;

    abstract public function getSignature(): string;

    public function toXml(): string
    {
        $soapenvNS = 'http://schemas.xmlsoap.org/soap/envelope/';
        $webNS     = 'http://webservice.sis.sermepa.es';

        $dom = new DOMDocument('1.0', 'UTF-8');

        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = true;

        $envelope = $dom->createElementNS($soapenvNS, 'soapenv:Envelope');
        $envelope->setAttribute('xmlns:web', $webNS);

        $header = $dom->createElement('soapenv:Header');
        $envelope->appendChild($header);

        $body         = $dom->createElement('soapenv:Body');
        $web          = $dom->createElement('web:trataPeticion');
        $dadosEntrada = $dom->createElement('web:datoEntrada');

        $cdata = $dom->createCDATASection(
            $this->getComponentData()
        );

        $dadosEntrada->appendChild($cdata);
        $web->appendChild($dadosEntrada);
        $body->appendChild($web);
        $envelope->appendChild($body);

        $dom->appendChild($envelope);

        return $dom->saveXML();
    }
}
