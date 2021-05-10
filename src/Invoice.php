<?php

namespace CSWeb\GlobalPayments;

use Illuminate\Support\{Fluent, Str};
use stdClass;

/**
 * Class Invoice
 *
 * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package CSWeb\GlobalPayments
 */
class Invoice extends Fluent
{
    public function __construct(stdClass $data)
    {
        parent::__construct(
            $this->transform($data)
        );
    }

    public function transform(stdClass $data): array
    {
        $data    = json_decode(json_encode($data), true);
        $newData = [];

        foreach ($data as $property => $value) {
            $property = str_replace(['Ds_', '_'], '', $property);
            $property = Str::camel($property);

            $newData[$property] = $value;
        }

        return $newData;
    }
}
