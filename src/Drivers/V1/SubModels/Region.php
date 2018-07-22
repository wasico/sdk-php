<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

class Region implements SubModel
{

    public static function urlFind(): ? string
    {
        return 'location/region/';
    }

    public static function urlGet(): ? string
    {
        return null;
    }
}