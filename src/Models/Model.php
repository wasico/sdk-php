<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;
use Wasi\SDK\Configuration;

class Model
{
    private $where = [];

    private static $standardMethods = ['get', 'find', 'where'];

    public function standartAttributes()
    {
        return [];
    }

    public static function __callStatic($name, $arguments)
    {
        if(in_array($name, self::$standardMethods))
            return call_user_func_array(static::class."::{$name}Static", $arguments);
    }

    public function __call($name, $arguments)
    {
        if(in_array($name, self::$standardMethods))
            return call_user_func_array([$this, "{$name}Instance"], $arguments);
    }

    private static function findStatic(string $id)
    {
        $class = new static();
        return $class->findInstance($id);
    }

    private function findInstance(string $id)
    {
        return Configuration::getDriver()->find($this, $id);
    }

    private static function whereStatic(string $attribute, $value) : Model
    {
        $class = new static();
        return $class->whereInstance($attribute, $value);
    }

    private function whereInstance(string $attribute, $value) : Model
    {
        $this->checkAttribute($attribute, $value);
        $this->where[$attribute] = $value;
        return $this;
    }

    public function getInstance()
    {
        return Configuration::getDriver()->get($this);
    }

    public static function getStatic()
    {
        $class = new static();
        return $class->getInstance();
    }

    public function checkAttribute(string $attribute, $value)
    {
        $attributes = $this->standartAttributes();
        if(!isset($attributes[$attribute]))
            return;
        switch ($attributes[$attribute]->getType())
        {
            case Attribute::INTEGER:
                if(!is_integer($value))
                    throw new \Exception("The attribute $attribute must be an integer");
                break;
            case Attribute::STRING:
                if(!is_string($value))
                    throw new \Exception("The attribute $attribute must be a string");
                break;
            case Attribute::BOOLEAN:
                if(!is_bool($value))
                    throw new \Exception("The attribute $attribute must be a boolean");
                break;
        }
    }

    public function getWhereArray() : array
    {
        return $this->where;
    }
}