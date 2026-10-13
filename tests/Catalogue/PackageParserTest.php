<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Tests\Catalogue;

use ComponentGuide\Tools\Catalogue\PackageParser;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class PackageParserTest extends TestCase
{
    private const string MARKDOWN = <<<'MD'
        # Security (`symfony/security-bundle`, `symfony/security-core`)

        **Applies to:** Symfony 8.1

        **Elevator pitch:** Use when users must log in.

        ## Why it exists
        Text.

        ## When to use it

        - One.
        - Two.

        MD;

    #[TestDox('Reads the title, the preamble fields and the sections')]
    public function testParse(): void
    {
        $document = new PackageParser()->parse('security-bundle', self::MARKDOWN);

        self::assertSame('security-bundle', $document->name);
        self::assertSame('Security', $document->displayName());
        self::assertSame(['symfony/security-bundle', 'symfony/security-core'], $document->composerNames());
        self::assertSame(['Applies to' => 'Symfony 8.1', 'Elevator pitch' => 'Use when users must log in.'], $document->fields);
        self::assertSame('Text.', $document->section('Why it exists')?->body);
        self::assertSame("- One.\n- Two.", $document->section('When to use it')?->body);
        self::assertNull($document->section('Docs'));
    }

    #[TestDox('Composer names may contain a wildcard')]
    public function testWildcardComposerName(): void
    {
        self::assertSame(['symfony/polyfill-*'], new PackageParser()->parse('polyfill', "# Symfony Polyfill (`symfony/polyfill-*`)\n")->composerNames());
    }

    #[TestDox('Rejects a file without an H1 first line')]
    public function testMissingTitle(): void
    {
        $this->expectExceptionMessage('asset: the first line must be an H1 heading.');

        new PackageParser()->parse('asset', "Text\n");
    }

    #[TestDox('Rejects free text in the preamble')]
    public function testUnexpectedPreamble(): void
    {
        $this->expectExceptionMessage('asset: unexpected preamble line "Free text".');

        new PackageParser()->parse('asset', "# Asset (`symfony/asset`)\n\nFree text\n");
    }
}
