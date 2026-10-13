<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

final readonly class RouterGroup
{
    /**
     * @param list<RouterEntry|string> $items an entry, or a note line kept verbatim
     */
    public function __construct(
        public string $heading,
        public array $items,
    ) {
    }

    /**
     * @return list<RouterEntry>
     */
    public function entries(): array
    {
        return array_values(array_filter($this->items, static fn (RouterEntry|string $item): bool => $item instanceof RouterEntry));
    }

    public function render(): string
    {
        $lines = array_map(static fn (RouterEntry|string $item): string => $item instanceof RouterEntry ? $item->render() : $item, $this->items);

        return '### '.$this->heading."\n\n".implode("\n", $lines);
    }
}
