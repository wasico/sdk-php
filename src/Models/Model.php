<?php

namespace Wasi\SDK\Models;

class Model
{
    public function standartAttributes()
    {
        return [];
    }

    public function where(string $attribute, $value) : Model
    {
        return $this;
    }

    public static function search() : Model
    {
        return new static();
    }
}