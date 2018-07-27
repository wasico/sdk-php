<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Image extends Model
{
    public function standartAttributes()
    {
        return [
            'id_image' => new Attribute(Attribute::INTEGER, false),
            'url' => new Attribute(Attribute::STRING, false),
            'url_big' => new Attribute(Attribute::STRING, false),
            'description' => new Attribute(Attribute::STRING, false),
            'position' => new Attribute(Attribute::INTEGER, false),
        ];
    }
}