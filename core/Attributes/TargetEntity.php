<?php

namespace Core\Attributes;

use Attribute;

#[Attribute]
class TargetEntity
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}