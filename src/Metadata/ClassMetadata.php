<?php

namespace Fusonic\GraphBuilder\Metadata;

final class ClassMetadata
{
    private $class;
    private $name;
    private $description;
    private $kind;

    public function __construct(
        \ReflectionClass $class,
        ?string $name,
        ?string $description,
        ?string $kind
    ) {
        $this->class = $class;
        $this->name = $name;
        $this->description = $description;
        $this->kind = $kind;
    }

    public function getClass(): \ReflectionClass
    {
        return $this->class;
    }

    public function getName(): string
    {
        return $this->name ?: $this->class->getShortName();
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getKind(): ?string
    {
        return $this->kind;
    }
}
