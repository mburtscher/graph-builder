<?php
namespace GraphQL\Examples\BlogNg\Data;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Utils;

class Comment
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
     * @var Story
     */
    public $story;

    /**
     * @var Comment
     */
    public $parent;

    /**
     * @var string
     */
    public $body;

    /**
     * @var bool
     */
    public $isAnonymous;
}
