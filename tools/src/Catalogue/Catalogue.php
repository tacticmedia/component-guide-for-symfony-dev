<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

/**
 * The files of the packages skill directory: SKILL.md, packages/ (triage) and details/.
 */
final readonly class Catalogue
{
    /**
     * @param array<string, PackageDocument> $triage  keyed by package name
     * @param array<string, PackageDocument> $details keyed by package name
     * @param array<string, string>          $rawFiles markdown keyed by path relative to the skill directory
     */
    public function __construct(
        public string $directory,
        public string $skillMarkdown,
        public array $triage,
        public array $details,
        public array $rawFiles,
    ) {
    }

    public static function load(string $directory, PackageParser $parser = new PackageParser()): self
    {
        $skillPath = $directory.'/SKILL.md';
        $skillMarkdown = is_file($skillPath) ? (string) file_get_contents($skillPath) : '';
        $rawFiles = '' === $skillMarkdown ? [] : ['SKILL.md' => $skillMarkdown];

        $documents = [];
        foreach (['packages', 'details'] as $folder) {
            $documents[$folder] = [];
            foreach (glob($directory.'/'.$folder.'/*.md') ?: [] as $path) {
                $name = basename($path, '.md');
                $markdown = (string) file_get_contents($path);
                $rawFiles[$folder.'/'.$name.'.md'] = $markdown;
                try {
                    $documents[$folder][$name] = $parser->parse($name, $markdown);
                } catch (\InvalidArgumentException $exception) {
                    throw new \InvalidArgumentException($folder.'/'.$exception->getMessage(), 0, $exception);
                }
            }
        }

        return new self($directory, $skillMarkdown, $documents['packages'], $documents['details'], $rawFiles);
    }
}
