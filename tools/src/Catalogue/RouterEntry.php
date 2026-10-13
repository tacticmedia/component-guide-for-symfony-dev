<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

final readonly class RouterEntry
{
    /**
     * @param list<string> $composerNames
     */
    public function __construct(
        public string $name,
        public string $displayName,
        public array $composerNames,
        public string $text,
    ) {
    }

    public static function fromTriage(PackageDocument $triage): self
    {
        return new self(
            $triage->name,
            $triage->displayName(),
            $triage->composerNames(),
            Prose::firstSentence($triage->field('Elevator pitch') ?? ''),
        );
    }

    public function render(): string
    {
        $names = implode(', ', array_map(static fn (string $name): string => '`'.$name.'`', $this->composerNames));

        return \sprintf('- [%s](packages/%s.md) (%s): %s', $this->displayName, $this->name, $names, $this->text);
    }
}
