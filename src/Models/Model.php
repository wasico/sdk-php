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

    public function where(string $attribute, $value) : Model
    {
        $this->checkAttribute($attribute, $value);
        $this->where[$attribute] = $value;
        return $this;
    }

    public function checkAttribute(string $attribute, $value) : bool
    {
        $attributes = $this->standartAttributes();
        if(!isset($attributes[$attribute]))
            return true;
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
        return false;
    }

    public static function search() : Model
    {
        return new static();
    }
}