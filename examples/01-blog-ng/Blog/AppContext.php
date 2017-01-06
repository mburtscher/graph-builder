<?php
namespace GraphQL\Examples\BlogNg;

use GraphQL\Examples\BlogNg\Data\DataSource;
use GraphQL\Examples\BlogNg\Data\User;
use GraphQL\Utils;

/**
 * Class AppContext
 * Instance available in all GraphQL resolvers as 3rd argument
 *
 * @package GraphQL\Examples\Blog
 */
class AppContext
{
    /**
     * @var string
     */
    public $rootUrl;

    /**
     * @var User
     */
    public $viewer;

    /**
     * @var \mixed
     */
    public $request;
}
