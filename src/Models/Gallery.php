<?php

namespace Wasi\SDK\Models;

use Wasi\SDK\Classes\Attribute;

class Gallery extends Model
{
    public function standartAttributes()
    {
        return [
            'id_gallery' => new Attribute(Attribute::INTEGER, false),
            'id_property' => new Attribute(Attribute::INTEGER, false),
        ];
    }

    public function images()
    {
        return Image::where('id_gallery', $this->attributes['id_gallery']);
    }

    public function property()
    {
        return Property::find($this->attributes['id_property']);
    }
}