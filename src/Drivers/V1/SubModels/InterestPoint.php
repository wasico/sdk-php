<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Drivers\V1\WrappedModel;
use Wasi\SDK\Exceptions\WhereIsRequireException;
use Wasi\SDK\Models\Model;

class InterestPoint extends SubModel
{
    public $customGet = true;

    public static function urlFind(Model $model): ? string
    {
        return null;
    }

    public static function urlGet(Model $model): ? string
    {
        return null;
    }

    public static function customGet(Model $model)
    {
        $data = (new WrappedModel(
            \Wasi\SDK\Models\Model::class,
            'property/points-of-interest/'.self::checkWhere($model, ['id_property']),
            true
        ))->get();

        $grocery_or_supermarket = [];
        $school = [];
        $university = [];
        $restaurant = [];
        foreach ($data->grocery_or_supermarket ?? [] as $gos)
            $grocery_or_supermarket[] = new \Wasi\SDK\Models\InterestPoint($gos);
        foreach ($data->school ?? [] as $s)
            $school[] = new \Wasi\SDK\Models\InterestPoint($s);
        foreach ($data->university ?? [] as $u)
            $university[] = new \Wasi\SDK\Models\InterestPoint($u);
        foreach ($data->restaurant ?? [] as $r)
            $restaurant[] = new \Wasi\SDK\Models\InterestPoint($r);

        return compact(['grocery_or_supermarket', 'school', 'university', 'restaurant']);
    }
}