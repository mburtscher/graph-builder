<?php

namespace GraphQL\Examples\BlogNg;

use GraphQL\Examples\BlogNg\Data\User;

class Service
{
    public function resolveUserPhoto(User $value, AppContext $context, int $someShit)
    {
        return null;
    }
}
