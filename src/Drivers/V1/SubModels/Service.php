<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

class Service extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'service/get/';
    }

    public static function urlGet(Model $model): ? string
    {
        return 'service/search';
    }
}