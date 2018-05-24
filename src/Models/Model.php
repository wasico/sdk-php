<?php

namespace Wasi\SDK\Models;

class Model
{
    public function standartAttributes()
    {
        return [];
    }

    public static function where(string $attribute, $value) : Model
    {
        $return = new static();
        return $return;
    }
}