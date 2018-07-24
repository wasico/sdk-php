<?php

namespace Wasi\SDK;


use Wasi\SDK\Drivers\Driver;

class Configuration
{
    private static $driver;

    public static function set(array $params)
    {
        $v = isset($params['v'])?$params['v']:1;
        unset($params['v']);
        $class = "Wasi\SDK\Drivers\V".$v."\Core";
        if (class_exists($class)) {
            $reflect = new \ReflectionClass($class);
            $instance = $reflect->newInstanceArgs([$params]);
            self::setDriver($instance);
        } else {
            throw new \Exception("Class $class does not exist");
        }
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