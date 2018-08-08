<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;
use Wasi\SDK\Configuration;

class Model
{
    private static $standardMethods = ['count', 'data', 'find', 'first', 'get', 'order', 'orderBy', 'skip', 'take', 'where'];

    protected $attributes = [];
    private $data = [];
    private $where = [];
    private $skip = null;
    private $take = null;
    private $order = null;
    private $orderBy = null;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function standartAttributes()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Model's calls
    |--------------------------------------------------------------------------
    */

    public function __call($name, $arguments)
    {
        if(in_array($name, self::$standardMethods))
            return call_user_func_array([$this, "instance".ucfirst($name)], $arguments);
        $driver = Configuration::getDriver();
        $arguments = array_merge([$this], $arguments);
        return call_user_func_array([$driver, $name], $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        if(in_array($name, self::$standardMethods))
            return call_user_func_array(static::class."::static".ucfirst($name), $arguments);
        $driver = Configuration::getDriver();
        $arguments = array_merge([static::class], $arguments);
        return call_user_func_array(get_class($driver)."::$name", $arguments);
    }

    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    public function __set($name, $value)
    {
        $this->checkAttribute($name, $value);
        $this->attributes[$name] = $value;
    }

    /*
    |--------------------------------------------------------------------------
    | Models standard methods
    |--------------------------------------------------------------------------
    */

    private static function staticCount()
    {
        $class = new static();
        return$class->instanceCount();
    }

    private static function staticData(array $data)
    {
        $class = new static();
        return $class->instanceData($data);
    }

    private static function staticFind(string $id)
    {
        $class = new static();
        return $class->instanceFind($id);
    }

    private static function staticFirst()
    {
        $class = new static();
        return $class->instanceFirst();
    }

    private static function staticGet()
    {
        $class = new static();
        return $class->instanceGet();
    }

    private static function staticSkip(int $skip)
    {
        $class = new static();
        return $class->instanceSkip($skip);
    }

    private static function staticTake(int $take)
    {
        $class = new static();
        return $class->instanceSkip($take);
    }

    private static function staticOrderBy(string $column, string $order)
    {
        $class = new static();
        return $class->instanceOrderBy($column, $order);
    }

    private static function staticWhere(string $attribute, $value) : Model
    {
        $class = new static();
        return $class->instanceWhere($attribute, $value);
    }

    /*-----------------------------------------------------------------------*/

    private function instanceCount()
    {
        return Configuration::getDriver()->count($this);
    }

    private function instanceData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    private function instanceFind(string $id)
    {
        return Configuration::getDriver()->find($this, $id);
    }

    private function instanceFirst()
    {
        $this->take = 1;
        $return = Configuration::getDriver()->get($this);
        return isset($return[0]) ? $return[0] : null;
    }

    private function instanceGet()
    {
        return Configuration::getDriver()->get($this);
    }

    private function instanceSkip(int $skip)
    {
        $this->skip = $skip;
        return $this;
    }

    private function instanceTake(int $take)
    {
        $this->take = $take;
        return $this;
    }

    private function instanceOrderBy(string $column, string $order)
    {
        $this->orderBy = $column;
        $this->order = $order;
        return $this;
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

    public function getDataArray() : array
    {
        return $this->data;
    }

    public function getSkip()
    {
        return $this->skip;
    }

    public function getTake()
    {
        return $this->take;
    }

    public function getOrderBy()
    {
        return $this->orderBy;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getWhereArray() : array
    {
        return $this->where;
    }
}