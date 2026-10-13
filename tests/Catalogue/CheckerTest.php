<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Tests\Catalogue;

use ComponentGuide\Tools\Catalogue\Catalogue;
use ComponentGuide\Tools\Catalogue\Checker;
use ComponentGuide\Tools\Catalogue\Issue;
use ComponentGuide\Tools\Tests\TemporaryDirectory;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class CheckerTest extends TestCase
{
    use TemporaryDirectory;

    private const string TRIAGE = <<<'MD'
        # Lock (`symfony/lock`)

        **Applies to:** Symfony 8.1

        **Elevator pitch:** Use when two processes must not run the same job at the same time. For a limit above one, see [Semaphore](semaphore.md).

        **Details:** [../details/lock.md](../details/lock.md)

        ## Why it exists

        Two cron runs of one import can overlap.

        ## When to use it

        - Stop a second worker.

        ## Use it instead of

        - `touch('/tmp/x.lock')` -> `LockFactory`.

        MD;

    private const string DETAILS = <<<'MD'
        # Lock (`symfony/lock`): details

        **Applies to:** Symfony 8.1

        ## Key features and concepts

        - Stores, see [Cache](../packages/cache.md).

        ## Entry points

        - Without FrameworkBundle: `new LockFactory($store)`.

        MD;

    private const string SKILL = "---\nname: x\n---\n\n<!-- router:start -->\n\n### Locks\n\n- [Lock](packages/lock.md) (`symfony/lock`): Use when two processes must not run the same job at the same time.\n- [Semaphore](packages/semaphore.md) (`symfony/semaphore`): Use when at most N processes may run.\n- [Cache](packages/cache.md) (`symfony/cache`): Use when a slow result must be stored.\n\n<!-- router:end -->\n";

    #[TestDox('A consistent catalogue has no errors and no warnings')]
    public function testCleanCatalogue(): void
    {
        $this->writeCatalogue();

        self::assertSame([], $this->messages());
    }

    #[TestDox('A triage file without a details file is an error')]
    public function testMissingDetails(): void
    {
        $this->writeCatalogue();
        unlink($this->temporaryDirectory().'/details/cache.md');

        self::assertContains('ERROR packages/cache.md: has no details file.', $this->messages());
    }

    #[TestDox('A broken relative link is an error')]
    public function testBrokenLink(): void
    {
        $this->writeCatalogue(triage: str_replace('semaphore.md', 'missing.md', self::TRIAGE));

        self::assertContains('ERROR packages/lock.md: broken link "missing.md".', $this->messages());
    }

    #[TestDox('A router line that differs from the first pitch sentence is an error')]
    public function testStaleRouter(): void
    {
        $this->writeCatalogue(skill: str_replace('at the same time.', 'together.', self::SKILL));

        self::assertContains('ERROR SKILL.md: router entry "lock" differs from its triage file. Run "tools/bin/catalogue router".', $this->messages());
    }

    #[TestDox('A package that the router does not list is an error')]
    public function testPackageMissingFromRouter(): void
    {
        $this->writeCatalogue(skill: preg_replace('/^- \[Cache\].*\n/m', '', self::SKILL) ?? '');

        self::assertContains('ERROR SKILL.md: router has no entry for "cache".', $this->messages());
    }

    #[TestDox('Non-ASCII prose is an error, non-ASCII code is not')]
    public function testNonAscii(): void
    {
        $this->writeCatalogue(details: str_replace('- Stores,', "- Stores \u{2014} `\u{00E4}`,", self::DETAILS));

        self::assertContains("ERROR details/lock.md: non-ASCII characters outside code: \u{2014}", $this->messages());
    }

    #[TestDox('Code and Symfony terms in the triage prose are warnings')]
    public function testTriageWording(): void
    {
        $this->writeCatalogue(triage: str_replace('- Stop a second worker.', '- Stop a second worker with `LockFactory` and autowiring in FrameworkBundle.', self::TRIAGE));

        $messages = $this->messages();

        self::assertContains('WARNING packages/lock.md: When to use it has code: `LockFactory`', $messages);
        self::assertContains('WARNING packages/lock.md: When to use it has Symfony terms: autowiring, FrameworkBundle', $messages);
    }

    #[TestDox('A triage section in a details file is an error')]
    public function testTriageSectionInDetails(): void
    {
        $this->writeCatalogue(details: self::DETAILS."\n## Why it exists\n\nText.\n");

        self::assertContains('ERROR details/lock.md: section "Why it exists" belongs in the triage file.', $this->messages());
    }

    private function writeCatalogue(string $triage = self::TRIAGE, string $details = self::DETAILS, string $skill = self::SKILL): void
    {
        $this->writeFile('SKILL.md', $skill);
        $this->writeFile('packages/lock.md', $triage);
        $this->writeFile('details/lock.md', $details);
        foreach (['semaphore' => 'Semaphore (`symfony/semaphore`)', 'cache' => 'Cache (`symfony/cache`)'] as $name => $title) {
            $pitch = 'semaphore' === $name ? 'Use when at most N processes may run.' : 'Use when a slow result must be stored.';
            $this->writeFile('packages/'.$name.'.md', str_replace(
                ['Lock (`symfony/lock`)', 'Use when two processes must not run the same job at the same time. For a limit above one, see [Semaphore](semaphore.md).', 'details/lock.md'],
                [$title, $pitch, 'details/'.$name.'.md'],
                self::TRIAGE,
            ));
            $this->writeFile('details/'.$name.'.md', str_replace('Lock (`symfony/lock`)', $title, self::DETAILS));
        }
    }

    /**
     * @return list<string>
     */
    private function messages(): array
    {
        return array_map(
            static fn (Issue $issue): string => ($issue->isError ? 'ERROR ' : 'WARNING ').$issue->file.': '.$issue->message,
            new Checker()->check(Catalogue::load($this->temporaryDirectory())),
        );
    }
}
