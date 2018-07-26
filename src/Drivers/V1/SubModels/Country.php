<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

class Country extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'location/country/';
    }

    public static function urlGet(Model $model): ? string
    {
        return 'location/all-countries';
    }
}