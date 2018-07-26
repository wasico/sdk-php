<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Drivers\V1\WrappedModel;
use Wasi\SDK\Models\Model;

class Company extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return null;
    }

    public static function urlGet(Model $model): ? string
    {
        return null;
    }

    public static function details()
    {
        return new WrappedModel(\Wasi\SDK\Models\Company::class, 'company/details', true);
    }
}