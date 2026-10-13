<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

final readonly class PackageDocument
{
    /**
     * @param array<string, string> $fields preamble lines of the form "**Label:** value", keyed by label
     * @param list<Section>         $sections
     */
    public function __construct(
        public string $name,
        public string $title,
        public array $fields,
        public array $sections,
    ) {
    }

    public function field(string $label): ?string
    {
        return $this->fields[$label] ?? null;
    }

    public function section(string $heading): ?Section
    {
        return array_find($this->sections, static fn (Section $section): bool => $section->heading === $heading);
    }

    public function displayName(): string
    {
        return trim(explode(' (', $this->title, 2)[0]);
    }

    /**
     * @return list<string>
     */
    public function composerNames(): array
    {
        preg_match_all('/`([a-z0-9-]+\/[a-z0-9.*-]+)`/', $this->title, $matches);

        return $matches[1];
    }
}
