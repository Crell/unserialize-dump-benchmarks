<?php

declare(strict_types=1);

namespace Crell\DumperBench\Benchmarks;

use Crell\DumperBench\Main;
use Crell\DumperBench\Recurse;
use Crell\DumperBench\Sub;

trait Makers
{

    protected int $counter = 1;

    protected function makeMain(int $subItems, int $recursion): Main
    {
        $main = new Main();
        $main->sub = new Sub($this->counter++, uniqid('bench_'));
        $main->list = $this->makeSubs($subItems);
        $main->dict = $this->makeSubsDict($subItems);
        $main->recurse = $this->makeRecurse($recursion);

        return $main;
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
}
