<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class EnergyCertificate extends Model
{
    public function standartAttributes()
    {
        return [
            'id_property' => new Attribute(Attribute::INTEGER, false),
            'is_certified' => new Attribute(Attribute::STRING, false),
            'certificate_type' => new Attribute(Attribute::INTEGER, false),
            'energy_rating' => new Attribute(Attribute::INTEGER, false),
            'ipe' => new Attribute(Attribute::INTEGER, false),
        ];
    }
}