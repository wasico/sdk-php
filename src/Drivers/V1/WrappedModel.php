<?php

namespace Wasi\SDK\Drivers\V1;

use Wasi\SDK\Models\Model;

class WrappedModel extends Model
{
    private $wrappedModel;
    private $path;
    private $objectGet;

    public function __construct(string $classModel, string $path, bool $objectGet = false)
    {
        $this->wrappedModel = $classModel;
        $this->path = $path;
        $this->objectGet = $objectGet;
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

    public function isObjectGet() : bool
    {
        return $this->objectGet;
    }
}