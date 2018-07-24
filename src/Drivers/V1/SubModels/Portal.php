<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

class Portal implements SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return null;
    }

    public static function urlGet(Model $model): ? string
    {
        return 'portal/all';
    }
}