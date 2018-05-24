<?php

namespace Wasi\SDK\Classes;

class Attribute
{
    const INTEGER = 0;
    const STRING = 1;

    private $name;
    private $type;

    public function __construct(string $name, int $type)
    {
        $this->name = $name;
        $this->type = $type;
    }
}