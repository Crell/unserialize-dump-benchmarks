<?php

declare(strict_types=1);

namespace Crell\DumperBench;

class Recurse
{
    public function __construct(
        public int $i,
        public ?Recurse $next = null,
    ) {
    }
}