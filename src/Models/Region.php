<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Region extends Model
{
    public function standartAttributes()
    {
        return [
            'id_region' => new Attribute(Attribute::INTEGER, false),
            'name' => new Attribute(Attribute::STRING, false),
            'id_country' => new Attribute(Attribute::INTEGER, false),
        ];
    }
}