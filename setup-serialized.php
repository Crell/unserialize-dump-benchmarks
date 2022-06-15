<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

class Run
{
    use \Crell\DumperBench\Benchmarks\Makers;

    protected string $serializedPath = './serialized';

    public function makeSerialized(int $subItems, int $recursion): void
    {
        $this->ensureDir();
        $main = $this->makeMain($subItems, $recursion);

        $serialized = serialize($main);
        file_put_contents($this->serializedPath . '/serialized.txt', $serialized);
    }

    public function makeVarDump(int $subItems, int $recursion): void
    {
        $this->ensureDir();
        $main = $this->makeMain($subItems, $recursion);

        $source = '<?php return ' . var_export($main, true) . ';' . PHP_EOL;

        file_put_contents($this->serializedPath . '/var_dump.php', $source);
    }

    private function ensureDir(): void
    {
        if (!is_dir($this->serializedPath)) {
            if (!mkdir($concurrentDirectory = $this->serializedPath, 0755, true) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }
    }
}

$r = new Run();
$r->makeSerialized(500, 500);
$r->makeVarDump(500, 500);
