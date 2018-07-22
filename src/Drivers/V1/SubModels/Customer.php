<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

class Customer implements SubModel
{

    public static function urlFind(): ? string
    {
        return 'client/get/';
    }

    public static function urlGet(): ? string
    {
        return 'client/search';
    }
}