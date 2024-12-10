<?php

namespace Router\Attributes;

use Attribute;

#[Attribute]
class GET
{
    public function __construct(public string $path)
    {
    }
}