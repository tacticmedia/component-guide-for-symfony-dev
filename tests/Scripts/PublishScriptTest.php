<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Tests\Scripts;

use ComponentGuide\Tools\Tests\TemporaryDirectory;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

final class PublishScriptTest extends TestCase
{
    use TemporaryDirectory;

    private const array GIT_ENVIRONMENT = ['GIT_CONFIG_GLOBAL' => '/dev/null', 'GIT_CONFIG_SYSTEM' => '/dev/null'];

    #[TestDox('publish replaces the checkout, except .git, with the published paths at HEAD')]
    public function testPublish(): void
    {
        $this->createSource();
        $this->writeFile('target/old.md', "old\n");
        $this->writeFile('target/skills/removed/SKILL.md', "removed\n");
        $this->git('target', 'init', '-q');

        $process = $this->publish('target');

        self::assertSame(0, $process->getExitCode(), $process->getErrorOutput());
        self::assertStringStartsWith('Published ', $process->getOutput());
        self::assertSame(
            ['.claude-plugin/plugin.json', 'LICENSE', 'LICENSE-CODE', 'NOTICE.md', 'README.md', 'agents/code-reader.md', 'hooks/hooks.json', 'skills/guide/SKILL.md'],
            $this->files('target'),
        );
        self::assertDirectoryExists($this->temporaryDirectory().'/target/.git');
    }

    #[TestDox('publish ignores uncommitted changes and says so')]
    public function testUncommittedChanges(): void
    {
        $this->createSource();
        $this->writeFile('source/README.md', "# Changed\n");
        mkdir($this->temporaryDirectory().'/target');
        $this->git('target', 'init', '-q');

        $process = $this->publish('target');

        self::assertSame("# Readme\n", file_get_contents($this->temporaryDirectory().'/target/README.md'));
        self::assertStringContainsString('Uncommitted changes in the published paths are not published.', $process->getErrorOutput());
    }

    #[TestDox('publish warns when the content changes and the plugin version does not')]
    public function testUnchangedVersion(): void
    {
        $this->createSource();
        $this->writeFile('target/.claude-plugin/plugin.json', "{\n    \"version\": \"0.1.0\"\n}\n");
        $this->git('target', 'init', '-q');
        $this->git('target', 'add', '-A');
        $this->git('target', '-c', 'user.name=test', '-c', 'user.email=test@example.com', 'commit', '-q', '-m', 'release');

        $process = $this->publish('target');

        self::assertStringContainsString('The version in .claude-plugin/plugin.json is still 0.1.0.', $process->getErrorOutput());
    }

    #[TestDox('publish refuses a folder that is not a git checkout')]
    public function testRejectsFolderWithoutGit(): void
    {
        $this->createSource();
        $this->writeFile('target/keep.md', "keep\n");

        self::assertSame(2, $this->publish('target')->getExitCode());
        self::assertFileExists($this->temporaryDirectory().'/target/keep.md');
    }

    #[TestDox('publish refuses its own repository as the target')]
    public function testRejectsOwnRepository(): void
    {
        $this->createSource();

        self::assertSame(2, $this->publish('source')->getExitCode());
        self::assertFileExists($this->temporaryDirectory().'/source/tools/bin/publish');
    }

    #[TestDox('The published README.md has no development-repository-only block')]
    public function testRemovesDevelopmentRepositoryBlock(): void
    {
        $readme = "# Readme\n\n<!-- development-repository-only:start -->\n> Open issues here.\n<!-- development-repository-only:end -->\n\nText.\n";
        $this->createSource($readme);
        mkdir($this->temporaryDirectory().'/target');
        $this->git('target', 'init', '-q');

        $this->publish('target');

        self::assertSame("# Readme\n\nText.\n", file_get_contents($this->temporaryDirectory().'/target/README.md'));
        self::assertSame($readme, file_get_contents($this->temporaryDirectory().'/source/README.md'));
    }

    #[TestDox('publish refuses a README.md with a development-repository-only block that has no end')]
    public function testRejectsOpenDevelopmentRepositoryBlock(): void
    {
        $this->createSource("# Readme\n\n<!-- development-repository-only:start -->\nText.\n");
        $this->writeFile('target/keep.md', "keep\n");
        $this->git('target', 'init', '-q');

        $process = $this->publish('target');

        self::assertSame(2, $process->getExitCode());
        self::assertStringContainsString('without its end', $process->getErrorOutput());
        self::assertFileExists($this->temporaryDirectory().'/target/keep.md');
    }

    private function createSource(string $readme = "# Readme\n"): void
    {
        $this->writeFile('source/tools/bin/publish', (string) file_get_contents(\dirname(__DIR__, 2).'/tools/bin/publish'));
        $this->writeFile('source/.claude-plugin/plugin.json', "{\n    \"version\": \"0.1.0\"\n}\n");
        $this->writeFile('source/skills/guide/SKILL.md', "---\nname: guide\n---\n");
        $this->writeFile('source/agents/code-reader.md', "# Reader\n");
        $this->writeFile('source/hooks/hooks.json', "{}\n");
        $this->writeFile('source/evals/case/prompt.md', "Prompt\n");
        foreach (['README.md' => $readme, 'LICENSE' => "CC\n", 'LICENSE-CODE' => "MIT\n", 'NOTICE.md' => "# Notice\n"] as $file => $content) {
            $this->writeFile('source/'.$file, $content);
        }
        $this->git('source', 'init', '-q');
        $this->git('source', 'add', '-A');
        $this->git('source', '-c', 'user.name=test', '-c', 'user.email=test@example.com', 'commit', '-q', '-m', 'source');
    }

    private function git(string $directory, string ...$arguments): void
    {
        (new Process(['git', ...$arguments], $this->temporaryDirectory().'/'.$directory, self::GIT_ENVIRONMENT))->mustRun();
    }

    private function publish(string $target): Process
    {
        $process = new Process(['bash', $this->temporaryDirectory().'/source/tools/bin/publish', $this->temporaryDirectory().'/'.$target], null, self::GIT_ENVIRONMENT);
        $process->run();

        return $process;
    }

    /**
     * @return list<string>
     */
    private function files(string $directory): array
    {
        $root = $this->temporaryDirectory().'/'.$directory;
        $files = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            \assert($file instanceof \SplFileInfo);
            $path = substr($file->getPathname(), \strlen($root) + 1);
            if (!str_starts_with($path, '.git/')) {
                $files[] = $path;
            }
        }
        sort($files);

        return $files;
    }
}
