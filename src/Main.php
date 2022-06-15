<?php

declare(strict_types=1);

namespace Crell\DumperBench;

class Main
{
    use Hydratable;

    public Sub $sub;

    /** @var Sub[] */
    public array $list;

    /**
     * @var array<string, Sub>
     */
    public array $dict;

    public Recurse $recurse;
}
