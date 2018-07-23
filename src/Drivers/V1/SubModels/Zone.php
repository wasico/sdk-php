<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

class Zone implements SubModel
{

    public static function urlFind(): ? string
    {
        return 'location/zone/';
    }

    public static function urlGet(): ? string
    {
        return null;
    }
}