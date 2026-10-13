<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Tests\Catalogue;

use ComponentGuide\Tools\Catalogue\Prose;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class ProseTest extends TestCase
{
    #[TestDox('A double-backtick span that contains a backtick is one code segment')]
    public function testDoubleBacktickSpan(): void
    {
        $segments = Prose::segments('starts with `` ` `` or `|`.');

        self::assertSame(['starts with ', '`` ` ``', ' or ', '`|`', '.'], array_column($segments, 'text'));
        self::assertSame([false, true, false, true, false], array_column($segments, 'code'));
    }

    #[TestDox('An unclosed backtick stays prose')]
    public function testUnclosedBacktick(): void
    {
        self::assertSame([['code' => false, 'text' => 'a ` b']], Prose::segments('a ` b'));
    }

    #[TestDox('A code span does not continue across a blank line')]
    public function testCodeSpanStopsAtBlankLine(): void
    {
        self::assertSame([], Prose::codeSpans("a `b\n\nc` d"));
    }

    #[TestDox('Arrows and ellipses become ASCII in prose and stay in code')]
    public function testToAscii(): void
    {
        self::assertSame("x -> y... `truncate(100, '\u{2026}')`", Prose::toAscii("x \u{2192} y\u{2026} `truncate(100, '\u{2026}')`"));
    }

    #[TestDox('Non-ASCII characters are reported only outside code')]
    public function testNonAsciiInProse(): void
    {
        self::assertSame(["\u{00D7}"], Prose::nonAsciiInProse("5 \u{00D7} `a \u{00E4} b` 5 \u{00D7}"));
    }

    #[TestDox('The first sentence ends at the first period outside code')]
    public function testFirstSentence(): void
    {
        self::assertSame('Use when `a. b` matters.', Prose::firstSentence('Use when `a. b` matters. Second sentence.'));
    }

    #[TestDox('Text without a sentence end is one sentence')]
    public function testFirstSentenceWithoutPeriod(): void
    {
        self::assertSame('Use when x', Prose::firstSentence('Use when x'));
    }

    #[TestDox('mapProse changes prose and keeps code')]
    public function testMapProse(): void
    {
        self::assertSame('A `b` C', Prose::mapProse('a `b` c', strtoupper(...)));
    }
}
