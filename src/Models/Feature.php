<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Feature extends Model
{
    public function standartAttributes()
    {
        return [
            'id' => new Attribute(Attribute::INTEGER, false),
            'name' => new Attribute(Attribute::STRING, false),
            'nombre' => new Attribute(Attribute::STRING, false),
        ];
    }
}