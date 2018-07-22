<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

class Service implements SubModel
{

    public static function urlFind(): ? string
    {
        return 'service/get/';
    }

    public static function urlGet(): ? string
    {
        return 'service/search';
    }
}