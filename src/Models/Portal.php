<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Portal extends Model
{
    public function standartAttributes()
    {
        return [
            'id' => new Attribute(Attribute::INTEGER, false),
            'name' => new Attribute(Attribute::STRING, false),
            'active' => new Attribute(Attribute::BOOLEAN, false),
        ];
    }
}