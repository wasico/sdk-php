<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

class Property implements SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'property/get/';
    }

    public static function urlGet(Model $model): ? string
    {
        return 'property/search';
    }

    public static function owner(Model $model)
    {
        return $url = 'property/owner/'.$model->id_property;//temp
    }
}