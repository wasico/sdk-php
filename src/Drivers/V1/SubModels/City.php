<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

class City extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'location/city/';
    }

    public static function urlGet(Model $model): ? string
    {
        $whereArray = $model->getWhereArray();
        if(!isset($whereArray['id_region']))
            throw new WhereIsRequireException("Where with id_region is required");
        return 'location/cities-from-region/'.$whereArray['id_region'];
    }
}