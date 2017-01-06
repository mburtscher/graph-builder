<?php

namespace Fusonic\GraphBuilder\Metadata;

final class PropertyMetadata
{
    private $property;
    private $typeInformation;
    private $description;
    private $deprecationReason;

    public function __construct(
        \ReflectionProperty $property,
        ?TypeInformation $type,
        ?string $description,
        ?string $deprecationReason
    ) {
        $this->property = $property;
        $this->typeInformation = $type;
        $this->description = $description;
        $this->deprecationReason = $deprecationReason;
    }

    public function getProperty(): \ReflectionProperty
    {
        return $this->property;
    }

    public function getTypeInformation(): ?TypeInformation
    {
        return $this->typeInformation;
    }

    public function hasTypeInformation(): bool
    {
        return $this->typeInformation !== null;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDeprecationReason(): ?string
    {
        return $this->deprecationReason;
    }
}
