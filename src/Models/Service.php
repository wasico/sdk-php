<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Service extends Model
{
    public function standartAttributes()
    {
        return [
            'id_service' => new Attribute(Attribute::INTEGER, false),
            'title' => new Attribute(Attribute::STRING, false),
            'abstract' => new Attribute(Attribute::STRING, false),
            'content' => new Attribute(Attribute::STRING, false),
            'image' => new Attribute(Attribute::STRING, false),
            'position' => new Attribute(Attribute::INTEGER, false),
        ];
    }
}