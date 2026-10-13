<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Command;

use ComponentGuide\Tools\Catalogue\Catalogue;
use ComponentGuide\Tools\Catalogue\Router;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('router', 'Write the router block of SKILL.md from the first pitch sentence of each triage file.')]
final class RouterCommand
{
    public function __construct(
        private readonly Router $router = new Router(),
    ) {
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Skill folder with SKILL.md and packages/')] string $skill,
        #[Option('Take the groups and their order from this index.md instead of the current router block')] ?string $bootstrap = null,
    ): int {
        $catalogue = Catalogue::load($skill);
        if ('' === $catalogue->skillMarkdown) {
            $io->error(\sprintf('No SKILL.md in "%s".', $skill));

            return Command::FAILURE;
        }

        $groups = null === $bootstrap
            ? $this->router->groupsFromSkill($catalogue->skillMarkdown)
            : $this->router->groupsFromIndex((string) file_get_contents($bootstrap));
        $block = $this->router->render($this->router->refresh($groups, $catalogue->triage));

        file_put_contents($skill.'/SKILL.md', $this->router->replaceBlock($catalogue->skillMarkdown, $block));
        $io->success(\sprintf('Router written: %d groups, about %d tokens.', \count($groups), intdiv(\strlen($block), 4)));

        return Command::SUCCESS;
    }
}
