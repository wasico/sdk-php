<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Location extends Model
{
    public function standartAttributes()
    {
        return [
            'id_location' => new Attribute(Attribute::INTEGER, false),
            'name' => new Attribute(Attribute::STRING, false),
            'id_city' => new Attribute(Attribute::INTEGER, false),
        ];
    }
}