<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Property extends Model
{
    public function standartAttributes()
    {
        return [
            'id_property' => new Attribute('id_property', Attribute::INTEGER),
            'id_company'  => new Attribute('id_company', Attribute::INTEGER),
            'id_user'     => new Attribute('id_user', Attribute::INTEGER),
            'title'       => new Attribute('tittle', Attribute::STRING),
        ];
    }
}