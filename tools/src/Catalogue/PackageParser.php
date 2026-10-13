<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

final class PackageParser
{
    public function parse(string $name, string $markdown): PackageDocument
    {
        $lines = explode("\n", str_replace("\r\n", "\n", $markdown));
        $firstLine = $lines[0];
        if (!str_starts_with($firstLine, '# ')) {
            throw new \InvalidArgumentException(\sprintf('%s: the first line must be an H1 heading.', $name));
        }

        $fields = [];
        $sections = [];
        $heading = null;
        $body = [];

        foreach (\array_slice($lines, 1) as $line) {
            if (str_starts_with($line, '## ')) {
                if (null !== $heading) {
                    $sections[] = new Section($heading, self::trimBlankLines($body));
                }
                $heading = substr($line, 3);
                $body = [];

                continue;
            }

            if (null !== $heading) {
                $body[] = $line;

                continue;
            }

            if (preg_match('/^\*\*([^*]+):\*\* (.+)$/', $line, $match)) {
                $fields[$match[1]] = $match[2];
            } elseif ('' !== trim($line)) {
                throw new \InvalidArgumentException(\sprintf('%s: unexpected preamble line "%s".', $name, $line));
            }
        }

        if (null !== $heading) {
            $sections[] = new Section($heading, self::trimBlankLines($body));
        }

        return new PackageDocument($name, substr($firstLine, 2), $fields, $sections);
    }

    /**
     * @param list<string> $lines
     */
    private static function trimBlankLines(array $lines): string
    {
        return trim(implode("\n", $lines), "\n");
    }
}
