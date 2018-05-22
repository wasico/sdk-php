<?php

namespace Wasi\SDK;


class Configuration
{
    private $driver;

    public static function set(array $params)
    {
        $v = isset($params['v'])?$params['v']:1;
        $class = "Wasi\SDK\Drivers\V".$v;
        $refl = new \ReflectionClass($class);
        $instance = $refl->newInstanceArgs([$params]);
    }
}