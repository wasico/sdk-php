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

    public function country()
    {
        return Country::find($this->attributes['id_country']);
    }

    public function cities()
    {
        return City::where('id_region', $this->attributes['id_region'])->get();
    }
}