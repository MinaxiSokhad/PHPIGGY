<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass, ReflectionNamedType;
use Framework\Exception\ContainerException;

class Container // create a container
{
    private array $definitions = [];
    private array $resolved = [];
    public function addDefinitions(array $newDefinitions)
    {
        //$this->definitions = array_merge($this->definitions, $newDefinitions);//array merge
        $this->definitions = [...$this->definitions, ...$newDefinitions]; //array merge
        // dd($this->definitions);
    }

    public function resolve(string $className) //reflaction API
    {
        $reflactionClass = new ReflectionClass($className); //reflaction class object
        if (!$reflactionClass->isInstantiable()) {
            throw new ContainerException("Class {$className} is not instantiable.");
        } //checking class can have an object or nott

        $constructor = $reflactionClass->getConstructor(); //check that class have constructor or not
        if (!$constructor) //if reflaction class have no constructor there are no dependencies
        {
            return new $className;
        }

        $params = $constructor->getParameters(); // it will return array of parameter -> controller class constructor parameter -> view as a parameter name 
        if (count($params) === 0) {
            return new $className;
        }
        $dependencies = [];
        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();
            if (!$type) {
                throw new ContainerException("Failed to resolve class {$className} because param {$name} is missing a type hint");
            }
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) //check the validation $type is a instance of reflactionNamedType class if not then parameter fails 
            {
                throw new ContainerException("Failed to resolve class {$className} because invalid param name");
            }
            $dependencies[] = $this->get($type->getName()); //invoking the factory function
        }
        return $reflactionClass->newInstanceArgs($dependencies); // newInstanceArgs -> create new instance of given argument -> with a single line of code create a new instance
        //instantiating a class with dependencies
        // dd($dependencies); //verify the instance was created -> the dependecies array contains the instance of template engine class -> with this instance we can pass it on to our controller
        //dd($params);
        //dd($constructor);
        //dd($reflactionClass);
    }
    public function get(string $id) //factory function
    {
        if (!array_key_exists($id, $this->definitions)) {
            throw new ContainerException("Class {$id} does not exist in container");
        }
        if (array_key_exists($id, $this->resolved)) {
            return $this->resolved[$id];
        }
        $factory = $this->definitions[$id];
        $dependency = $factory();
        $this->resolved[$id] = $dependency;
        return $dependency;
    }
}
