<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Tests\Scripts;

use ComponentGuide\Tools\Tests\TemporaryDirectory;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

final class AuditScriptsTest extends TestCase
{
    use TemporaryDirectory;

    #[TestDox('The inventory lists source files with bytes and lines, and skips dependencies, builds and env files')]
    public function testInventory(): void
    {
        $this->writeFile('project/src/Lock.php', "<?php\n\nfinal class Lock {}");
        $this->writeFile('project/templates/base.html.twig', "<html>\n</html>\n");
        $this->writeFile('project/vendor/acme/Lib.php', "<?php\n");
        $this->writeFile('project/public/build/app.js', "x\n");
        $this->writeFile('project/assets/app.min.js', "x\n");
        $this->writeFile('project/.env', "SECRET=x\n");
        $this->writeFile('project/README.md', "# Readme\n");

        $output = $this->runScript('inventory.sh', [$this->runDirectory()]);

        self::assertSame("files=2 lines=5 bytes=41 approx_tokens=10\nbatches=1\n", $output);
        self::assertSame("src/Lock.php\t26\t3\ntemplates/base.html.twig\t15\t2\n", file_get_contents($this->runDirectory().'/inventory.tsv'));
        self::assertSame("1\tsrc/Lock.php\n1\ttemplates/base.html.twig\n", file_get_contents($this->runDirectory().'/batches.tsv'));
    }

    #[TestDox('A batch closes before the byte limit, and a large file gets its own batch')]
    public function testBatching(): void
    {
        $this->writeFile('project/a.php', str_repeat('a', 60));
        $this->writeFile('project/b.php', str_repeat('b', 60));
        $this->writeFile('project/c.php', str_repeat('c', 300));
        $this->writeFile('project/d.php', str_repeat('d', 10));

        $this->runScript('inventory.sh', [$this->runDirectory()], ['AUDIT_BATCH_BYTES' => '100']);

        self::assertSame("1\ta.php\n2\tb.php\n3\tc.php\n4\td.php\n", file_get_contents($this->runDirectory().'/batches.tsv'));
    }

    #[TestDox('The inventory accepts paths that limit the scope')]
    public function testInventoryPaths(): void
    {
        $this->writeFile('project/src/A.php', "<?php\n");
        $this->writeFile('project/tests/ATest.php', "<?php\n");

        $this->runScript('inventory.sh', [$this->runDirectory(), 'src']);

        self::assertSame("src/A.php\t6\t1\n", file_get_contents($this->runDirectory().'/inventory.tsv'));
    }

    #[TestDox('The inventory skips earlier audit runs and the Claude Code folder')]
    public function testInventorySkipsAuditRuns(): void
    {
        $this->writeFile('project/src/A.php', "<?php\n");
        $this->writeFile('project/.component-slop-audit-for-symfony/20261013-000000/catalogue/x.php', "<?php\n");
        $this->writeFile('project/.claude/agents/x.php', "<?php\n");

        $this->runScript('inventory.sh', [$this->runDirectory()]);

        self::assertSame("src/A.php\t6\t1\n", file_get_contents($this->runDirectory().'/inventory.tsv'));
    }

    #[TestDox('prepare copies the catalogue, the templates and the references into the run directory')]
    public function testPrepare(): void
    {
        $this->writeCatalogue();
        $this->writeFile('skill/templates/batch.md', "# Batch\n");
        $this->writeFile('skill/templates/plan.md', "# Plan\n");
        $this->writeFile('skill/references/code-reader.md', "# Code reader\n");
        $this->writeFile('project/.keep', '');

        $output = $this->runScript('prepare.sh', [$this->runDirectory(), $this->temporaryDirectory().'/catalogue', $this->temporaryDirectory().'/skill']);

        self::assertSame(sprintf("run_directory=%s packages=1 templates=2 references=1\n", $this->runDirectory()), $output);
        self::assertFileEquals($this->temporaryDirectory().'/catalogue/details/lock.md', $this->runDirectory().'/catalogue/details/lock.md');
        self::assertFileEquals($this->temporaryDirectory().'/skill/templates/plan.md', $this->runDirectory().'/templates/plan.md');
        self::assertFileEquals($this->temporaryDirectory().'/skill/references/code-reader.md', $this->runDirectory().'/references/code-reader.md');
        self::assertDirectoryExists($this->runDirectory().'/plans');
    }

