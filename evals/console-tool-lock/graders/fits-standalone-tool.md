---
type: llm
---

PASS if the answer makes the import command use Symfony Lock, through `LockableTrait` or a `LockFactory` with a store created in code, and returns early when the lock is taken.
FAIL if the answer writes its own lock file with `fopen`, `flock`, `file_exists` or `touch` as the solution.
FAIL if the answer tells the user to add `framework.lock` configuration or to install FrameworkBundle, because the tool has no FrameworkBundle.
