<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class News extends Model
{
    public function standartAttributes()
    {
        return [
            'id_news' => new Attribute(Attribute::INTEGER, false),
            'title' => new Attribute(Attribute::STRING, false),
            'abstract' => new Attribute(Attribute::STRING, false),
            'content' => new Attribute(Attribute::STRING, false),
            'image' => new Attribute(Attribute::URL, false),
            'date' => new Attribute(Attribute::DATE, false),
            'position' => new Attribute(Attribute::INTEGER, false),
        ];
    }
}