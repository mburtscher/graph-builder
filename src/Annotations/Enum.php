<?php

namespace Fusonic\GraphBuilder\Annotations;

/**
 * @Annotation
 */
final class Enum
{
    private $type;

    public function __construct(array $args)
    {
        $this->type = $args["value"];
    }

    public function getType(): string
    {
        return $this->type;
    }
}
