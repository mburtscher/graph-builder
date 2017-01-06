<?php

namespace Fusonic\GraphBuilder;

use Doctrine\Common\Annotations\AnnotationReader;
use Fusonic\GraphBuilder\Annotations\Resolve;
use Fusonic\GraphBuilder\Metadata\ClassMetadata;
use Fusonic\GraphBuilder\Metadata\DefaultMetadataExtractor;
use Fusonic\GraphBuilder\Metadata\Kind;
use Fusonic\GraphBuilder\Metadata\MetadataExtractorInterface;
use GraphQL\Examples\BlogNg\AppContext;
use GraphQL\Type\Definition\EnumType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class TypeBuilder
{
    public static function create()
    {
        $annotationReader = new AnnotationReader();
        $metadataExtractor = new DefaultMetadataExtractor($annotationReader);

        return new self($annotationReader, $metadataExtractor);
    }

    private $resolvedClasses = [ ];

    private $annotationReader;
    private $metadataExtractor;

    public function __construct(
        AnnotationReader $annotationReader,
        MetadataExtractorInterface $metadataExtractor
    ) {
        $this->annotationReader = $annotationReader;
        $this->metadataExtractor = $metadataExtractor;
    }

    /**
     * @param $fqcn
     *
     * @return ObjectType
     */
    public function fromClass($fqcn)
    {
        if (!isset($this->resolvedClasses[$fqcn])) {
            $this->resolvedClasses[$fqcn] = $this->resolveClass($fqcn);
        }

        return $this->resolvedClasses[$fqcn];
    }

    private function resolveClass($fqcn)
    {
        $reflectionClass = new \ReflectionClass($fqcn);
        $classMetadata = $this->metadataExtractor->getClassMetadata($reflectionClass);

        switch ($classMetadata->getKind()) {
            case Kind::INTERFACE:
                return $this->resolveInterface($classMetadata);
            case Kind::ENUM:
                return $this->resolveEnum($classMetadata);
            case Kind::OBJECT:
                return $this->resolveObject($classMetadata);
        }
    }

    private function resolveObject(ClassMetadata $class)
    {
        $reflectionClass = $class->getClass();

        $config = [
            "name" => $class->getName(),
            "description" => $class->getDescription(),
            "fields" => function () use ($reflectionClass) {
                return $this->resolveFields($reflectionClass);
            }
        ];

        return new ObjectType($config);
    }

    private function resolveInterface(ClassMetadata $class)
    {

    }

    private function resolveEnum(ClassMetadata $class)
    {
        $values = [];
        foreach ($class->getClass()->getConstants() as $key => $value) {
            $values[$key] = $value;
        }

        $config = [
            "name" => $class->getName(),
            "description" => $class->getDescription(),
            "values" => $values,
        ];

        return new EnumType($config);
    }

    private function resolveFields(\ReflectionClass $class)
    {
        $result = [];

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $metadata = $this->metadataExtractor->getPropertyMetadata($property);

            if (!$metadata->hasTypeInformation()) {
                throw new \Exception("Could not determine type for '{$property->getDeclaringClass()->getName()}::{$property->getName()}'.");
            }

            $config = [
                "type" => $metadata->getTypeInformation()->instantiate($this),
                "description" => $metadata->getDescription(),
                "deprecationReason" => $metadata->getDeprecationReason(),
            ];

            /** @var Resolve $resolveAnnotation */
            $resolveAnnotation = $this->annotationReader->getPropertyAnnotation($property, Resolve::class);
            if ($resolveAnnotation != null) {
                $resolveMethod = $resolveAnnotation->getMethod();

                // Find arguments
                $args = [];
                foreach ($resolveMethod->getParameters() as $parameter) {
                    if ($parameter->getClass() != null) {
                        if ($parameter->getClass()->getName() == AppContext::class ||
                            $parameter->getClass()->getName() == $class->getName()) {
                            continue;
                        }
                    }

                    $args[$parameter->getName()] = [
                        "type" => Type::string(),
                    ];
                }
                $config["args"] = $args;

                // Register call to method
                $config["resolve"] = function ($obj, $args, AppContext $context) use ($class, $resolveMethod) {
                    return $this->invokeMethod($class, $resolveMethod, $this->mapArgsToMethodArgs($obj, $args, $context, $resolveMethod));
                };
            }

            $result[$property->getName()] = $config;
        }

        return $result;
    }

    private function mapArgsToMethodArgs($obj, $args, AppContext $context, \ReflectionMethod $method)
    {
        $res = [];

        foreach ($method->getParameters() as $parameter) {
            $res[$parameter->getName()] = null;
        }

        return $res;
    }

    private function invokeMethod(\ReflectionClass $class, \ReflectionMethod $method, array $args)
    {
        if ($method->isStatic()) {
            return $method->invokeArgs(null, $args);
        } else {
            return $method->invokeArgs($this->instantiate($class), $args);
        }
    }

    private function instantiate(\ReflectionClass $class)
    {
        return $class->newInstance();
    }

}
