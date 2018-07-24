<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

abstract class SubModel
{
    private $specialRoute;

    public function setSpecialRoute(string $route)
    {
        $this->specialRoute = $route;
    }

    public function getSpecialRoute()
    {
        return $this->specialRoute;
    }

    abstract public static function urlFind(Model $model) : ? string;

    abstract public static function urlGet(Model $model) : ? string;
}