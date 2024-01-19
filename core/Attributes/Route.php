<?php

namespace Core\Attributes;

#[\Attribute]
class Route
{
    private string $uri;

    private string $name;

    private array $methods;

    public function __construct(string $uri, string $name, array $methods)
    {
        $this->uri = $uri;
        $this->name = $name;
        $this->methods = $methods;
    }
}