<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Exceptions\WhereIsRequireException;
use Wasi\SDK\Models\Model;

abstract class SubModel
{
    public $customTotal = false;
    public $customGet = false;
    public $autoData = true;

    public abstract static function urlFind(Model $model) : ? string;

    public abstract static function urlGet(Model $model) : ? string;

    public static function autoData() : array
    {
        return [];
    }

    public static function customGet(Model $model)
    {
        return [];
    }

    public static function customTotal($request) : int
    {
        return 0;
    }

    public static function checkWhere(Model $model, $keys, $or = false)
    {
        $keys = is_array($keys) ? $keys : [$keys];
        $whereArray = $model->getWhereArray();
        $matchArray = [];
        $textOrException = '';
        foreach ($keys as $key) {
            if(isset($whereArray[$key]))
                $matchArray[$key] = $whereArray[$key];
            elseif(!$or)
                throw new WhereIsRequireException("Where with $key is required in " . get_class($model));
            if($or && count($matchArray) == 0)
                $textOrException .= empty($textOrException) ? $key : " or $key";
        }
        if(count($matchArray) == 0)
            throw new WhereIsRequireException("Where with $textOrException is required in " . get_class($model));
        if(count($keys) == 1)
            return $whereArray[$keys[0]];
        return $matchArray;
    }
}