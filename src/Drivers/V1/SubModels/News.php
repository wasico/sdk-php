<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

class News extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'news/get/';
    }

    public static function urlGet(Model $model): ? string
    {
        return 'news/search/';
    }
}