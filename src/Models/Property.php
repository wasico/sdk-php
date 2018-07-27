<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Property extends Model
{
    public function standartAttributes()
    {
        return [
            'id_property'              => new Attribute(Attribute::INTEGER, false),
            'id_company'               => new Attribute(Attribute::INTEGER),
            'id_user'                  => new Attribute(Attribute::INTEGER),
            'for_sale'                 => new Attribute(Attribute::BOOLEAN),
            'for_rent'                 => new Attribute(Attribute::BOOLEAN),
            'for_transfer'             => new Attribute(Attribute::BOOLEAN),
            'id_property_type'         => new Attribute(Attribute::INTEGER),
            'id_country'               => new Attribute(Attribute::INTEGER),
            'country_label'            => new Attribute(Attribute::STRING, false),
            'id_region'                => new Attribute(Attribute::INTEGER),
            'region_label'             => new Attribute(Attribute::STRING, false),
            'id_city'                  => new Attribute(Attribute::INTEGER),
            'city_label'               => new Attribute(Attribute::STRING, false),
            'id_zone'                  => new Attribute(Attribute::INTEGER),
            'zone'                     => new Attribute(Attribute::STRING),
            'zone_label'               => new Attribute(Attribute::STRING, false),
            'id_currency'              => new Attribute(Attribute::INTEGER),
            'iso_currency'             => new Attribute(Attribute::STRING, false),
            'title'                    => new Attribute(Attribute::STRING),
            'address'                  => new Attribute(Attribute::STRING),
            'area'                     => new Attribute(Attribute::INTEGER),
            'id_unit_area'             => new Attribute(Attribute::INTEGER),
            'unit_area_label'          => new Attribute(Attribute::STRING, false),
            'built_area'               => new Attribute(Attribute::INTEGER),
            'id_unit_built_area'       => new Attribute(Attribute::INTEGER),
            'unit_built_area_label'    => new Attribute(Attribute::STRING, false),
            'maintenance_fee'          => new Attribute(Attribute::INTEGER),
            'sale_price'               => new Attribute(Attribute::INTEGER),
            'rent_price'               => new Attribute(Attribute::INTEGER),
            'bedrooms'                 => new Attribute(Attribute::INTEGER),
            'bathrooms'                => new Attribute(Attribute::INTEGER),
            'garages'                  => new Attribute(Attribute::INTEGER),
            'floor'                    => new Attribute(Attribute::INTEGER),
            'stratum'                  => new Attribute(Attribute::INTEGER),
            'observations'             => new Attribute(Attribute::STRING),
            'video'                    => new Attribute(Attribute::STRING),
            'id_property_condition'    => new Attribute(Attribute::INTEGER),
            'property_condition_label' => new Attribute(Attribute::STRING),
            'id_status_on_page'        => new Attribute(Attribute::INTEGER),
            'status_on_page_label'     => new Attribute(Attribute::STRING, false),
            'map'                      => new Attribute(Attribute::STRING),
            'latitude'                 => new Attribute(Attribute::STRING),
            'longitude'                => new Attribute(Attribute::STRING),
            'building_date'            => new Attribute(Attribute::STRING),
            'network_share'            => new Attribute(Attribute::BOOLEAN),
            'visits'                   => new Attribute(Attribute::INTEGER),
            'created_at'               => new Attribute(Attribute::DATETIME, false),
            'updated_at'               => new Attribute(Attribute::DATETIME, false),
            'reference'                => new Attribute(Attribute::STRING),
            'comment'                  => new Attribute(Attribute::STRING),
            'id_rents_type'            => new Attribute(Attribute::INTEGER),
            'rents_type_label'         => new Attribute(Attribute::STRING, false),
            'zip_code'                 => new Attribute(Attribute::STRING),
            'id_availability'          => new Attribute(Attribute::INTEGER),
            'availability_label'       => new Attribute(Attribute::STRING, false),
            'id_publish_on_map'        => new Attribute(Attribute::INTEGER),
            'publish_on_map_label'     => new Attribute(Attribute::STRING, false),
            'label'                    => new Attribute(Attribute::STRING),
        ];
    }

    public function user()
    {
        return User::find($this->attributes['id_user']);
    }

    public function galleries()
    {
        return Gallery::where('id_property', $this->attributes['id_property']);
    }
}