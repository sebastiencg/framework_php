<?php

namespace Core\Http;

class Request
{
    private array $gobals;


    public function __construct()
    {
        $this->gobals = $_SERVER;
    }

    public function getGobals(): array
    {
        return $this->gobals;
    }
}