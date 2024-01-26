<?php

namespace Core\ServiceContainer;

class ServiceContainer
{
    public function resolve($class)
    {
        $reflectionClass = new  \ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();

        if($constructor)
        {
            $parameters = $constructor->getParameters();
            $dependencies = [];

            foreach ($parameters as $parameter)
            {
                $dependencyClass = $parameter->getType()->getName();
                $dependencies[] = $this->resolve($dependencyClass);

            }
            return $reflectionClass->newInstanceArgs($dependencies);
        }

        $methods = $reflectionClass->getMethods();

        foreach($methods as $method)
        {
            if($method->getName() !== "__construct")
            {
                $this->resolveMethod($class, $method->getName());
            }
        }

        return new $class();
    }

    public function resolveMethod($class, string $method)
    {
        if(method_exists($class, $method)){

            $reflectionMethod = new \ReflectionMethod($class, $method);
            $parameters = $reflectionMethod->getParameters();
            $dependencies = [];

            foreach ($parameters as $parameter)
            {
                if($parameter->getType())
                {
                    $dependencyClass = $parameter->getType()->getName();
                    $dependencies[] = $this->resolve($dependencyClass);
                }
            }

            return $dependencies;
        }

        throw new \Exception("This method named $method does not exist in class $class");
    }
}