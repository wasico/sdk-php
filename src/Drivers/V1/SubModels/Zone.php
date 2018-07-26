<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

class Zone extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'location/zone/';
    }

    public static function urlGet(Model $model): ? string
    {
        $whereArray = $model->getWhereArray();
        if(!isset($whereArray['id_city']) && !isset($whereArray['id_location']))
            throw new WhereIsRequireException("Where with id_location or id_city is required");
        if(isset($whereArray['id_location']))
            return 'location/zones-from-location/'.$whereArray['id_location'];
        return 'location/zones-from-city/'.$whereArray['id_city'];
    }
}