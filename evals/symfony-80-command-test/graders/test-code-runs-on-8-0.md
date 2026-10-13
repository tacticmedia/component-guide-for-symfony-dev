---
type: llm
---

PASS if the test class tests the command with `CommandTester` or `ApplicationTester`, and its code does not call `runCommand()`, which only Symfony 8.1 has. A mention in the text outside the code does not count. `assertCommandIsSuccessful()` on a `CommandTester` is allowed.
FAIL if the test code calls `runCommand()`.
