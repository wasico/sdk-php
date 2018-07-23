<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class City extends Model
{
    public function standartAttributes()
    {
        return [
            'id_city' => new Attribute(Attribute::INTEGER, false),
            'name' => new Attribute(Attribute::STRING, false),
            'id_region' => new Attribute(Attribute::INTEGER, false),
        ];
    }
}