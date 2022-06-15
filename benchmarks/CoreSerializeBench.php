<?php

declare(strict_types=1);

namespace Crell\DumperBench\Benchmarks;

use Crell\DumperBench\Main;
use Crell\DumperBench\Recurse;
use Crell\DumperBench\Sub;
use PhpBench\Benchmark\Metadata\Annotations\AfterMethods;
use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\OutputTimeUnit;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use PhpBench\Benchmark\Metadata\Annotations\Warmup;

/**
 * @Revs(100)
 * @Iterations(10)
 * @Warmup(2)
 * @BeforeMethods({"setUp"})
 * @AfterMethods({"tearDown"})
 * @OutputTimeUnit("milliseconds", precision=3)
 */
class CoreSerializeBench
{
    use Makers;

    protected Main $main;

    public function setUp(): void
    {
        $this->main = $this->makeMain(500, 500);
    }


    public function tearDown(): void {}

    public function benchSerialize(): void
    {
        serialize($this->main);
    }

    public function benchVarExport(): void
    {
        var_export($this->main, true);
    }
}

