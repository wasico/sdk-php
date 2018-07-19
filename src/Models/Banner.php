<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Banner extends Model
{
    public function standartAttributes()
    {
        return [
            'id_banner' => new Attribute(Attribute::INTEGER, false),
            'title' => new Attribute(Attribute::STRING, false),
            'link' => new Attribute(Attribute::STRING, false),
            'id_status' => new Attribute(Attribute::INTEGER, false),
            'status_label' => new Attribute(Attribute::STRING, false),
            'image' => new Attribute(Attribute::STRING, false),
            'position' => new Attribute(Attribute::INTEGER, false),
        ];
    }
}