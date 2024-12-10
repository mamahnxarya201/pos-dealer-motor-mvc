<?php
declare(strict_types=1);

namespace Router\Attributes;

use Attribute;

#[Attribute]
class DELETE
{
    public function __construct(public string $path) {}
}

