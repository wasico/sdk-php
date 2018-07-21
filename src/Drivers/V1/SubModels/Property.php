<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

class Property implements SubModel
{

    public static function urlFind(): string
    {
        return 'property/get/';
    }

    public static function urlGet(): string
    {
        return 'property/search';
    }
}