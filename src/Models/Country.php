<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Country extends Model
{
    public function standartAttributes()
    {
        return [
            'id_country' => new Attribute(Attribute::INTEGER, false),
            'name' => new Attribute(Attribute::STRING, false),
            'iso' => new Attribute(Attribute::STRING, false),
        ];
    }

    public function regions()
    {
        return Region::where('id_country', $this->attributes['id_country']);
    }
}