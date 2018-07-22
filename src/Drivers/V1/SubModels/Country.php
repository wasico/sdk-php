<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

class Country implements SubModel
{

    public static function urlFind(): ? string
    {
        return 'location/country/';
    }

    public static function urlGet(): ? string
    {
        return 'location/all-countries';
    }
}