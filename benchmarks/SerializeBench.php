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
class SerializeBench
{
    use Makers;

    protected Main $main;

    public function setUp(): void
    {
        $subItems = (int)getenv('SUB_ITEMS');
        $recursion = (int)getenv('RECURSION');

        $this->main = $this->makeMain($subItems, $recursion);
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

    public function benchUnserialize(): void
    {
        $main = unserialize(file_get_contents('./serialized/serialized.txt'));
        $a = $main->sub->i;
    }

    public function benchUnserializeClass(): void
    {
        $main = unserialize(file_get_contents('./serialized/serialized.txt'), ['allowed_classes' => [Main::class, Sub::class, Recurse::class]]);
        $a = $main->sub->i;
    }

    public function benchVarExportRequire(): void
    {
        $main = require './serialized/var_dump.php';
        $a = $main->sub->i;
    }

}

