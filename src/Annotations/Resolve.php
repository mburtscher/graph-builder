<?php

namespace Fusonic\GraphBuilder\Annotations;

/**
 * @Annotation
 */
final class Resolve
{
    private $className;
    private $methodName;

    public function __construct(array $args)
    {
        $this->className = $args["class"];
        $this->methodName = $args["method"];
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }

    public function getClass(): \ReflectionClass
    {
        return new \ReflectionClass($this->className);
    }

    public function getMethod(): \ReflectionMethod
    {
        return new \ReflectionMethod($this->className, $this->methodName);
    }
}
