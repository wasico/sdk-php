<?php

namespace Wasi\SDK\Drivers\V1\SubModels;


class Banner implements SubModel
{

    public static function urlFind(): string
    {
        return 'banner/get/';
    }

    public static function urlGet(): string
    {
        return 'banner/search';
    }
}