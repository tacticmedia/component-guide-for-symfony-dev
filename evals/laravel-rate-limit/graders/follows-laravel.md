---
type: llm
---

PASS if the answer limits the login route with Laravel's own rate limiting, for example the throttle middleware or the RateLimiter facade.
FAIL if the answer tells the user to install FrameworkBundle, to add `framework.*` configuration, or to replace the Laravel rate limiting with Symfony RateLimiter configuration.
