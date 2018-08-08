<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Content extends Model
{
    public function standartAttributes()
    {
        return [
            'id_content' => new Attribute(Attribute::INTEGER, false),
            'title' => new Attribute(Attribute::STRING, false),
            'content' => new Attribute(Attribute::STRING, false),
            'link' => new Attribute(Attribute::STRING, false),
            'erasable' => new Attribute(Attribute::BOOLEAN, false),
        ];
    }
}