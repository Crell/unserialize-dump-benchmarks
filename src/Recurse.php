<?php

declare(strict_types=1);

namespace Crell\DumperBench;

class Recurse
{
    use ConstructorHydratable;
//    use Unserialize;

    public function __construct(
        public int $i,
        public ?Recurse $next = null,
    ) {
    }
}
