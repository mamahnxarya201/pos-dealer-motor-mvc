<?php

namespace Router\Attributes;

use Attribute;

#[Attribute]
class Prefix
{
    public function __construct(public string $path)
    {
    }
}