<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;
use Wasi\SDK\Configuration;

class Model
{
    private $where = [];

    public function standartAttributes()
    {
        return [];
    }

    public static function __callStatic($name, $arguments)
    {
        $class = static::class;
        switch ($name) {
            case 'find':
                return call_user_func_array("$class::findStatic", $arguments);
                break;
            case 'where':
                return call_user_func_array("$class::whereStatic", $arguments);
                break;
        }
    }

    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'where':
                return call_user_func_array([$this, 'whereInstance'], $arguments);
                break;
        }
    }

    public static function findStatic($id) : Model
    {
        $class = new static();
        return $class->find($id);
    }

    public static function whereStatic(string $attribute, $value) : Model
    {
        $class = new static();
        return $class->whereInstance($attribute, $value);
    }

    public function whereInstance(string $attribute, $value) : Model
    {
        $this->checkAttribute($attribute, $value);
        $this->where[$attribute] = $value;
        return $this;
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

    public function find(string $id)
    {
        return Configuration::getDriver()->find($this, $id);
    }

    public function get()
    {
        return Configuration::getDriver()->get($this);
    }
}