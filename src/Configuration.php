<?php

namespace Wasi\SDK;


use Wasi\SDK\Drivers\Driver;

class Configuration
{
    private static $driver;

    public static function set(array $params)
    {
        $v = isset($params['v'])?$params['v']:1;
        $class = "Wasi\SDK\Drivers\V".$v;
        $refl = new \ReflectionClass($class);
        $instance = $refl->newInstanceArgs([$params]);
        self::setDriver($instance);
    }

    public static function setDriver(Driver $driver)
    {
        static::$driver = $driver;
    }

    public static function getDriver() : Driver
    {
        return static::$driver;
    }
}