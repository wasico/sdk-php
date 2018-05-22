<?php

namespace Wasi\SDK\Drivers;

class V1 implements Driver
{
    function __construct(array $params = [])
    {
        var_dump($params);
    }
}