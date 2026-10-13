<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

/**
 * Markdown text split into prose and inline code spans (CommonMark backtick-run rules).
 */
final class Prose
{
    private const array ASCII_REPLACEMENTS = ["\u{2192}" => '->', "\u{2026}" => '...'];

    /**
     * @return list<array{code: bool, text: string}>
     */
    public static function segments(string $text): array
    {
        $segments = [];
        $prose = '';
        $length = \strlen($text);
        $i = 0;

        while ($i < $length) {
            if ('`' !== $text[$i]) {
                $prose .= $text[$i++];

                continue;
            }

            $run = strspn($text, '`', $i);
            $close = self::findClosingRun($text, $i + $run, $run);
            if (null === $close) {
                $prose .= substr($text, $i, $run);
                $i += $run;

                continue;
            }

            if ('' !== $prose) {
                $segments[] = ['code' => false, 'text' => $prose];
                $prose = '';
            }
            $segments[] = ['code' => true, 'text' => substr($text, $i, $close + $run - $i)];
            $i = $close + $run;
        }

        if ('' !== $prose) {
            $segments[] = ['code' => false, 'text' => $prose];
        }

        return $segments;
    }

    /**
     * @param callable(string): string $map
     */
    public static function mapProse(string $text, callable $map): string
    {
        $result = '';
        foreach (self::segments($text) as $segment) {
            $result .= $segment['code'] ? $segment['text'] : $map($segment['text']);
        }

        return $result;
    }

    public static function toAscii(string $text): string
    {
        return self::mapProse($text, static fn (string $prose): string => strtr($prose, self::ASCII_REPLACEMENTS));
    }

    public static function withoutCode(string $text): string
    {
        $result = '';
        foreach (self::segments($text) as $segment) {
            $result .= $segment['code'] ? ' ' : $segment['text'];
        }

        return $result;
    }

    /**
     * @return list<string>
     */
    public static function codeSpans(string $text): array
    {
        $spans = [];
        foreach (self::segments($text) as $segment) {
            if ($segment['code']) {
                $spans[] = $segment['text'];
            }
        }

        return $spans;
    }

    /**
     * @return list<string>
     */
    public static function nonAsciiInProse(string $text): array
    {
        preg_match_all('/[^\x00-\x7F]/u', self::withoutCode($text), $matches);

        return array_values(array_unique($matches[0]));
    }

    /**
     * Text up to and including the first period that ends a sentence outside code.
     */
    public static function firstSentence(string $text): string
    {
        $offset = 0;
        foreach (self::segments($text) as $segment) {
            if (!$segment['code'] && preg_match('/\.(?=\s)/', $segment['text'], $match, \PREG_OFFSET_CAPTURE)) {
                return substr($text, 0, $offset + $match[0][1] + 1);
            }
            $offset += \strlen($segment['text']);
        }

        return $text;
    }

    private static function findClosingRun(string $text, int $from, int $run): ?int
    {
        $length = \strlen($text);
        $i = $from;
        while ($i < $length) {
            if ("\n" === $text[$i] && $i + 1 < $length && "\n" === $text[$i + 1]) {
                return null;
            }
            if ('`' !== $text[$i]) {
                ++$i;

                continue;
            }
            $candidate = strspn($text, '`', $i);
            if ($candidate === $run) {
                return $i;
            }
            $i += $candidate;
        }

        return null;
    }
}
