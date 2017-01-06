<?php

namespace Fusonic\GraphBuilder;

class UnresolvedType
{
    public $fqcn;

    public function __construct($fqcn)
    {
        $this->fqcn = $fqcn;
    }
}
