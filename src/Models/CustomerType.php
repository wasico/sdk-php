<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class CustomerType extends Model
{
    public function standartAttributes()
    {
        return [
            'id_client_type' => new Attribute(Attribute::INTEGER, false),
            'name' => new Attribute(Attribute::STRING, false),
            'nombre' => new Attribute(Attribute::STRING, false),
            'public' => new Attribute(Attribute::BOOLEAN, false),
        ];
    }
}