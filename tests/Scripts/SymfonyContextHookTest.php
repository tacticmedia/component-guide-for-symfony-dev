<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Tests\Scripts;

use ComponentGuide\Tools\Tests\TemporaryDirectory;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

final class SymfonyContextHookTest extends TestCase
{
    use TemporaryDirectory;

    private const string LOCK = <<<'JSON'
        {
            "packages": [
                {
                    "name": "symfony/console",
                    "version": "v8.1.8"
                },
                {
                    "name": "symfony/polyfill-mbstring",
                    "version": "v1.43.0"
                },
                {
                    "name": "symfony/dependency-injection",
                    "version": "v8.1.8"
                },
                {
                    "name": "symfony/ux-turbo",
                    "version": "v3.5.1"
                }
            ],
            "packages-dev": [
                {
                    "name": "symfony/maker-bundle",
                    "version": "v1.68.0"
                }
            ]
        }
        JSON;

    #[TestDox('A console application without FrameworkBundle gets one line with the release lines from composer.lock')]
    public function testConsoleApplication(): void
    {
        $this->writeFile('composer.json', "{\n    \"require\": {\n        \"symfony/console\": \"^8.1\",\n        \"symfony/dependency-injection\": \"^8.1\"\n    }\n}\n");
        $this->writeFile('composer.lock', self::LOCK);

        self::assertSame(
            "This project uses Symfony packages (Symfony 8.1 (2 packages), Symfony UX 3.5 (1 package), symfony/maker-bundle 1.68 (1 package)). Before you write PHP code for a common need, use the component-guide-for-symfony skill: a Symfony package may already cover it.\n",
            $this->runHook(),
        );
    }

    #[TestDox('A Symfony package in "suggest" or "conflict" only gives no output')]
    public function testNoRequirement(): void
    {
        $this->writeFile('composer.json', '{"require": {"laravel/framework": "^13.0"}, "suggest": {"symfony/lock": "*"}, "conflict": {"symfony/symfony": "*"}}');

        self::assertSame('', $this->runHook());
    }

    #[TestDox('A require-dev entry in a subfolder of a monorepo counts')]
    public function testMonorepo(): void
    {
        $this->writeFile('backend/composer.json', '{"require-dev": {"symfony/var-dumper": "^8.1"}}');

        self::assertSame(
            "This project uses Symfony packages (backend: versions unknown, no composer.lock). Before you write PHP code for a common need, use the component-guide-for-symfony skill: a Symfony package may already cover it.\n",
            $this->runHook(),
        );
    }

    #[TestDox('composer.json files under vendor/ are ignored')]
    public function testVendorIgnored(): void
    {
        $this->writeFile('vendor/symfony/console/composer.json', '{"require": {"symfony/string": "^8.1"}}');

        self::assertSame('', $this->runHook());
    }

    #[TestDox('A project without composer.json gives no output')]
    public function testNoComposer(): void
    {
        $this->writeFile('package.json', '{}');

        self::assertSame('', $this->runHook());
    }

    private function runHook(): string
    {
        $process = new Process(['bash', \dirname(__DIR__, 2).'/hooks/symfony-context.sh'], null, ['CLAUDE_PROJECT_DIR' => $this->temporaryDirectory()]);
        $process->mustRun();

        return $process->getOutput();
    }
}
