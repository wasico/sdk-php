<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

class User implements SubModel
{

    public static function urlFind(): ? string
    {
        return 'user/get/';
    }

    public static function urlGet(): ? string
    {
        return 'user/all-users';
    }
}