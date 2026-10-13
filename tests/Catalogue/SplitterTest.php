<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Tests\Catalogue;

use ComponentGuide\Tools\Catalogue\AppliesTo;
use ComponentGuide\Tools\Catalogue\PackageParser;
use ComponentGuide\Tools\Catalogue\Splitter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class SplitterTest extends TestCase
{
    private const string SOURCE = <<<'MD'
        # Lock (`symfony/lock`)

        **Verified against:** symfony/lock v8.1.8 (2026-09-29), docs branch 8.1, on 2026-10-09.

        **Elevator pitch:** Use when two processes must not run the same job. See [Semaphore](semaphore.md).

        ## Why it exists
        Why → text.

        ## When to use it
        - When.

        ## Key features and concepts
        - Feature, see [Cache](cache.md#stores) and `flock://…`.

        ## Use it instead of
        - `touch('/tmp/x.lock')` → `LockFactory`.

        ## Entry points
        - `LockFactory`.

        ## Changed in 8.0/8.1
        - Nothing.
        MD;

    #[TestDox('The triage file has the preamble, the details link and exactly the three triage sections')]
    public function testTriage(): void
    {
        $triage = new PackageParser()->parse('lock', $this->split()->triage);

        self::assertSame([
            'Applies to' => 'Symfony 8.1',
            'Elevator pitch' => 'Use when two processes must not run the same job. See [Semaphore](semaphore.md).',
            'Details' => '[../details/lock.md](../details/lock.md)',
        ], $triage->fields);
        self::assertSame(Splitter::TRIAGE_SECTIONS, array_map(static fn ($section) => $section->heading, $triage->sections));
        self::assertSame('Why -> text.', $triage->section('Why it exists')?->body);
        self::assertSame("- `touch('/tmp/x.lock')` -> `LockFactory`.", $triage->section('Use it instead of')?->body);
    }

    #[TestDox('The details file keeps the other sections in order and links to triage files')]
    public function testDetails(): void
    {
        $details = new PackageParser()->parse('lock', $this->split()->details);

        self::assertSame('Lock (`symfony/lock`): details', $details->title);
        self::assertSame(['Applies to' => 'Symfony 8.1'], $details->fields);
        self::assertSame(['Key features and concepts', 'Entry points', 'Changed in 8.0/8.1'], array_map(static fn ($section) => $section->heading, $details->sections));
        self::assertSame('- Feature, see [Cache](../packages/cache.md#stores) and `flock://…`.', $details->section('Key features and concepts')?->body);
    }

    #[TestDox('The "Verified against" line goes to the verification record')]
    public function testVerifiedAgainst(): void
    {
        self::assertSame('symfony/lock v8.1.8 (2026-09-29), docs branch 8.1, on 2026-10-09.', $this->split()->verifiedAgainst);
    }

    #[TestDox('A source file without a triage section is rejected')]
    public function testMissingTriageSection(): void
    {
        $this->expectExceptionMessage('lock: missing section "Use it instead of".');

        $source = str_replace('## Use it instead of', '## Other', self::SOURCE);
        new Splitter()->split(new PackageParser()->parse('lock', $source));
    }

    #[TestDox('"Applies to" names the release line of $name')]
    #[DataProvider('releaseLines')]
    public function testAppliesTo(string $name, string $expected): void
    {
        self::assertSame($expected, AppliesTo::forPackage($name));
    }

    /**
     * @return iterable<array{string, string}>
     */
    public static function releaseLines(): iterable
    {
        yield ['lock', 'Symfony 8.1'];
        yield ['ai-agent', 'Symfony AI 0.14'];
        yield ['mcp-bundle', 'Symfony AI 0.14'];
        yield ['ux-turbo', 'Symfony UX 3.5'];
        yield ['stimulus-bundle', 'Symfony UX 3.5'];
        yield ['maker-bundle', 'MakerBundle 1.68'];
    }

    private function split(): \ComponentGuide\Tools\Catalogue\SplitResult
    {
        return new Splitter()->split(new PackageParser()->parse('lock', self::SOURCE));
    }
}
