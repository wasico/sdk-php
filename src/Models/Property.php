<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Property extends Model
{
    public function standartAttributes()
    {
        return [
            'id_property' => new Attribute(Attribute::INTEGER),
            'id_company'  => new Attribute(Attribute::INTEGER),
            'id_user'     => new Attribute(Attribute::INTEGER),
            'title'       => new Attribute(Attribute::STRING),
        ];
    }
}