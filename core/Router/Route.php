<?php

namespace Core\Router;

class Route
{

    private string $uri;
    private string $controller;
    private string $method;
    private string $name;
    private array $methods;
    private array $uriData = [];

    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getController(): string
    {
        return $this->controller;
    }

    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function setMethods(array $methods): void
    {
        $this->methods = $methods;
    }

    public function getUriData(): array
    {
        return $this->uriData;
    }

    public function setUriData(array $uriData): void
    {
        $this->uriData = $uriData;
    }
}