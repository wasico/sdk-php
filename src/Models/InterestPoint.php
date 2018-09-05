<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class InterestPoint extends Model
{
    public function standartAttributes()
    {
        return [
            'name' => new Attribute(Attribute::STRING, false),
            'location' => new Attribute(Attribute::STRING, false),
            'types' => new Attribute(Attribute::STRING, false),
            'time_text' => new Attribute(Attribute::STRING, false),
            'distance_text' => new Attribute(Attribute::STRING, false),
        ];
    }
}