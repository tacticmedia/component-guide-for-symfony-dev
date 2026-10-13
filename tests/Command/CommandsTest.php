<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Tests\Command;

use ComponentGuide\Tools\Command\CheckCommand;
use ComponentGuide\Tools\Command\RouterCommand;
use ComponentGuide\Tools\Command\SplitCommand;
use ComponentGuide\Tools\Tests\TemporaryDirectory;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\ApplicationTester;

final class CommandsTest extends TestCase
{
    use TemporaryDirectory;

    private const string SOURCE = <<<'MD'
        # Clock (`symfony/clock`)

        **Verified against:** symfony/clock v8.1.0 (2026-05-29), docs branch 8.1, on 2026-10-09.

        **Elevator pitch:** Use when code reads the current time and tests must freeze it. More.

        ## Why it exists
        Why.

        ## When to use it
        - When.

        ## Key features and concepts
        - Feature.

        ## Use it instead of
        - `time()` → `ClockInterface::now()`.

        ## Entry points
        - Without FrameworkBundle: `new NativeClock()`.
        MD;

    private const string INDEX = "# Catalogue\n\n## Groups\n\n- [Time](#time)\n\n## Time\n\n- [Clock](clock.md) (`symfony/clock`): Use when old text.\n";

    #[TestDox('split, router and check turn a source folder into a valid skill')]
    public function testSplitRouterCheck(): void
    {
        $source = \dirname($this->writeFile('source/clock.md', self::SOURCE));
        $this->writeFile('source/index.md', self::INDEX);
        $skill = $this->temporaryDirectory().'/skill';
        $this->writeFile('skill/SKILL.md', "---\nname: x\n---\n\n<!-- router:start -->\n<!-- router:end -->\n");

        self::assertSame(Command::SUCCESS, $this->runCatalogue('split', ['source' => $source, 'skill' => $skill, '--verification-record' => $skill.'/record.md']));
        self::assertSame(Command::SUCCESS, $this->runCatalogue('router', ['skill' => $skill, '--bootstrap' => $source.'/index.md']));
        self::assertSame(Command::SUCCESS, $this->runCatalogue('check', ['skill' => $skill]));

        self::assertStringContainsString('- [Clock](packages/clock.md) (`symfony/clock`): Use when code reads the current time and tests must freeze it.', (string) file_get_contents($skill.'/SKILL.md'));
        self::assertStringContainsString('| `clock` | symfony/clock v8.1.0 (2026-05-29), docs branch 8.1, on 2026-10-09. |', (string) file_get_contents($skill.'/record.md'));
    }

    #[TestDox('split refuses to overwrite edited files without --force')]
    public function testSplitRefusesOverwrite(): void
    {
        $source = \dirname($this->writeFile('source/clock.md', self::SOURCE));
        $this->writeFile('skill/packages/clock.md', 'edited');

        self::assertSame(Command::FAILURE, $this->runCatalogue('split', ['source' => $source, 'skill' => $this->temporaryDirectory().'/skill']));
        self::assertSame('edited', file_get_contents($this->temporaryDirectory().'/skill/packages/clock.md'));
    }

    #[TestDox('check fails when the router is stale')]
    public function testCheckFailsOnStaleRouter(): void
    {
        $source = \dirname($this->writeFile('source/clock.md', self::SOURCE));
        $this->writeFile('source/index.md', self::INDEX);
        $skill = $this->temporaryDirectory().'/skill';
        $this->writeFile('skill/SKILL.md', "---\nname: x\n---\n\n<!-- router:start -->\n<!-- router:end -->\n");
        $this->runCatalogue('split', ['source' => $source, 'skill' => $skill]);
        $this->runCatalogue('router', ['skill' => $skill, '--bootstrap' => $source.'/index.md']);
        file_put_contents($skill.'/packages/clock.md', str_replace('tests must freeze it', 'tests must move it', (string) file_get_contents($skill.'/packages/clock.md')));

        self::assertSame(Command::FAILURE, $this->runCatalogue('check', ['skill' => $skill]));
    }

    /**
     * @param array<string, string> $arguments
     */
    private function runCatalogue(string $command, array $arguments): int
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->addCommands([new SplitCommand(), new RouterCommand(), new CheckCommand()]);

        return new ApplicationTester($application)->run(['command' => $command, ...$arguments]);
    }
}
