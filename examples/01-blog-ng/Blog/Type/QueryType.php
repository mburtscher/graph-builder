<?php
namespace GraphQL\Examples\BlogNg\Type;

use Doctrine\Common\Annotations\AnnotationReader;
use Fusonic\GraphBuilder\TypeBuilder;
use GraphQL\Examples\BlogNg\AppContext;
use GraphQL\Examples\BlogNg\Data\Comment;
use GraphQL\Examples\BlogNg\Data\DataSource;
use GraphQL\Examples\BlogNg\Data\Image;
use GraphQL\Examples\BlogNg\Data\Story;
use GraphQL\Examples\BlogNg\Data\User;
use GraphQL\Examples\BlogNg\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $typeBuilder = TypeBuilder::create();

        $config = [
            'name' => 'Query',
            'fields' => [
                'user' => [
                    'type' => $typeBuilder->fromClass(User::class),
                    'description' => 'Returns user by id (in range of 1-5)',
                    'args' => [
                        'id' => Type::nonNull(Type::id())
                    ]
                ],
                'viewer' => [
                    'type' => $typeBuilder->fromClass(User::class),
                    'description' => 'Represents currently logged-in user (for the sake of example - simply returns user with id == 1)'
                ],
                'stories' => [
                    'type' => Type::listOf($typeBuilder->fromClass(Story::class)),
                    'description' => 'Returns subset of stories posted for this blog',
                    'args' => [
                        'after' => [
                            'type' => Type::id(),
                            'description' => 'Fetch stories listed after the story with this ID'
                        ],
                        'limit' => [
                            'type' => Type::int(),
                            'description' => 'Number of stories to be returned',
                            'defaultValue' => 10
                        ]
                    ]
                ],
                'lastStoryPosted' => [
                    'type' => $typeBuilder->fromClass(Story::class),
                    'description' => 'Returns last story posted for this blog'
                ],
                'deprecatedField' => [
                    'type' => Type::string(),
                    'deprecationReason' => 'This field is deprecated!'
                ],
                'fieldWithException' => [
                    'type' => Type::string(),
                    'resolve' => function() {
                        throw new \Exception("Exception message thrown in field resolver");
                    }
                ],
                'hello' => Type::string()
            ],
            'resolveField' => function($val, $args, $context, ResolveInfo $info) {
                return $this->{$info->fieldName}($val, $args, $context, $info);
            }
        ];
        parent::__construct($config);
    }

    public function user($rootValue, $args)
    {
        return DataSource::findUser($args['id']);
    }

    public function viewer($rootValue, $args, AppContext $context)
    {
        return $context->viewer;
    }

    public function stories($rootValue, $args)
    {
        $args += ['after' => null];
        return DataSource::findStories($args['limit'], $args['after']);
    }

    public function lastStoryPosted()
    {
        return DataSource::findLatestStory();
    }

    public function hello()
    {
        return 'Your graphql-php endpoint is ready! Use GraphiQL to browse API';
    }

    public function deprecatedField()
    {
        return 'You can request deprecated field, but it is not displayed in auto-generated documentation by default.';
    }
}
