<?php

namespace GraphQL\Examples\BlogNg\Data;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Utils;
use Fusonic\GraphBuilder\Annotations as Graph;

/**
 * Das hier ist ein Benutzer…
 */
class User
{
    /**
     * @Graph\Id
     *
     * @var int
     */
    public $id;

    /**
     * Das ist die E-Mail Adresse des Users *woot*.
     *
     * @var string
     */
    public $email;

    /**
     * @var string
     *
     * @deprecated Do not use the user's first name anymore! Use `fullName` property instead.
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

    /**
     * @Graph\Resolve(class = \GraphQL\Examples\BlogNg\Service::class, method = "resolveUserPhoto")
     *
     * @var Image
     */
    public $photo;
}
