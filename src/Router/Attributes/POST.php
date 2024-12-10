<?php

namespace Router\Attributes;

use Attribute;

#[Attribute]
class POST
{
    public function __construct(public string $path)
    {
    }
}