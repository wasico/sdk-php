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

    public function region()
    {
        return Region::find($this->attributes['id_region']);
    }

    public function locations()
    {
        return Location::where('id_city', $this->attributes['id_city'])->get();
    }

    public function zones()
    {
        return Zone::where('id_city', $this->attributes['id_city'])->get();
    }
}