<?php

declare(strict_types=1);

namespace Crell\DumperBench;

trait ConstructorHydratable
{
    public static function __set_state(array $data): self
    {
        return new self(...$data);
    }
}
