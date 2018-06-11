<?php

namespace Wasi\SDK\Classes;

class Attribute
{
    const INTEGER = 0;
    const STRING = 1;
    const BOOLEAN = 2;

    private $type;
    private $editable;

    public function __construct(int $type, bool $editable = false)
    {
        $this->type = $type;
        $this->editable = $editable;
    }

    public function getType() : int
    {
        return $this->type;
    }
}