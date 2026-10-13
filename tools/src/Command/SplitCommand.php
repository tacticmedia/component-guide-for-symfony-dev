<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Command;

use ComponentGuide\Tools\Catalogue\PackageParser;
use ComponentGuide\Tools\Catalogue\Splitter;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('split', 'Split each source package file into a triage file and a details file.')]
final class SplitCommand
{
    public function __construct(
        private readonly PackageParser $parser = new PackageParser(),
        private readonly Splitter $splitter = new Splitter(),
    ) {
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Folder with the source package files and index.md')] string $source,
        #[Argument('Skill folder that receives packages/ and details/')] string $skill,
        #[Option('Markdown file that receives the "Verified against" line of each package')] ?string $verificationRecord = null,
        #[Option('Overwrite existing triage and details files')] bool $force = false,
    ): int {
        $sourceFiles = array_values(array_filter(
            glob(rtrim($source, '/').'/*.md') ?: [],
            static fn (string $path): bool => 'index.md' !== basename($path),
        ));
        if ([] === $sourceFiles) {
            $io->error(\sprintf('No package files in "%s".', $source));

            return Command::FAILURE;
        }

        foreach (['packages', 'details'] as $folder) {
            $target = $skill.'/'.$folder;
            if (!$force && [] !== (glob($target.'/*.md') ?: [])) {
                $io->error(\sprintf('"%s" already has files. The split files are the source after the first split; pass --force only to discard their edits.', $target));

                return Command::FAILURE;
            }
            if (!is_dir($target) && !mkdir($target, 0o777, true)) {
                $io->error(\sprintf('Cannot create "%s".', $target));

                return Command::FAILURE;
            }
        }

        $record = [];
        foreach ($sourceFiles as $path) {
            $name = basename($path, '.md');
            $result = $this->splitter->split($this->parser->parse($name, (string) file_get_contents($path)));
            file_put_contents($skill.'/packages/'.$name.'.md', $result->triage);
            file_put_contents($skill.'/details/'.$name.'.md', $result->details);
            $record[] = \sprintf('| `%s` | %s |', $name, str_replace('|', '\|', $result->verifiedAgainst));
        }

        if (null !== $verificationRecord) {
            file_put_contents($verificationRecord, "| Package file | Verified against |\n|---|---|\n".implode("\n", $record)."\n");
        }

        $io->success(\sprintf('Split %d package files into "%s".', \count($sourceFiles), $skill));

        return Command::SUCCESS;
    }
}
