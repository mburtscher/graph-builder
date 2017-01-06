<?php

namespace Fusonic\GraphBuilder\Metadata;

use Doctrine\Common\Annotations\AnnotationReader;
use Fusonic\GraphBuilder\Annotations\Enum;
use Fusonic\GraphBuilder\Annotations\Id;
use GraphQL\Type\Definition\Type;
use GraphQL\Utils\TypeInfo;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\DocBlockFactory;

final class DefaultMetadataExtractor implements MetadataExtractorInterface
{
    private $annotationReader;
    private $docBlockFactory;
    private $fqcnResolver;

    private $internalTypeMapping = [
        "int" => Type::INT,
        "float" => Type::FLOAT,
        "bool" => Type::BOOLEAN,
        "boolean" => Type::BOOLEAN,
        "string" => Type::STRING,
    ];

    public function __construct(
        AnnotationReader $annotationReader
    ) {
        $this->annotationReader = $annotationReader;
        $this->docBlockFactory = DocBlockFactory::createInstance();
        $this->fqcnResolver = new FqcnResolver();
    }

    function getClassMetadata(\ReflectionClass $class): ClassMetadata
    {
        return new ClassMetadata(
            $class,
            $this->resolveClassName($class),
            $this->resolveClassDescription($class),
            $this->resolveClassKind($class)
        );
    }

    private function resolveClassKind(\ReflectionClass $class): ?string
    {
        if ($class->isInterface()) {
            return Kind::INTERFACE;
        } elseif (count($class->getConstants()) > 0) {
            return Kind::ENUM;
        }

        return Kind::OBJECT;
    }

    private function resolveClassName(\ReflectionClass $class): ?string
    {
        return null;
    }

    private function resolveClassDescription(\ReflectionClass $class): ?string
    {
        if ($comment = $class->getDocComment()) {
            return $this->getDocBlock($comment)->getSummary();
        }

        return null;
    }

    function getPropertyMetadata(\ReflectionProperty $property): PropertyMetadata
    {
        return new PropertyMetadata(
            $property,
            $this->resolvePropertyType($property),
            $this->resolvePropertyDescription($property),
            $this->resolvePropertyDeprecationReason($property)
        );
    }

    private function resolvePropertyType(\ReflectionProperty $property): ?TypeInformation
    {
        $idAttribute = $this->annotationReader->getPropertyAnnotation($property, Id::class);
        if ($idAttribute != null) {
            return new TypeInformation(Type::ID);
        }

        /** @var Enum $enumAttribute */
        $enumAttribute = $this->annotationReader->getPropertyAnnotation($property, Enum::class);
        if ($enumAttribute != null) {
            return new TypeInformation($enumAttribute->getType());
        }

        // Extract @var tag
        if (preg_match('/@var\s+([^\s\[]+)((\[\])?)/', $property->getDocComment(), $matches)) {
            list(, $type, $listModifier) = $matches;

            if (isset($this->internalTypeMapping[$type])) {
                $typeName = $this->internalTypeMapping[$type];
            } else {
                $typeName = $this->fqcnResolver->tryResolveFqn($type, $property->getDeclaringClass(), $property);
            }

            return new TypeInformation($typeName, $listModifier == "[]");
        }

        return null;
    }

    private function resolvePropertyDescription(\ReflectionProperty $property): ?string
    {
        if ($comment = $property->getDocComment()) {
            return $this->getDocBlock($comment)->getSummary();
        }

        return null;
    }

    private function resolvePropertyDeprecationReason(\ReflectionProperty $property): ?string
    {
        if ($comment = $property->getDocComment()) {
            return $this->getTagContent($comment, "deprecated");
        }

        return null;
    }

    private function getDocBlock($comment): DocBlock
    {
        return $this->docBlockFactory->create($comment);
    }

    private function getTagContent($comment, $tagName): ?string
    {
        $tags = $this->getDocBlock($comment)->getTagsByName($tagName);

        if (count($tags) > 0) {
            return trim((string)$tags[0]);
        }

        return null;
    }
}
