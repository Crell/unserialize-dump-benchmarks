<?php

declare(strict_types=1);

namespace Crell\DumperBench\Benchmarks;

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
    protected int $counter = 1;

    protected Main $main;

    protected static $subItems = 5000;
    protected static $recursion = 5000;

    public function setUp(): void
    {
        $main = new Main();
        $main->sub = new Sub($this->counter++, uniqid('bench_'));
        $main->list = $this->makeSubs(self::$subItems);
        $main->dict = $this->makeSubsDict(self::$subItems);
        $main->recurse = $this->makeRecurse(self::$recursion);

        $this->main = $main;


    }

    protected function makeRecurse(int $depth): Recurse
    {
        $r = new Recurse(5);
        for ($i = 0; $i < 5; ++$i) {
            $r = new Recurse($this->counter++, $r);
        }
        return $r;
    }

    protected function makeSubsDict(int $count): array
    {
        $list = [];
        for ($i=0; $i < $count; ++$i) {
            $list[uniqid('bench_')] = new Sub($this->counter++, uniqid('bench_'));
        }
        return $list;
    }

    protected function makeSubs(int $count): array
    {
        $list = [];
        for ($i=0; $i < $count; ++$i) {
            $list[] = new Sub($this->counter++, uniqid('bench_'));
        }
        return $list;
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

class Main
{
    public Sub $sub;

    /** @var Sub[] */
    public array $list;

    /**
     * @var array<string, Sub>
     */
    public array $dict;

    public Recurse $recurse;
}

class Sub
{
    public function __construct(
        public readonly int $i,
        public readonly string $s = 'dummy',
    ) {}
}

class Recurse
{
    public function __construct(
        public int $i,
        public ?Recurse $next = null,
    ) {}
}