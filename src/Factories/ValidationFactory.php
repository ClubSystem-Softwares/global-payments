<?php

namespace CSWeb\GlobalPayments\Factories;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\{FileLoader, Translator};
use Illuminate\Validation\Factory;

/**
 * Class ValidationFactory
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments\Factories
 */
class ValidationFactory
{
    public static function make(): Factory
    {
        $langPath = __DIR__ . '/../../resources/lang';

        $fs     = new Filesystem();
        $loader = new FileLoader($fs, $langPath);
        $loader->addNamespace('lang', $langPath);
        $loader->load('pt-BR', 'validation', 'lang');

        return new Factory(
            new Translator($loader, 'pt-BR')
        );
    }
}
