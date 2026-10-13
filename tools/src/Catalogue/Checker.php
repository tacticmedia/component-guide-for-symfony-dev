<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

final class Checker
{
    public const array TRIAGE_FIELDS = ['Applies to', 'Elevator pitch', 'Details'];

    /** Files whose subject matter is non-ASCII text. */
    private const array NON_ASCII_ALLOWED = ['packages/emoji.md', 'details/emoji.md'];

    /** Terms that need knowledge of Symfony; triage prose must state goals instead. */
    private const string SYMFONY_TERMS = '/\b(autowir\w*|autoconfigur\w*|Flex|recipes?|kernels?|firewalls?|voters?|stamps?|compiler pass\w*|service container|services?\.yaml|Twig components?|Live Components?|LiveComponents?|TwigComponents?|Stimulus|Turbo|value resolvers?|normali[sz]ers?|denormali[sz]ers?|profiler|Messenger|MicroKernel\w*|param converter)\b/i';

    /** Bundle class names such as FrameworkBundle. The lowercase verb "bundle" (JavaScript bundling) is a general term. */
    private const string BUNDLE_NAMES = '/\b[A-Z]\w*Bundle\b/';

    public function __construct(
        private readonly Router $router = new Router(),
    ) {
    }

    /**
     * @return list<Issue>
     */
    public function check(Catalogue $catalogue): array
    {
        return [
            ...$this->checkPairs($catalogue),
            ...$this->checkTriage($catalogue),
            ...$this->checkDetails($catalogue),
            ...$this->checkLinks($catalogue),
            ...$this->checkRouter($catalogue),
            ...$this->checkAscii($catalogue),
            ...$this->checkTriageWording($catalogue),
        ];
    }

    /**
     * @return list<Issue>
     */
    private function checkPairs(Catalogue $catalogue): array
    {
        $issues = [];
        foreach (array_keys(array_diff_key($catalogue->triage, $catalogue->details)) as $name) {
            $issues[] = Issue::error('packages/'.$name.'.md', 'has no details file.');
        }
        foreach (array_keys(array_diff_key($catalogue->details, $catalogue->triage)) as $name) {
            $issues[] = Issue::error('details/'.$name.'.md', 'has no triage file.');
        }

        return $issues;
    }

    /**
     * @return list<Issue>
     */
    private function checkTriage(Catalogue $catalogue): array
    {
        $issues = [];
        foreach ($catalogue->triage as $name => $triage) {
            $file = 'packages/'.$name.'.md';
            foreach (self::TRIAGE_FIELDS as $label) {
                if (null === $triage->field($label)) {
                    $issues[] = Issue::error($file, \sprintf('missing "**%s:**" line.', $label));
                }
            }
            $expectedDetails = \sprintf('[../details/%1$s.md](../details/%1$s.md)', $name);
            if (null !== $triage->field('Details') && $triage->field('Details') !== $expectedDetails) {
                $issues[] = Issue::error($file, \sprintf('the "Details" line must be %s.', $expectedDetails));
            }
            $headings = array_map(static fn (Section $section): string => $section->heading, $triage->sections);
            if ($headings !== Splitter::TRIAGE_SECTIONS) {
                $issues[] = Issue::error($file, \sprintf('sections must be exactly "%s", found "%s".', implode('", "', Splitter::TRIAGE_SECTIONS), implode('", "', $headings)));
            }
            if ([] === $triage->composerNames()) {
                $issues[] = Issue::error($file, 'the H1 must name the Composer packages in code spans.');
            }
        }

        return $issues;
    }

    /**
     * @return list<Issue>
     */
    private function checkDetails(Catalogue $catalogue): array
    {
        $issues = [];
        foreach ($catalogue->details as $name => $details) {
            $file = 'details/'.$name.'.md';
            $appliesTo = $details->field('Applies to');
            if (null === $appliesTo) {
                $issues[] = Issue::error($file, 'missing "**Applies to:**" line.');
            } elseif (isset($catalogue->triage[$name]) && $appliesTo !== $catalogue->triage[$name]->field('Applies to')) {
                $issues[] = Issue::error($file, 'the "Applies to" line differs from the triage file.');
            }
            foreach ($details->sections as $section) {
                if (\in_array($section->heading, Splitter::TRIAGE_SECTIONS, true)) {
                    $issues[] = Issue::error($file, \sprintf('section "%s" belongs in the triage file.', $section->heading));
                }
            }
            foreach (['Key features and concepts', 'Entry points'] as $required) {
                if (null === $details->section($required)) {
                    $issues[] = Issue::error($file, \sprintf('missing section "%s".', $required));
                }
            }
        }

        return $issues;
    }

