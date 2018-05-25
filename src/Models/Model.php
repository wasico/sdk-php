<?php

namespace Wasi\SDK\Models;

class Model
{
    private $where = [];

    public function standartAttributes()
    {
        return [];
    }

    public function where(string $attribute, $value) : Model
    {
        $this->where[$attribute] = $value;
        return $this;
    }

    public function checkAttribute(string $attribute, $value) : bool
    {
        $attributes = $this->standartAttributes();
        if(!isset($attributes[$attribute]))
            return true;
    }

    public static function search() : Model
    {
        return new static();
    }
}