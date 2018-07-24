<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Models\Model;

class User extends SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'user/get/';
    }

    public static function urlGet(Model $model): ? string
    {
        return 'user/all-users';
    }
}