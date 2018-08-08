<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

class Content extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'content/get/';
    }

    public static function urlGet(Model $model): ? string
    {
        return 'content/search';
    }
}