<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Customer extends Model
{
    public function standartAttributes()
    {
        return [
            'id_client'        => new Attribute(Attribute::INTEGER, false),
            'id_user'          => new Attribute(Attribute::INTEGER),
            'id_client_type'   => new Attribute(Attribute::INTEGER),
            'id_country'       => new Attribute(Attribute::INTEGER),
            'country_label'    => new Attribute(Attribute::STRING, false),
            'id_region'        => new Attribute(Attribute::INTEGER),
            'region_label'     => new Attribute(Attribute::STRING, false),
            'id_city'          => new Attribute(Attribute::INTEGER),
            'city_label'       => new Attribute(Attribute::STRING, false),
            'id_client_status' => new Attribute(Attribute::INTEGER),
            'first_name'       => new Attribute(Attribute::STRING),
            'last_name'        => new Attribute(Attribute::STRING),
            'birthday'         => new Attribute(Attribute::DATE),
            'identification'   => new Attribute(Attribute::STRING),
            'email'            => new Attribute(Attribute::EMAIL),
        ];
    }
}