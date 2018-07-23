<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

class City implements SubModel
{

    public static function urlFind(): ? string
    {
        return 'location/city/';
    }

    public static function urlGet(): ? string
    {
        return null;
    }
}