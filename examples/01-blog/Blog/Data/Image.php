<?php
namespace GraphQL\Examples\Blog\Data;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Utils;

class Image extends ObjectType
{
    const TYPE_USERPIC = 'userpic';

    const SIZE_ICON = 'icon';
    const SIZE_SMALL = 'small';
    const SIZE_MEDIUM = 'medium';
    const SIZE_ORIGINAL = 'original';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $size;

    /**
     * @var int
     */
    public $width;

    /**
     * @var int
     */
    public $height;

    public function __construct(array $config)
    {
        parent::__construct($config);
    }
}
