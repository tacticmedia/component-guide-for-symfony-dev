<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

final class AppliesTo
{
    private const string DEFAULT = 'Symfony 8.1';

    private const array SYMFONY_AI = ['ai-agent', 'ai-bundle', 'ai-chat', 'ai-mate', 'ai-platform', 'ai-store', 'mcp-bundle'];

    private const array OTHER_RELEASE_LINES = [
        'contracts' => 'Symfony Contracts 3.7, Symfony 8.1',
        'flex' => 'Symfony Flex 2.11',
        'language-tools' => 'symfony/lsp 0.23, Symfony CLI 5.22',
        'maker-bundle' => 'MakerBundle 1.68',
        'mercure' => 'symfony/mercure 0.9, MercureBundle 0.6, Symfony UX 3.5',
        'monolog-bundle' => 'MonologBundle 4.1, Monolog 3',
        'panther' => 'Panther 2.4',
        'polyfill' => 'Symfony Polyfill 1.43, Symfony 8.1',
        'reprise' => 'Reprise 1.3',
        'requirements-checker' => 'Requirements Checker 2.0',
        'webpack-encore-bundle' => 'WebpackEncoreBundle 2.4, Encore 7.2',
    ];

    public static function forPackage(string $name): string
    {
        return match (true) {
            \in_array($name, self::SYMFONY_AI, true) => 'Symfony AI 0.14',
            str_starts_with($name, 'ux-'), 'stimulus-bundle' === $name => 'Symfony UX 3.5',
            default => self::OTHER_RELEASE_LINES[$name] ?? self::DEFAULT,
        };
    }
}
