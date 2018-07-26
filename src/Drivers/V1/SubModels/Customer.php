<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

class Customer extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'client/get/';
    }

    public static function urlGet(Model $model): ? string
    {
        return 'client/search';
    }
}