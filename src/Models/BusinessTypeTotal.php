<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class BusinessTypeTotal extends Model
{

    public function standartAttributes()
    {
        return [
            'quantity' => new Attribute(Attribute::INTEGER, false),
            'for_sale' => new Attribute(Attribute::BOOLEAN, false),
            'for_rent' => new Attribute(Attribute::BOOLEAN, false),
            'for_transfer' => new Attribute(Attribute::BOOLEAN, false),
            'id_country' => new Attribute(Attribute::INTEGER, false),
            'id_region' => new Attribute(Attribute::INTEGER, false),
            'id_city' => new Attribute(Attribute::INTEGER, false),
            'id_location' => new Attribute(Attribute::INTEGER, false),
            'id_zone' => new Attribute(Attribute::ARRAY, false),
            'scope' => new Attribute(Attribute::INTEGER, false),
        ];
    }
}