    #[TestDox('prepare refuses a catalogue folder without SKILL.md')]
    public function testPrepareRejectsWrongCatalogue(): void
    {
        $this->writeFile('skill/templates/batch.md', "# Batch\n");
        $this->writeFile('skill/references/code-reader.md', "# Code reader\n");
        $this->writeFile('project/.keep', '');

        self::assertSame(2, $this->prepare($this->temporaryDirectory().'/missing', $this->temporaryDirectory().'/skill')->getExitCode());
        self::assertDirectoryDoesNotExist($this->runDirectory());
    }

    #[TestDox('prepare refuses a skill folder without templates/ or references/')]
    public function testPrepareRejectsWrongSkill(): void
    {
        $this->writeCatalogue();
        $this->writeFile('skill/templates/batch.md', "# Batch\n");
        $this->writeFile('project/.keep', '');

        self::assertSame(2, $this->prepare($this->temporaryDirectory().'/catalogue', $this->temporaryDirectory().'/skill')->getExitCode());
        self::assertDirectoryDoesNotExist($this->runDirectory());
    }

    #[TestDox('Coverage passes when each file was read to its last line')]
    public function testCoverageComplete(): void
    {
        $this->writeFile('run/inventory.tsv', "src/A.php\t10\t3\nsrc/Empty.php\t0\t0\n");
        $this->writeFile('run/read-1.tsv', "src/A.php\t3\n");
        $this->writeFile('run/read-2.tsv', "src/Empty.php\t0\n");

        $process = $this->coverage();

        self::assertSame(0, $process->getExitCode());
        self::assertSame("files=2 read=2 missing=0 partial=0\n", $process->getOutput());
    }

    #[TestDox('Coverage fails and lists the missing and the partly read files')]
    public function testCoverageGaps(): void
    {
        $this->writeFile('run/inventory.tsv', "src/A.php\t10\t300\nsrc/B.php\t10\t5\nsrc/C.php\t10\t2\n");
        $this->writeFile('run/read-1.tsv', "src/A.php\t200\nsrc/C.php\t2\n");

        $process = $this->coverage();

        self::assertSame(1, $process->getExitCode());
        self::assertSame("files=3 read=1 missing=1 partial=1\n", $process->getOutput());
        self::assertSame("src/A.php\tpartial\t200\t300\nsrc/B.php\tmissing\t0\t5\n", file_get_contents($this->temporaryDirectory().'/run/gaps.tsv'));
    }

    #[TestDox('A second read log can close the gap of a partly read file')]
    public function testCoverageRereadClosesGap(): void
    {
        $this->writeFile('run/inventory.tsv', "src/A.php\t10\t300\n");
        $this->writeFile('run/read-1.tsv', "src/A.php\t200\n");
        $this->writeFile('run/read-9.tsv', "src/A.php\t300\n");

        self::assertSame(0, $this->coverage()->getExitCode());
    }

    private function runDirectory(): string
    {
        return $this->temporaryDirectory().'/run';
    }

    private function writeCatalogue(): void
    {
        $this->writeFile('catalogue/SKILL.md', "# Skill\n");
        $this->writeFile('catalogue/packages/lock.md', "# Lock\n");
        $this->writeFile('catalogue/details/lock.md', "# Lock: details\n");
    }

    private function prepare(string $catalogue, string $skill): Process
    {
        $process = new Process(['bash', self::scriptPath('prepare.sh'), $this->runDirectory(), $catalogue, $skill], $this->temporaryDirectory().'/project');
        $process->run();

        return $process;
    }

    /**
     * @param list<string>          $arguments
     * @param array<string, string> $environment
     */
    private function runScript(string $script, array $arguments, array $environment = []): string
    {
        $process = new Process(['bash', self::scriptPath($script), ...$arguments], $this->temporaryDirectory().'/project', $environment);
        $process->mustRun();

        return $process->getOutput();
    }

    private function coverage(): Process
    {
        $process = new Process(['bash', self::scriptPath('coverage.sh'), $this->temporaryDirectory().'/run']);
        $process->run();

        return $process;
    }

    private static function scriptPath(string $script): string
    {
        return \dirname(__DIR__, 2).'/skills/component-slop-audit-for-symfony/scripts/'.$script;
    }
}