    /**
     * @return list<Issue>
     */
    private function checkLinks(Catalogue $catalogue): array
    {
        $issues = [];
        foreach ($catalogue->rawFiles as $file => $markdown) {
            preg_match_all('/\]\(([^)\s]+)\)/', Prose::withoutCode($markdown), $matches);
            foreach (array_unique($matches[1]) as $target) {
                if (preg_match('/^(https?:|mailto:|#)/', $target)) {
                    continue;
                }
                $path = \dirname($catalogue->directory.'/'.$file).'/'.explode('#', $target, 2)[0];
                if (!is_file($path)) {
                    $issues[] = Issue::error($file, \sprintf('broken link "%s".', $target));
                }
            }
        }

        return $issues;
    }

    /**
     * @return list<Issue>
     */
    private function checkRouter(Catalogue $catalogue): array
    {
        try {
            $groups = $this->router->groupsFromSkill($catalogue->skillMarkdown);
        } catch (\InvalidArgumentException $exception) {
            return [Issue::error('SKILL.md', $exception->getMessage())];
        }

        $issues = [];
        $seen = [];
        foreach ($groups as $group) {
            foreach ($group->entries() as $entry) {
                if (isset($seen[$entry->name])) {
                    $issues[] = Issue::error('SKILL.md', \sprintf('router lists "%s" more than once.', $entry->name));
                }
                $seen[$entry->name] = true;
                $triage = $catalogue->triage[$entry->name] ?? null;
                if (null === $triage) {
                    $issues[] = Issue::error('SKILL.md', \sprintf('router entry "%s" has no triage file.', $entry->name));
                } elseif (RouterEntry::fromTriage($triage)->render() !== $entry->render()) {
                    $issues[] = Issue::error('SKILL.md', \sprintf('router entry "%s" differs from its triage file. Run "tools/bin/catalogue router".', $entry->name));
                }
            }
        }
        foreach (array_keys(array_diff_key($catalogue->triage, $seen)) as $name) {
            $issues[] = Issue::error('SKILL.md', \sprintf('router has no entry for "%s".', $name));
        }

        return $issues;
    }

    /**
     * @return list<Issue>
     */
    private function checkAscii(Catalogue $catalogue): array
    {
        $issues = [];
        foreach ($catalogue->rawFiles as $file => $markdown) {
            if (\in_array($file, self::NON_ASCII_ALLOWED, true)) {
                continue;
            }
            $characters = Prose::nonAsciiInProse($markdown);
            if ([] !== $characters) {
                $issues[] = Issue::error($file, \sprintf('non-ASCII characters outside code: %s', implode(' ', $characters)));
            }
        }

        return $issues;
    }

    /**
     * @return list<Issue>
     */
    private function checkTriageWording(Catalogue $catalogue): array
    {
        $issues = [];
        foreach ($catalogue->triage as $name => $triage) {
            $file = 'packages/'.$name.'.md';
            $parts = [
                'pitch' => $triage->field('Elevator pitch') ?? '',
                'Why it exists' => $triage->section('Why it exists')->body ?? '',
                'When to use it' => $triage->section('When to use it')->body ?? '',
            ];
            foreach ($parts as $part => $text) {
                $codeSpans = Prose::codeSpans($text);
                if ([] !== $codeSpans) {
                    $issues[] = Issue::warning($file, \sprintf('%s has code: %s', $part, implode(' ', array_unique($codeSpans))));
                }
                $withoutLinkText = preg_replace('/\[[^\]]*\]\([^)]*\)/', ' ', Prose::withoutCode($text)) ?? '';
                preg_match_all(self::SYMFONY_TERMS, $withoutLinkText, $terms);
                preg_match_all(self::BUNDLE_NAMES, $withoutLinkText, $bundles);
                $found = array_unique([...$terms[0], ...$bundles[0]]);
                if ([] !== $found) {
                    $issues[] = Issue::warning($file, \sprintf('%s has Symfony terms: %s', $part, implode(', ', $found)));
                }
            }
            if (preg_match('/\bSymfony\b/', Prose::firstSentence($parts['pitch']))) {
                $issues[] = Issue::warning($file, 'the first pitch sentence names Symfony; state the goal instead.');
            }
        }

        return $issues;
    }
}
