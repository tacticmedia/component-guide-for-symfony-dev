<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Tests\Catalogue;

use ComponentGuide\Tools\Catalogue\PackageParser;
use ComponentGuide\Tools\Catalogue\Router;
use ComponentGuide\Tools\Catalogue\RouterEntry;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    private const string INDEX = <<<'MD'
        # Catalogue

        ## Groups

        - [Security](#security)

        ## Security

        - [RateLimiter](rate-limiter.md) (`symfony/rate-limiter`): Use when you must throttle. Second sentence.
        - No file for Symfony ACL: use voters, see [Security](security-bundle.md).
        MD;

    private const string SKILL = "---\nname: x\n---\n\n## Router\n\n<!-- router:start -->\n<!-- router:end -->\n\nAfter.\n";

    #[TestDox('Reads the groups, the entries and the notes of index.md')]
    public function testGroupsFromIndex(): void
    {
        $groups = new Router()->groupsFromIndex(self::INDEX);

        self::assertCount(1, $groups);
        self::assertSame('Security', $groups[0]->heading);
        self::assertEquals(
            [
                new RouterEntry('rate-limiter', 'RateLimiter', ['symfony/rate-limiter'], 'Use when you must throttle. Second sentence.'),
                '- No file for Symfony ACL: use voters, see [Security](packages/security-bundle.md).',
            ],
            $groups[0]->items,
        );
    }

    #[TestDox('Refresh takes the first pitch sentence of the triage file')]
    public function testRefresh(): void
    {
        $router = new Router();
        $triage = new PackageParser()->parse('rate-limiter', "# RateLimiter (`symfony/rate-limiter`)\n\n**Elevator pitch:** Use when a client sends too many requests. More text.\n");

        $groups = $router->refresh($router->groupsFromIndex(self::INDEX), ['rate-limiter' => $triage]);

        self::assertSame('Use when a client sends too many requests.', $groups[0]->entries()[0]->text);
    }

    #[TestDox('A written router block reads back as the same groups')]
    public function testRoundTrip(): void
    {
        $router = new Router();
        $groups = $router->groupsFromIndex(self::INDEX);

        $skill = $router->replaceBlock(self::SKILL, $router->render($groups));

        self::assertEquals($groups, $router->groupsFromSkill($skill));
        self::assertStringEndsWith("<!-- router:end -->\n\nAfter.\n", $skill);
        self::assertStringContainsString('- [RateLimiter](packages/rate-limiter.md) (`symfony/rate-limiter`): Use when you must throttle.', $skill);
    }

    #[TestDox('A router entry without a triage file is rejected')]
    public function testRefreshUnknownEntry(): void
    {
        $this->expectExceptionMessage('Router entry "rate-limiter" has no triage file.');

        $router = new Router();
        $router->refresh($router->groupsFromIndex(self::INDEX), []);
    }

    #[TestDox('SKILL.md without router markers is rejected')]
    public function testMissingMarkers(): void
    {
        $this->expectExceptionMessage('SKILL.md: missing router markers.');

        new Router()->groupsFromSkill("# No markers\n");
    }
}
