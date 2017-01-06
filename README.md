fusonic/graph-builder
=====================

[![](https://scrutinizer-ci.com/g/mburtscher/graph-builder/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mburtscher/graph-builder/build-status/master)
[![](https://scrutinizer-ci.com/g/mburtscher/graph-builder/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mburtscher/graph-builder/?branch=master)
[![](https://poser.pugx.org/mburtscher/graph-builder/downloads.png)](https://packagist.org/packages/mburtscher/graph-builder)

`fusonic/graph-builder` is a library to generate GraphQL configurations for `webonyx/graphql-php` from POPOs (plain old
PHP objects). It uses reflection to get all metadata required to build the graph from your domain models. It does not
promote the use of entities in your graph but suggest using explicit DTOs (data-transfer objects).

**This library is under heavy development and its GitHub repository will be moved once it is completed. Please consult
the `examples/01-blog-ng` to see how it is used.
