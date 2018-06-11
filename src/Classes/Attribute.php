<?php

namespace Wasi\SDK\Classes;

class Attribute
{
    const INTEGER = 0;
    const STRING = 1;

    private $type;

    public function __construct(int $type)
    {
        $this->type = $type;
    }

    public function getType() : int
    {
        return $this->type;
    }
}