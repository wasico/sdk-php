<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Exceptions\WhereIsRequireException;
use Wasi\SDK\Models\Model;

class Feature extends SubModel
{
    public $autoData = true;

    public static function urlFind(Model $model): ? string
    {
        return null;
    }

    public static function urlGet(Model $model): ? string
    {
        return 'feature/all';
    }

    public static function autoData() : array
    {
        return ['list' => true];
    }
}