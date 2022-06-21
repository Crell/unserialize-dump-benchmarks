<?php

declare(strict_types=1);

namespace Crell\DumperBench;

trait Unserialize
{
    public function __unserialize(array $args): void
    {
        foreach ($args as $k => $v) {
            $this->$k = $v;
        }
    }
}
