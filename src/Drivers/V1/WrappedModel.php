<?php

namespace Wasi\SDK\Drivers\V1;

use Wasi\SDK\Models\Model;

class WrappedModel extends Model
{
    private $wrappedModel;
    private $path;

    public function __construct(string $classModel, string $path)
    {
        $this->wrappedModel = $classModel;
        $this->path = $path;
        parent::__construct([]);
    }

    public function getWrappedModel() : string
    {
        return $this->wrappedModel;
    }

    public function getPath() : string
    {
        return $this->path;
    }
}