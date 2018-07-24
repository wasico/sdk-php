<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Configuration;
use Wasi\SDK\Drivers\V1\Core;
use Wasi\SDK\Models\Model;

class Property extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'property/get/';
    }

    public static function urlGet(Model $model): ? string
    {
        return 'property/search';
    }

    public static function owners(Model $model)
    {
        return Configuration::getDriver()->specialMethod($model, 'property/owner/'.$model->id_property, Customer::class);
    }
}