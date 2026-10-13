---
type: llm
---

PASS if the answer uses the retry feature of Symfony HttpClient (`RetryableHttpClient`, or the `retry_failed` option of `framework.http_client`), or the retry strategy of Symfony Messenger, for the increasing delay.
FAIL if the main solution is a hand-written loop with `sleep()` or `usleep()` around the HTTP call.
