<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Drivers\V1\WrappedModel;
use Wasi\SDK\Models\Model;

class EnergyCertificate extends SubModel
{
    public $customGet = true;

    public static function urlFind(Model $model): ? string
    {
        return null;
    }

    public static function urlGet(Model $model): ? string
    {
        return null;
    }

    public static function customGet(Model $model)
    {
        return (new WrappedModel(
            \Wasi\SDK\Models\EnergyCertificate::class,
            'property/energy-certificate/get/'.self::checkWhere($model, ['id_property']),
            true
        ))->get();
    }
}