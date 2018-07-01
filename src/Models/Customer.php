<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Customer extends Model
{
    public function standartAttributes()
    {
        return [
            'id_client'      => new Attribute(Attribute::INTEGER, false),
            'id_user'        => new Attribute(Attribute::INTEGER),
            'id_client_type' => new Attribute(Attribute::INTEGER),
        ];
    }
}