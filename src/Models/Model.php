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

    public static function search() : Model
    {
        return new static();
    }
}