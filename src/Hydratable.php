<?php

declare(strict_types=1);

namespace Crell\DumperBench;

trait Hydratable
{
    public static function __set_state(array $data): static
    {
        static $reflector;
        $reflector ??= new \ReflectionClass(static::class);
        $new = $reflector->newInstanceWithoutConstructor();
        foreach ($data as $k => $v) {
            $new->$k = $v;
        }
        return $new;
    }
}
