<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

class Location extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'location/location/';
    }

    public static function urlGet(Model $model): ? string
    {
        $whereArray = $model->getWhereArray();
        if(!isset($whereArray['id_city']))
            throw new WhereIsRequireException("Where with id_city is required");
        return 'location/locations-from-city/'.$whereArray['id_city'];
    }
}