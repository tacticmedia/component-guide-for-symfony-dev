---
max_turns: 20
allowed_tools: [Read, Glob, Grep, Skill]
---

Our queue worker calls the HTTP API of a partner, and that API often fails with a 502 or a 503 error for a few seconds. Make the calls try again with an increasing delay before they give up. Show the code and the configuration.
