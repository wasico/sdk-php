<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Model
{
    private $where = [];

    public function standartAttributes()
    {
        return [];
    }

    public static function __callStatic($name, $arguments)
    {
        switch ($name) {
            case 'where':
                $class = static::class;
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
        }
    }
}