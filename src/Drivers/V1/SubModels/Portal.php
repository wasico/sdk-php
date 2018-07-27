<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Drivers\V1\WrappedModel;
use Wasi\SDK\Models\Model;

class Portal extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return null;
    }

    public static function urlGet(Model $model): ? string
    {
        return 'portal/all';
    }

    public static function property($class, $id_property)
    {
        return new WrappedModel(\Wasi\SDK\Models\Portal::class, "portal/property/$id_property");
    }
}