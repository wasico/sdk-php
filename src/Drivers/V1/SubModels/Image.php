<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Exceptions\WhereIsRequireException;
use Wasi\SDK\Models\Model;

class Image extends SubModel
{
    public static function urlFind(Model $model): ? string
    {
        return null;
    }

    public static function urlGet(Model $model): ? string
    {
        return 'gallery/image/all/'.self::checkWhere($model, ['id_gallery']);
    }
}