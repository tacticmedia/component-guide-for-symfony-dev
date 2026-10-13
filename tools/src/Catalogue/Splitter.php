<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

final class Splitter
{
    public const array TRIAGE_SECTIONS = ['Why it exists', 'When to use it', 'Use it instead of'];

    public function split(PackageDocument $source): SplitResult
    {
        $verifiedAgainst = $source->field('Verified against')
            ?? throw new \InvalidArgumentException(\sprintf('%s: missing "Verified against" line.', $source->name));
        $pitch = $source->field('Elevator pitch')
            ?? throw new \InvalidArgumentException(\sprintf('%s: missing "Elevator pitch" line.', $source->name));
        $appliesTo = AppliesTo::forPackage($source->name);

        $triage = [
            '# '.$source->title,
            '**Applies to:** '.$appliesTo,
            '**Elevator pitch:** '.$pitch,
            \sprintf('**Details:** [../details/%1$s.md](../details/%1$s.md)', $source->name),
        ];
        foreach (self::TRIAGE_SECTIONS as $heading) {
            $section = $source->section($heading)
                ?? throw new \InvalidArgumentException(\sprintf('%s: missing section "%s".', $source->name, $heading));
            $triage[] = self::renderSection($section);
        }

        $details = [
            '# '.$source->title.': details',
            '**Applies to:** '.$appliesTo,
        ];
        foreach ($source->sections as $section) {
            if (!\in_array($section->heading, self::TRIAGE_SECTIONS, true)) {
                $details[] = self::linkToTriage(self::renderSection($section));
            }
        }

        return new SplitResult(
            Prose::toAscii(implode("\n\n", $triage)."\n"),
            Prose::toAscii(implode("\n\n", $details)."\n"),
            $verifiedAgainst,
        );
    }

    private static function renderSection(Section $section): string
    {
        return '## '.$section->heading."\n\n".$section->body;
    }

    private static function linkToTriage(string $markdown): string
    {
        return Prose::mapProse(
            $markdown,
            static fn (string $prose): string => preg_replace('/\]\(([a-z0-9-]+\.md)(#[^)]*)?\)/', '](../packages/$1$2)', $prose) ?? $prose,
        );
    }
}
