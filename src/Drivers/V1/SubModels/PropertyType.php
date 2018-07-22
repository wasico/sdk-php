<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

class PropertyType implements SubModel
{

    public static function urlFind(): ? string
    {
        return null;
    }

    public static function urlGet(): ? string
    {
        return 'property-type/all';
    }
}