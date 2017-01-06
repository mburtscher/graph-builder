<?php

use Fusonic\GraphBuilder\TypeBuilder;
use GraphQL\Examples\BlogNg\Data\Comment;
use GraphQL\Examples\BlogNg\Data\Story;
use GraphQL\Examples\BlogNg\Data\User;

require __DIR__ . "/../../vendor/autoload.php";

$typeBuilder = new TypeBuilder();

echo "<pre>";
print_r($typeBuilder->fromClass(Story::class)->getFields());