<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

/**
 * The package router: the block of SKILL.md between the router markers.
 */
final class Router
{
    public const string START_MARKER = '<!-- router:start -->';
    public const string END_MARKER = '<!-- router:end -->';

    private const string INDEX_ENTRY = '/^- \[([^\]]+)\]\(([a-z0-9-]+)\.md\) \(([^)]*)\): (.+)$/';
    private const string BLOCK_ENTRY = '/^- \[([^\]]+)\]\(packages\/([a-z0-9-]+)\.md\) \(([^)]*)\): (.+)$/';

    /**
     * Reads the groups of the source index.md: every H2 after "## Groups".
     *
     * @return list<RouterGroup>
     */
    public function groupsFromIndex(string $indexMarkdown): array
    {
        $afterGroups = explode("\n## Groups\n", $indexMarkdown, 2)[1]
            ?? throw new \InvalidArgumentException('index.md: missing "## Groups" section.');
        $groupBlocks = \array_slice(preg_split('/^## /m', $afterGroups) ?: [], 1);

        return array_map(fn (string $block): RouterGroup => $this->parseGroup($block, self::INDEX_ENTRY, true), $groupBlocks);
    }

    /**
     * @return list<RouterGroup>
     */
    public function groupsFromSkill(string $skillMarkdown): array
    {
        $groupBlocks = \array_slice(preg_split('/^### /m', self::extractBlock($skillMarkdown)) ?: [], 1);

        return array_map(fn (string $block): RouterGroup => $this->parseGroup($block, self::BLOCK_ENTRY, false), $groupBlocks);
    }

    /**
     * @param list<RouterGroup>              $groups
     * @param array<string, PackageDocument> $triageByName
     *
     * @return list<RouterGroup>
     */
    public function refresh(array $groups, array $triageByName): array
    {
        return array_map(
            static fn (RouterGroup $group): RouterGroup => new RouterGroup(
                $group->heading,
                array_map(
                    static fn (RouterEntry|string $item): RouterEntry|string => $item instanceof RouterEntry
                        ? RouterEntry::fromTriage($triageByName[$item->name] ?? throw new \InvalidArgumentException(\sprintf('Router entry "%s" has no triage file.', $item->name)))
                        : $item,
                    $group->items,
                ),
            ),
            $groups,
        );
    }

    /**
     * @param list<RouterGroup> $groups
     */
    public function render(array $groups): string
    {
        return implode("\n\n", array_map(static fn (RouterGroup $group): string => $group->render(), $groups));
    }

    public function replaceBlock(string $skillMarkdown, string $block): string
    {
        self::extractBlock($skillMarkdown);
        [$before, $rest] = explode(self::START_MARKER, $skillMarkdown, 2);
        $after = explode(self::END_MARKER, $rest, 2)[1];

        return $before.self::START_MARKER."\n\n".$block."\n\n".self::END_MARKER.$after;
    }

    public static function extractBlock(string $skillMarkdown): string
    {
        $start = strpos($skillMarkdown, self::START_MARKER);
        $end = strpos($skillMarkdown, self::END_MARKER);
        if (false === $start || false === $end || $end < $start) {
            throw new \InvalidArgumentException('SKILL.md: missing router markers.');
        }

        return substr($skillMarkdown, $start + \strlen(self::START_MARKER), $end - $start - \strlen(self::START_MARKER));
    }

    private function parseGroup(string $block, string $entryPattern, bool $fromIndex): RouterGroup
    {
        $lines = explode("\n", trim($block));
        $heading = array_shift($lines);
        $items = [];
        foreach ($lines as $line) {
            if (preg_match($entryPattern, $line, $match)) {
                preg_match_all('/`([^`]+)`/', $match[3], $names);
                $items[] = new RouterEntry($match[2], $match[1], $names[1], $match[4]);
            } elseif (str_starts_with($line, '- ')) {
                $items[] = $fromIndex ? self::linkNoteToTriage($line) : $line;
            }
        }

        return new RouterGroup($heading, $items);
    }

    private static function linkNoteToTriage(string $line): string
    {
        return Prose::mapProse(
            $line,
            static fn (string $prose): string => preg_replace('/\]\(([a-z0-9-]+\.md)\)/', '](packages/$1)', $prose) ?? $prose,
        );
    }
}
