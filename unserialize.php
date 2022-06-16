<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

$main = unserialize(file_get_contents('./serialized/serialized.txt'));

print "Done";
