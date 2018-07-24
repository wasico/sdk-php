<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Zone extends Model
{
    public function standartAttributes()
    {
        return [
            'id_zone' => new Attribute(Attribute::INTEGER, false),
            'name' => new Attribute(Attribute::STRING, false),
            'id_city' => new Attribute(Attribute::INTEGER, false),
            'id_location' => new Attribute(Attribute::INTEGER, false),
            'owner' => new Attribute(Attribute::STRING, false),
        ];
    }

    public function city()
    {
        return City::find($this->attributes['id_city']);
    }

    public function location()
    {
        return Location::find($this->attributes['id_location']);
    }
}