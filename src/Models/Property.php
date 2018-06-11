<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Property extends Model
{
    public function standartAttributes()
    {
        return [
            'id_property'      => new Attribute(Attribute::INTEGER),
            'id_company'       => new Attribute(Attribute::INTEGER),
            'id_user'          => new Attribute(Attribute::INTEGER),
            'for_sale'         => new Attribute(Attribute::BOOLEAN),
            'for_rent'         => new Attribute(Attribute::BOOLEAN),
            'for_transfer'     => new Attribute(Attribute::BOOLEAN),
            'id_property_type' => new Attribute(Attribute::INTEGER),
            'id_country'       => new Attribute(Attribute::INTEGER),
            'country_label'    => new Attribute(Attribute::STRING, false),
            'id_region'        => new Attribute(Attribute::INTEGER),
            'region_label'     => new Attribute(Attribute::STRING, false),
            'title'            => new Attribute(Attribute::STRING),
        ];
    }
}