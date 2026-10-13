# Maintaining the catalogue

## Layout

This repository, tacticmedia/component-guide-for-symfony-dev, is the plugin root. `tools/bin/publish` copies the published paths to tacticmedia/component-guide-for-symfony.

Published:
- `skills/component-guide-for-symfony/SKILL.md`: the reading procedure, the version rules, the application type rules, the core rules and the router. The router block between `<!-- router:start -->` and `<!-- router:end -->` is generated.
- `skills/component-guide-for-symfony/packages/<name>.md`: the triage file of a package.
- `skills/component-guide-for-symfony/details/<name>.md`: the details file of a package.
- `skills/component-slop-audit-for-symfony/`: the audit skill, its scripts, its templates, and in `references/` the instructions of its subagents.
- `agents/`: the Claude Code subagent types of the audit. Each one only limits the tools and points to its file in `references/`.
- `hooks/`: the Claude Code SessionStart hook.
- `.claude-plugin/`, `README.md`, `LICENSE`, `LICENSE-CODE`, `NOTICE.md`.
- `README.md` serves both repositories. `tools/bin/publish` removes each block between `<!-- development-repository-only:start -->` and `<!-- development-repository-only:end -->`, with the empty line after it, from the published copy. It refuses a block without its end.

Not published:
- `docs/coverage.md`: which Symfony repositories have a package file. `docs/verification.md`: the version that each package file was checked against.
- `tools/`: the maintainer commands. `tests/`: their tests.
- `evals/`: the `claude plugin eval` cases, with the audit fixture project in `evals/audit-reinvented-app/project/`. `claude plugin eval` reads cases only below the plugin root, so the evals stay in this repository.

Both skills use only the frontmatter fields of the Agent Skills standard. Outside Claude Code, another field can make packaging or upload fail, and the reference validator rejects it. Put Claude Code behavior in `agents/`, `hooks/` or the plugin manifest.

## Checks

Run these commands before each commit:

```bash
composer install
tools/bin/catalogue check skills/component-guide-for-symfony
vendor/bin/phpstan analyse
vendor/bin/phpunit
claude plugin validate --strict ./.claude-plugin/plugin.json
claude plugin validate --strict ./.claude-plugin/marketplace.json
claude plugin validate --strict ./skills
claude plugin validate --strict ./agents
uvx --from skills-ref@0.1.1 agentskills validate skills/component-guide-for-symfony
uvx --from skills-ref@0.1.1 agentskills validate skills/component-slop-audit-for-symfony
```

`agentskills validate` is the reference validator of the Agent Skills standard. It fails on a frontmatter field outside the standard and on a `name` that differs from the folder name.

Run the evals after each change to a skill, a rule or a pitch. [evals.md](evals.md) lists the cases and the commands.

`tools/bin/catalogue check` fails on structure errors, broken links, a router that differs from the pitches and non-ASCII prose. It also lists warnings for code and Symfony terms in the triage sections. Review each warning. A warning can stay only for a third-party name that the package integrates, such as Twig in the Twig packages.

## Writing rules

Triage file (`packages/`): the pitch, "Why it exists" and "When to use it" state goals in general software terms, for a reader who does not know Symfony.

- No code spans, no Symfony class, function, attribute or configuration key, and no Symfony-only term.
- Pitch sentence 1: "Use when <goal>." with at most about 25 words. It is the router line.
- Name the kinds of software where the goal applies, not only web pages: CLI tools, workers, scheduled jobs, long-running processes, libraries, terminal UIs, MCP servers, AI agents.
- To point to another package, link its triage file: `[AssetMapper](asset-mapper.md)`.
- "Use it instead of" maps hand-written code (left) to the package feature (right). Code is correct here.

Details file (`details/`): dense reference for an agent that uses the package.

- Present tense for the current behavior. Keep a patch version only when a reader on an older patch must write other code.
- A documentation error: one short correction, for example "symfony.com shows X. X fails. Use Y."
- "Changed in" sections list the removed and deprecated APIs with their replacements.
- Each component that works without FrameworkBundle has a "Without FrameworkBundle:" entry point.

All files: ASD-STE100 Simplified Technical English, ASCII only, no emoji.

After you change a pitch, run `tools/bin/catalogue router skills/component-guide-for-symfony`.

## Recheck for a new Symfony minor version

Symfony 8.2 is planned for November 2026.

1. Create the branch of the current line, for example `8.1`, from the default branch, in this repository and in the published repository. Users who need that line add the marketplace with `tacticmedia/component-guide-for-symfony#8.1`.
2. On the default branch, for each package:
   - Compare the source code of the new tag with the details file. Read the `CHANGELOG.md` and `UPGRADE-8.2.md` files of symfony/symfony.
   - Add the new removals and deprecations to "Changed in", and mark new features with the version, for example "(8.2)".
   - Update the "Applies to" line, the row in `docs/verification.md` and the row in `docs/coverage.md`.
3. Check the repositories in the "Unreleased" section of `docs/coverage.md` again. Add a package file for each one that has a stable release.
4. Update the core rules and the version rules of SKILL.md.
5. Run the checks and the evals. Increase `version` in `.claude-plugin/plugin.json`.

## Release

1. Increase `version` in `.claude-plugin/plugin.json`. Claude Code users get a new copy only when the version changes. Do not set `version` in `marketplace.json`.
2. Run the checks, and commit.
3. Run `composer publish`. It runs `tools/bin/publish ../component-guide-for-symfony`, so keep the checkout of the published repository next to this repository, on the branch of the line. For a checkout in another place, run `tools/bin/publish <checkout>`. The script replaces the checkout, except `.git`, with the published paths at `HEAD`. It warns about uncommitted changes, which it does not publish, and about an unchanged version.
4. In the checkout, review the diff, commit and push.
