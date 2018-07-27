<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Currency extends Model
{
    public function standartAttributes()
    {
        return [
            'id_currency' => new Attribute(Attribute::INTEGER, false),
            'iso' => new Attribute(Attribute::STRING, false),
            'name' => new Attribute(Attribute::STRING, false),
        ];
    }
}