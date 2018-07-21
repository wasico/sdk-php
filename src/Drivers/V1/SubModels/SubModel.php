<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

interface SubModel
{
    public static function urlFind() : string;

    public static function urlGet() : string;
}