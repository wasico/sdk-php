<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

class Location implements SubModel
{

    public static function urlFind(): ? string
    {
        return 'location/location/';
    }

    public static function urlGet(): ? string
    {
        return null;
    }
}