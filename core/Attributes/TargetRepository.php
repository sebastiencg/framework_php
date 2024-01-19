<?php

namespace Core\Attributes;

use Attribute;

#[Attribute]
class TargetRepository
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}