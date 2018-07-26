<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Exceptions\WhereIsRequireException;
use Wasi\SDK\Models\Model;

class Region extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'location/region/';
    }

    public static function urlGet(Model $model): ? string
    {
        $whereArray = $model->getWhereArray();
        if(!isset($whereArray['id_country']))
            throw new WhereIsRequireException("Where with id_country is required");
        return 'location/regions-from-country/'.$whereArray['id_country'];
    }
}