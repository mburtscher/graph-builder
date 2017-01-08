fusonic/graph-builder
=====================

[![](https://scrutinizer-ci.com/g/mburtscher/graph-builder/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mburtscher/graph-builder/build-status/master)
[![](https://scrutinizer-ci.com/g/mburtscher/graph-builder/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mburtscher/graph-builder/?branch=master)
[![](https://poser.pugx.org/mburtscher/graph-builder/downloads.png)](https://packagist.org/packages/mburtscher/graph-builder)

`fusonic/graph-builder` is a library to generate GraphQL configurations for
[`webonyx/graphql-php`](https://github.com/webonyx/graphql-php) from POPOs (plain old PHP objects). It uses reflection
to get all metadata required to build the graph from your domain models. It does not promote the use of entities in your
graph but suggest using explicit DTOs (data-transfer objects).

**This library is under heavy development and its GitHub repository will be moved once it is completed. Please consult
the `examples/01-blog-ng` to see how it is used.**

## Why?

If you use the [`webonyx/graphql-php`](https://github.com/webonyx/graphql-php) library you will end up writing 

a) type definitions and
b) type implementations

for your graph scrambled together with data-retrieval code. We think that both type implementation and its metadata
should stay in one place (POPO with attributes) and should be separated from your data-retrieval logic. This library is
built on top of the concepts of [`webonyx/graphql-php`](https://github.com/webonyx/graphql-php) and offers an alternate
 approach to describe your graph.

## How?

PHPDoc is broadly used to define type information and metadata for classes and properties. Since you're writing these
comments on your implementations anyway, we utilize them to build your graph automatically.

```php
/**
 * A single post published by a user on his timeline.
 */
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
}

/**
 * Holds all information about a person using the system.
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
     * E-mail address used for sign-in and notifications.
     *
     * @var string
     */
    public $email;
}
```

There are also some annotations that should be used to provide information that cannot be inferred from PHPDoc:

* [Enum](src/Annotations/Enum.php): Placed on a property that uses an enum as its values.
* [Id](src/Annotations/Id.php): Placed on the ID property of an object.
* [Resolve](src/Annotations/Resolve.php): Specifying the service method to resolve a relation.

## License

See [LICENSE](LICENSE) file.
