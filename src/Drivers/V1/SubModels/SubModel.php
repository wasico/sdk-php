<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

interface SubModel
{
    public static function urlFind(Model $model) : ? string;

    public static function urlGet(Model $model) : ? string;
}