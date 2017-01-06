<?php
namespace GraphQL\Examples\BlogNg\Data;

use Fusonic\GraphBuilder\Annotations as Graph;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Utils;

class Image
{
    /**
     * @var int
     */
    public $id;

    /**
     * @Graph\Enum(ImageType::class)
     * @var string
     */
    public $type;

    /**
     * @Graph\Enum(ImageSize::class)
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
}
