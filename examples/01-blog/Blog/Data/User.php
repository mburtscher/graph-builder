<?php
namespace GraphQL\Examples\Blog\Data;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Utils;

class User extends ObjectType
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var bool
     */
    public $hasPhoto;

    public function __construct(array $config)
    {
        parent::__construct($config);
        //Utils::assign($this, $data);
    }
}
