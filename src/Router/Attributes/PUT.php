<?php

namespace Router\Attributes;

use Attribute;

#[Attribute]
class PUT
{
    public function __construct(public string $path)
    {
    }
}