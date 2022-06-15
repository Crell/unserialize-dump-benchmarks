<?php

declare(strict_types=1);

namespace Crell\DumperBench;

class Sub
{
    use ConstructorHydratable;

    public function __construct(
        public readonly int $i,
        public readonly string $s = 'dummy',
    ) {
    }
}
