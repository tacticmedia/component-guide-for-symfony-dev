# Evals

The cases are in `evals/`. Each run makes real model calls.

## Cases

| Case | What it checks |
|---|---|
| `console-tool-lock` | A console tool without FrameworkBundle gets Symfony Lock, not a hand-written lock file or `framework.*` configuration. |
| `framework-app-8x-rules` | New code uses named constraint arguments and `App::config()`, and no fluent or XML configuration. |
| `flaky-api-retry` | A retry need in a worker leads to the retry feature of HttpClient or Messenger, not a `sleep()` loop. |
| `symfony-80-command-test` | In a Symfony 8.0 project, the test does not use the 8.1-only `runCommand()` and the answer does not push an upgrade. |
| `ignores-javascript-project` | The skill does not load in a JavaScript project. |
| `laravel-rate-limit` | In a Laravel project, the answer follows Laravel. |
| `router-accuracy` | Top-1 routing accuracy on 105 goals that a writer took from the details files without seeing the router. |
| `audit-reinvented-app` | The audit finds the 12 expected findings of a fixture project and reports none of its 3 decoys. See `evals/audit-reinvented-app/answer-key.md`. |

## Commands

```bash
claude plugin eval . --scaffold --trust-plugin --no-publish
claude plugin eval . --case router-accuracy --ablation none --trust-plugin --no-publish
claude plugin eval . --case audit-reinvented-app --runs 1 --ablation none --scaffold --trust-plugin --no-publish --allow-tools Write Edit Bash
```

`claude plugin eval` refuses a case that grants Bash on a machine where its sandbox cannot exclude the credential stores. Then run the audit case by hand: copy `evals/audit-reinvented-app/project/` to a temporary folder, run `git init` there, start `claude --plugin-dir <plugin>` in that folder, and give it the prompt of `evals/audit-reinvented-app/prompt.md`. Compare `findings.md` with the answer key.

## Results

Measured on 2026-10-13 with Claude Code 2.1.296 and its default model. Each arm ran once or twice, so treat a small difference as noise.

| Case | With plugin | Without plugin | Runs per arm |
|---|---|---|---|
| `console-tool-lock` | 1.00 | 0.50 | 1 |
| `framework-app-8x-rules` | 1.00 | 0.88 | 2 |
| `flaky-api-retry` | 1.00 | 1.00 | 1 |
| `symfony-80-command-test` | 0.75 | 1.00 | 2 |
| `ignores-javascript-project` | 1.00, skill not loaded | 1.00 | 1 |
| `laravel-rate-limit` | 1.00 | 1.00 | 1 |

- `symfony-80-command-test`: the test code is correct in all runs. In one of two runs, the answer still names the newer `runCommand()` helper in one sentence, and the no-upgrade grader fails it.
- `router-accuracy`, run as a blind test with only the router text: top-1 103 of 105, top-3 105 of 105. With Claude Haiku: top-1 103 of 105, top-3 104 of 105. Both models send the Monolog goal to MonologBundle instead of Monolog Bridge, and the encrypted-secrets goal to Dotenv instead of FrameworkBundle.
- `audit-reinvented-app`, run by hand as described above: all 12 expected findings (12 CONFIRMED), no decoy as a finding, and 18 of 18 files read to the last line. The run took 9 minutes, with the subagents on Sonnet.
