<?php

namespace Fusonic\GraphBuilder\Metadata;

interface MetadataExtractorInterface
{
    /**
     * @param \ReflectionProperty $property
     * @return PropertyMetadata
     */
    function getPropertyMetadata(\ReflectionProperty $property): PropertyMetadata;

    /**
     * @param \ReflectionClass $class
     * @return ClassMetadata
     */
    function getClassMetadata(\ReflectionClass $class): ClassMetadata;
}