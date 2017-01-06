<?php

namespace Fusonic\GraphBuilder\Metadata;

use Fusonic\GraphBuilder\Exceptions\TypeException;
use Fusonic\GraphBuilder\TypeBuilder;
use GraphQL\Type\Definition\Type;

final class TypeInformation
{
    private $typeName;
    private $isList;

    public function __construct(string $typeName, bool $isList = false)
    {
        $this->typeName = $typeName;
        $this->isList = $isList;
    }

    public function instantiate(TypeBuilder $builder): Type
    {
        if ($this->typeName === null) {
            return null;
        } elseif (class_exists($this->typeName)) {
            $type = $builder->fromClass($this->typeName);
        } else {
            $type = Type::getInternalTypes()[$this->typeName];
        }

        if ($type === null) {
            throw new TypeException("'{$this->typeName}' is neither a class nor an internal type.");
        }

        if ($this->isList) {
            return Type::listOf($type);
        }

        return $type;
    }
}
