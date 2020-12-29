<?php

namespace CSWeb\GlobalPayments\Interfaces;

/**
 * Interface Serializable
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments\Interfaces
 */
interface Serializable
{
    public function toXml(): string;
}