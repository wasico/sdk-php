<?php

namespace Wasi\SDK\Drivers\V1\SubModels;


use Wasi\SDK\Models\Model;

class BusinessTypeTotal extends SubModel
{

    public $customTotal = true;

    public static function urlFind(Model $model): ? string
    {
        return null;
    }

    public static function urlGet(Model $model): ? string
    {
        self::checkWhere($model, ['for_sale', 'for_rent', 'for_transfer']);
        return 'property-business-type/quantity';
    }

    public static function customTotal($request) : int
    {
        return $request['quantity'];
    }
}