<?php

declare(strict_types=1);

$webRuns = 1000;

/**
 * Gets just the time/request value out of ab's output.
 *
 * @return string
 */
function abfilter(): string
{
    $data = file_get_contents('temp.txt');
    $lines = explode(PHP_EOL, $data);
    $parts = explode(' ', $lines[21]);
    $parts = array_reverse($parts);
    return $parts[2];
}

$tests = [
    ['s' => 1, 'r' => 1],
    ['s' => 5, 'r' => 5],
    ['s' => 10, 'r' => 10],
    ['s' => 50, 'r' => 50],
    ['s' => 100, 'r' => 100],
    ['s' => 500, 'r' => 500],
    ['s' => 1000, 'r' => 500],
    ['s' => 2000, 'r' => 500],
    ['s' => 3000, 'r' => 500],
    ['s' => 4000, 'r' => 500],
    ['s' => 5000, 'r' => 500],
    ['s' => 6000, 'r' => 500],
    ['s' => 7000, 'r' => 500],
    ['s' => 8000, 'r' => 500],
    ['s' => 9000, 'r' => 500],
    ['s' => 10000, 'r' => 500],
];

foreach ($tests as $rule) {
    $subItems = $rule['s'];
    $recursion = $rule['r'];
    foreach ([1] as $concurrency) {
        $totalItems = $subItems * 2 + $recursion + 1;
        shell_exec("SUB_ITEMS={$subItems} RECURSION={$recursion} php setup-serialized.php");

        shell_exec("ab -n {$webRuns} -c ${concurrency} -d -q  http://dumpbench.lndo.site/require.php 2>&1 > temp.txt");
        $time = abfilter();
        print "require(), $subItems, $recursion, $totalItems, $concurrency, $time \n";
        $results[$concurrency][$totalItems]['require()'] = $time;
    }
}

print "--------------------\n";

foreach ($results as $concurrency => $data) {
    foreach ($data as $totalItems => $data2) {
        print "$totalItems, {$data2['require()']}\n";
    }
}
