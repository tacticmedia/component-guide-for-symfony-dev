<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Command;

use ComponentGuide\Tools\Catalogue\Catalogue;
use ComponentGuide\Tools\Catalogue\Checker;
use ComponentGuide\Tools\Catalogue\Issue;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('check', 'Check the structure, links, router, ASCII text and triage wording of the packages skill.')]
final class CheckCommand
{
    public function __construct(
        private readonly Checker $checker = new Checker(),
    ) {
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Skill folder with SKILL.md, packages/ and details/')] string $skill,
        #[Option('Do not list the triage wording warnings')] bool $errorsOnly = false,
    ): int {
        $catalogue = Catalogue::load($skill);
        $issues = $this->checker->check($catalogue);
        $errors = array_values(array_filter($issues, static fn (Issue $issue): bool => $issue->isError));
        $warnings = array_values(array_filter($issues, static fn (Issue $issue): bool => !$issue->isError));

        foreach ($errors as $issue) {
            $io->writeln(\sprintf('<error>ERROR</error> %s: %s', $issue->file, $issue->message));
        }
        if (!$errorsOnly) {
            foreach ($warnings as $issue) {
                $io->writeln(\sprintf('<comment>WARNING</comment> %s: %s', $issue->file, $issue->message));
            }
        }

        $io->table(['Part', 'Files', 'Average tokens'], [
            ['SKILL.md', '' === $catalogue->skillMarkdown ? 0 : 1, intdiv(\strlen($catalogue->skillMarkdown), 4)],
            ['packages/', \count($catalogue->triage), self::averageTokens($catalogue, 'packages/')],
            ['details/', \count($catalogue->details), self::averageTokens($catalogue, 'details/')],
        ]);

        if ([] !== $errors) {
            $io->error(\sprintf('%d errors, %d warnings.', \count($errors), \count($warnings)));

            return Command::FAILURE;
        }
        $io->success(\sprintf('No errors, %d warnings.', \count($warnings)));

        return Command::SUCCESS;
    }

    private static function averageTokens(Catalogue $catalogue, string $prefix): int
    {
        $sizes = [];
        foreach ($catalogue->rawFiles as $file => $markdown) {
            if (str_starts_with($file, $prefix)) {
                $sizes[] = \strlen($markdown);
            }
        }

        return [] === $sizes ? 0 : intdiv(intdiv(array_sum($sizes), \count($sizes)), 4);
    }
}
