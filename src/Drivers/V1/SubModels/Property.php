<?php

namespace Wasi\SDK\Drivers\V1\SubModels;

use Wasi\SDK\Drivers\V1\WrappedModel;
use Wasi\SDK\Models\Model;

class Property implements SubModel
{

    public static function urlFind(Model $model): ? string
    {
        return 'property/get/';
    }

    public static function urlGet(Model $model): ? string
    {
        return 'property/search';
    }

    public function owners(Model $model)
    {
        return new WrappedModel(\Wasi\SDK\Models\Customer::class, 'property/owner/'.$model->id_property);
    }

    public static function highlighted()
    {
        return new WrappedModel(\Wasi\SDK\Models\Property::class, 'property/highlighted');
    }
}