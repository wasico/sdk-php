<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;
use Wasi\SDK\Configuration;
use Wasi\SDK\Drivers\V1\WrappedModel;

class Model implements \JsonSerializable
{
    private static $standardMethods = ['count', 'data', 'find', 'first', 'get', 'order', 'orderBy', 'skip', 'take', 'where'];

    protected $attributes = [];
    private $data = [];
    private $changed = [];
    private $where = [];
    private $skip = null;
    private $take = null;
    private $order = null;
    private $orderBy = null;
    protected $idKey = null;

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function standartAttributes()
    {
        return [];
    }

    public function getIdKey()
    {
        return $this->idKey;
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
        $this->changed[] = $name;
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
        return $class->instanceTake($take);
    }

    private static function staticOrderBy(string $column, string $order)
    {
        $class = new static();
        return $class->instanceOrderBy($column, $order);
    }

    private static function staticWhere($attribute, $value = null) : Model
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

    private function instanceWhere($attribute, $value = null) : Model
    {
        if(is_array($attribute)) {
            foreach ($attribute as $a)
                if(is_array($a) && count($a) == 2) {
                    $this->checkAttribute($a[0], $a[1], true);
                    $this->where[$a[0]] = $a[1];
                }
            return $this;
        } else if(is_string($attribute)) {
            $this->checkAttribute($attribute, $value, true);
            $this->where[$attribute] = $value;
            return $this;
        }
        throw new \Exception("The attribute $attribute must be a string or array");
    }

    /*
    |--------------------------------------------------------------------------
    | Other methods
    |--------------------------------------------------------------------------
    */

    public function checkAttribute(string $attribute, $value, $passEditable = false)
    {
        $attributes = $this->standartAttributes();
        if(!isset($attributes[$attribute]) || $value === null)
            return;

        if(!$passEditable && !$attributes[$attribute]->isEditable()) {
            throw new \Exception("The attribute $attribute is not editable");
        }

        switch ($attributes[$attribute]->getType())
        {
            case Attribute::INTEGER:
                if(!is_integer($value) && !ctype_digit($value))
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

    public function getChangedArray() : array
    {
        $return = [];
        foreach ($this->changed as $c) {
            $return[$c] = $this->attributes[$c];
        }
        return $return;
    }

    public function save()
    {
        if($this->{$this->getIdKey()} != null) {
            return Configuration::getDriver()->update($this);
        } else {
            $return = Configuration::getDriver()->create($this);
            $this->attributes[$this->getIdKey()] = $return->{$this->getIdKey()};
        }
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return array data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        return $this->attributes;
    }

    public function getKeyString()
    {
        if($this instanceof WrappedModel)
            $class = get_class($this)."-:-".$this->getWrappedModel();
        else
            $class = get_class($this);
        return json_encode([
            'id_company' => Configuration::getDriver()->getIdCompany(),
            'class' => $class,
            'attributes' => $this->attributes,
            'data' => $this->data,
            'where' => $this->where,
            'skip' => $this->skip,
            'take' => $this->take,
            'order' => $this->order,
            'orderBy' => $this->orderBy,
        ]);
    }
}