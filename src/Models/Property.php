<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Property extends Model
{
    public function standartAttributes()
    {
        return [
            new Attribute('id_property', Attribute::INTEGER),
            new Attribute('id_company', Attribute::INTEGER),
            new Attribute('tittle', Attribute::STRING),
        ];
    }
}