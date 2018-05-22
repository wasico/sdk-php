<?php

namespace Wasi\SDK\Drivers;

class V1 implements Driver
{
    private $id_company;
    private $wasi_token;

    function __construct(array $params = [])
    {
        if(!isset($params['id_company'])) {
            throw new \Exception("id_company is required");
        }
    }
}