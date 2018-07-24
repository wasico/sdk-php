<?php

namespace Wasi\SDK\Drivers\V1\SubModels;


use Wasi\SDK\Models\Model;

class Banner extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'banner/get/';
    }

    public static function urlGet(Model $model): ? string
    {
        return 'banner/search';
    }
}