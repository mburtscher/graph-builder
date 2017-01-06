<?php

namespace GraphQL\Examples\BlogNg\Data;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Utils;

class Story
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var User
     */
    public $author;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $body;

    /**
     * @var bool
     */
    public $isAnonymous = false;

    /**
     * @var Comment[]
     */
    public $comments;
}
