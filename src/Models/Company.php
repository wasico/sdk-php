<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Company extends Model
{
    public function standartAttributes()
    {
        return [
            'name' => new Attribute(Attribute::STRING, false),
            'email' => new Attribute(Attribute::STRING, false),
            'phone' => new Attribute(Attribute::STRING, false),
            'mobile' => new Attribute(Attribute::STRING, false),
            'url' => new Attribute(Attribute::STRING, false),
            'logo' => new Attribute(Attribute::STRING, false),
        ];
    }
}