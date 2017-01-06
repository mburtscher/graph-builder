<?php
namespace GraphQL\Examples\Blog\Data;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Utils;

class Comment extends ObjectType
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $authorId;

    /**
     * @var int
     */
    public $storyId;

    /**
     * @var int
     */
    public $parentId;

    /**
     * @var string
     */
    public $body;

    /**
     * @var bool
     */
    public $isAnonymous;

    public function __construct(array $config)
    {
        parent::__construct($config);
    }
}
