<?php

declare(strict_types=1);

require_once 'src/ConstructorHydratable.php';
require_once 'src/Hydratable.php';
require_once 'src/Sub.php';
require_once 'src/Recurse.php';
require_once 'src/Main.php';

$main = unserialize(file_get_contents('./serialized/serialized.txt'));

print "Memory peak usage: " . memory_get_peak_usage(true) . PHP_EOL;
