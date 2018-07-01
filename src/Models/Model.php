<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;
use Wasi\SDK\Configuration;

class Model
{
    private static $standardMethods = ['find', 'get', 'skip', 'take', 'where'];

    private $where = [];
    private $skip = null;
    private $take = null;

    public function standartAttributes()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Model's calls
    |--------------------------------------------------------------------------
    */

    public static function __callStatic($name, $arguments)
    {
        if(in_array($name, self::$standardMethods))
            return call_user_func_array(static::class."::static".ucfirst($name), $arguments);
    }

    public function __call($name, $arguments)
    {
        if(in_array($name, self::$standardMethods))
            return call_user_func_array([$this, "instance".ucfirst($name)], $arguments);
    }

    /*
    |--------------------------------------------------------------------------
    | Models standard methods
    |--------------------------------------------------------------------------
    */

    private static function staticFind(string $id)
    {
        $class = new static();
        return $class->instanceFind($id);
    }

    private static function staticSkip(integer $skip)
    {
        $class = new static();
        return $class->instanceSkip($skip);
    }

    private static function staticTake(integer $take)
    {
        $class = new static();
        return $class->instanceSkip($take);
    }

    private static function staticGet()
    {
        $class = new static();
        return $class->instanceGet();
    }

    private static function staticWhere(string $attribute, $value) : Model
    {
        $class = new static();
        return $class->instanceWhere($attribute, $value);
    }

    /*-----------------------------------------------------------------------*/

    private function instanceFind(string $id)
    {
        return Configuration::getDriver()->find($this, $id);
    }

    private function instanceGet()
    {
        return Configuration::getDriver()->get($this);
    }

    private function instanceSkip(integer $skip)
    {
        return $this->skip = $skip;
    }

    private function instanceTake(integer $take)
    {
        return $this->take = $take;
    }

    private function instanceWhere(string $attribute, $value) : Model
    {
        $this->checkAttribute($attribute, $value);
        $this->where[$attribute] = $value;
        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Other methods
    |--------------------------------------------------------------------------
    */

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