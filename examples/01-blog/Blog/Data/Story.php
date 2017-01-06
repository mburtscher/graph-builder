<?php
namespace GraphQL\Examples\Blog\Data;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Utils;

class Story extends ObjectType
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

    public function __construct(array $data)
    {
        Utils::assign($this, $data);
    }
}
