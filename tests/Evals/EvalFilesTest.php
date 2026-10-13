<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Tests\Evals;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

final class EvalFilesTest extends TestCase
{
    private const string EVALS = __DIR__.'/../../evals';

    #[TestDox('The fixture file $path has valid PHP syntax')]
    #[DataProvider('fixturePhpFiles')]
    public function testFixturePhpSyntax(string $path): void
    {
        $process = new Process([\PHP_BINARY, '-l', $path]);
        $process->run();

        self::assertTrue($process->isSuccessful(), $process->getOutput().$process->getErrorOutput());
    }

    #[TestDox('The scaffold script $path has valid Bash syntax')]
    #[DataProvider('scaffoldScripts')]
    public function testScaffoldSyntax(string $path): void
    {
        $process = new Process(['bash', '-n', $path]);
        $process->run();

        self::assertTrue($process->isSuccessful(), $process->getErrorOutput());
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function fixturePhpFiles(): iterable
    {
        yield from self::files('/\.php$/');
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function scaffoldScripts(): iterable
    {
        yield from self::files('/\/scaffold\.sh$/');
    }

    /**
     * @return iterable<string, array{string}>
     */
    private static function files(string $pattern): iterable
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(self::EVALS, \FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            \assert($file instanceof \SplFileInfo);
            $path = $file->getPathname();
            if (!str_contains($path, '/results/') && preg_match($pattern, $path)) {
                yield substr($path, \strlen(self::EVALS) + 1) => [$path];
            }
        }
    }
}
