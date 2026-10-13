# Symfony GitHub Organization: Repository Review

**Checked on:** 2026-10-09. **Updated on:** 2026-10-13: the MercureBundle row, the version cells of the five repositories whose package name differs from the repository name, and the two ACL rows. **Sources:** the repository list at https://github.com/orgs/symfony/repositories (449 repositories, all 15 pages read) and the Packagist metadata API (`https://repo.packagist.org/p2/symfony/<name>.json`) for each repository name.

This file tells you which repositories get a package in `skills/component-guide-for-symfony/` (a triage file in `packages/` and a details file in `details/`), which ones a parent package covers, and which ones are out of scope (unreleased, abandoned, legacy, or not a Composer package).

The "Released" column gives the Packagist release date of the split package. A split package gets a new tag only when its code changes, so a package file can describe a later symfony/symfony tag with the same code. [verification.md](verification.md) gives the exact versions that each package file was checked against.

## Summary

| Category | Repositories | Treatment |
|---|---|---|
| Own catalogue file | 126 | One triage file and one details file in `skills/component-guide-for-symfony/`. Some files cover more than one repository. |
| Covered in a parent file | 241 | Bridges, packs and polyfills. The file of the parent package lists them. |
| Unreleased | 25 | Out of scope: no stable release yet. Recheck after Symfony 8.2 (November 2026) and the next UX release. |
| Abandoned or archived | 31 | Out of scope: abandoned on Packagist or archived on GitHub. Use the replacement. |
| Legacy | 4 | Out of scope: no release that works with Symfony 8.1. |
| Not a package | 22 | Out of scope: not a Composer package for applications (docs, websites, monorepos, tooling). |
| **Total** | **449** | |

## 1. Repositories with their own catalogue file

| Repository | Latest stable | Released | Catalogue file |
|---|---|---|---|
| [ai-agent](https://github.com/symfony/ai-agent) | v0.14.1 | 2026-09-26 | `ai-agent.md` |
| [ai-bundle](https://github.com/symfony/ai-bundle) | v0.14.1 | 2026-09-26 | `ai-bundle.md` |
| [ai-chat](https://github.com/symfony/ai-chat) | v0.14.0 | 2026-09-24 | `ai-chat.md` |
| [ai-mate](https://github.com/symfony/ai-mate) | v0.14.0 | 2026-09-25 | `ai-mate.md` |
| [ai-mate-composer-plugin](https://github.com/symfony/ai-mate-composer-plugin) | v0.14.0 | 2026-09-24 | `ai-mate.md` |
| [ai-monolog-mate-extension](https://github.com/symfony/ai-monolog-mate-extension) | v0.14.0 | 2026-09-25 | `ai-mate.md` |
| [ai-symfony-mate-extension](https://github.com/symfony/ai-symfony-mate-extension) | v0.14.0 | 2026-09-24 | `ai-mate.md` |
| [ai-platform](https://github.com/symfony/ai-platform) | v0.14.1 | 2026-09-26 | `ai-platform.md` |
| [models-dev](https://github.com/symfony/models-dev) | v186.0 | 2026-10-08 | `ai-platform.md` |
| [ai-store](https://github.com/symfony/ai-store) | v0.14.0 | 2026-09-24 | `ai-store.md` |
| [asset](https://github.com/symfony/asset) | v8.1.0 | 2026-05-29 | `asset.md` |
| [asset-mapper](https://github.com/symfony/asset-mapper) | v8.1.8 | 2026-09-24 | `asset-mapper.md` |
| [browser-kit](https://github.com/symfony/browser-kit) | v8.1.5 | 2026-08-21 | `browser-kit.md` |
| [cache](https://github.com/symfony/cache) | v8.1.8 | 2026-09-29 | `cache.md` |
| [clock](https://github.com/symfony/clock) | v8.1.0 | 2026-05-29 | `clock.md` |
| [config](https://github.com/symfony/config) | v8.1.5 | 2026-08-20 | `config.md` |
| [console](https://github.com/symfony/console) | v8.1.8 | 2026-09-18 | `console.md` |
| [cache-contracts](https://github.com/symfony/cache-contracts) | v3.7.1 | 2026-06-05 | `contracts.md` |
| [contracts](https://github.com/symfony/contracts) | v3.7.3 | 2026-08-04 | `contracts.md` |
| [deprecation-contracts](https://github.com/symfony/deprecation-contracts) | v3.7.1 | 2026-06-05 | `contracts.md` |
| [event-dispatcher-contracts](https://github.com/symfony/event-dispatcher-contracts) | v3.7.1 | 2026-06-05 | `contracts.md` |
| [http-client-contracts](https://github.com/symfony/http-client-contracts) | v3.7.3 | 2026-08-04 | `contracts.md` |
| [service-contracts](https://github.com/symfony/service-contracts) | v3.7.3 | 2026-07-27 | `contracts.md` |
| [translation-contracts](https://github.com/symfony/translation-contracts) | v3.7.1 | 2026-06-05 | `contracts.md` |
| [css-selector](https://github.com/symfony/css-selector) | v8.1.6 | 2026-08-23 | `css-selector.md` |
| [debug-bundle](https://github.com/symfony/debug-bundle) | v8.1.0 | 2026-05-29 | `debug-bundle.md` |
| [dependency-injection](https://github.com/symfony/dependency-injection) | v8.1.8 | 2026-09-29 | `dependency-injection.md` |
| [doctrine-bridge](https://github.com/symfony/doctrine-bridge) | v8.1.8 | 2026-09-28 | `doctrine-bridge.md` |
| [dom-crawler](https://github.com/symfony/dom-crawler) | v8.1.5 | 2026-08-21 | `dom-crawler.md` |
| [dotenv](https://github.com/symfony/dotenv) | v8.1.6 | 2026-07-26 | `dotenv.md` |
| [emoji](https://github.com/symfony/emoji) | v8.1.0 | 2026-05-29 | `emoji.md` |
| [error-handler](https://github.com/symfony/error-handler) | v8.1.8 | 2026-09-22 | `error-handler.md` |
| [event-dispatcher](https://github.com/symfony/event-dispatcher) | v8.1.5 | 2026-08-21 | `event-dispatcher.md` |
| [expression-language](https://github.com/symfony/expression-language) | v8.1.6 | 2026-08-30 | `expression-language.md` |
| [filesystem](https://github.com/symfony/filesystem) | v8.1.6 | 2026-08-23 | `filesystem.md` |
| [finder](https://github.com/symfony/finder) | v8.1.8 | 2026-09-26 | `finder.md` |
| [flex](https://github.com/symfony/flex) | v2.11.0 | 2026-05-29 | `flex.md` |
| [skeleton](https://github.com/symfony/skeleton) | v8.1.99 | 2026-05-29 | `flex.md` |
| [form](https://github.com/symfony/form) | v8.1.8 | 2026-09-29 | `form.md` |
| [framework-bundle](https://github.com/symfony/framework-bundle) | v8.1.8 | 2026-09-28 | `framework-bundle.md` |
| [html-sanitizer](https://github.com/symfony/html-sanitizer) | v8.1.8 | 2026-09-28 | `html-sanitizer.md` |
| [amphp-http-client-meta](https://github.com/symfony/amphp-http-client-meta) | v2.0.0 | 2024-03-06 | `http-client.md` |
| [http-client](https://github.com/symfony/http-client) | v8.1.8 | 2026-09-24 | `http-client.md` |
| [http-foundation](https://github.com/symfony/http-foundation) | v8.1.8 | 2026-09-24 | `http-foundation.md` |
| [http-kernel](https://github.com/symfony/http-kernel) | v8.1.8 | 2026-09-29 | `http-kernel.md` |
| [intl](https://github.com/symfony/intl) | v8.1.5 | 2026-08-21 | `intl.md` |
| [json-path](https://github.com/symfony/json-path) | v8.1.2 | 2026-07-29 | `json-path.md` |
| [json-streamer](https://github.com/symfony/json-streamer) | v8.1.8 | 2026-09-28 | `json-streamer.md` |
| [language-tools](https://github.com/symfony/language-tools) | v0.23.0 (GitHub release; `symfony/lsp` is not on Packagist) | 2026-09-26 | `language-tools.md` |
| [ldap](https://github.com/symfony/ldap) | v8.1.0 | 2026-05-29 | `ldap.md` |
| [dynamo-db-lock](https://github.com/symfony/dynamo-db-lock) | v8.1.6 (`symfony/amazon-dynamo-db-lock`) | 2026-08-30 | `lock.md` |
| [lock](https://github.com/symfony/lock) | v8.1.8 | 2026-09-18 | `lock.md` |
| [mailer](https://github.com/symfony/mailer) | v8.1.7 | 2026-09-15 | `mailer.md` |
| [maker-bundle](https://github.com/symfony/maker-bundle) | 1.68.0 | 2026-09-12 | `maker-bundle.md` |
| [mcp-bundle](https://github.com/symfony/mcp-bundle) | v0.14.1 | 2026-09-26 | `mcp-bundle.md` |
| [mercure](https://github.com/symfony/mercure) | v0.9.0 | 2026-10-07 | `mercure.md` |
| [mercure-bundle](https://github.com/symfony/mercure-bundle) | v0.6.1 | 2026-10-11 | `mercure.md` |
| [messenger](https://github.com/symfony/messenger) | v8.1.8 | 2026-09-29 | `messenger.md` |
| [mime](https://github.com/symfony/mime) | v8.1.7 | 2026-09-04 | `mime.md` |
| [monolog-bridge](https://github.com/symfony/monolog-bridge) | v8.1.6 | 2026-08-30 | `monolog-bridge.md` |
| [monolog-bundle](https://github.com/symfony/monolog-bundle) | v4.1.0 | 2026-09-10 | `monolog-bundle.md` |
| [notifier](https://github.com/symfony/notifier) | v8.1.5 | 2026-08-21 | `notifier.md` |
| [object-mapper](https://github.com/symfony/object-mapper) | v8.1.8 | 2026-09-28 | `object-mapper.md` |
| [options-resolver](https://github.com/symfony/options-resolver) | v8.1.0 | 2026-05-29 | `options-resolver.md` |
| [panther](https://github.com/symfony/panther) | v2.4.0 | 2026-01-08 | `panther.md` |
| [password-hasher](https://github.com/symfony/password-hasher) | v8.1.0 | 2026-05-29 | `password-hasher.md` |
| [phpunit-bridge](https://github.com/symfony/phpunit-bridge) | v8.1.6 | 2026-08-30 | `phpunit-bridge.md` |
| [polyfill](https://github.com/symfony/polyfill) | v1.43.1 | 2026-10-07 | `polyfill.md` |
| [polyfill-deepclone](https://github.com/symfony/polyfill-deepclone) | v1.43.1 | 2026-10-06 | `polyfill.md` |
| [process](https://github.com/symfony/process) | v8.1.7 | 2026-09-02 | `process.md` |
| [property-access](https://github.com/symfony/property-access) | v8.1.4 | 2026-07-30 | `property-access.md` |
| [property-info](https://github.com/symfony/property-info) | v8.1.8 | 2026-09-28 | `property-info.md` |
| [psr-http-message-bridge](https://github.com/symfony/psr-http-message-bridge) | v8.1.0 | 2026-05-29 | `psr-http-message-bridge.md` |
| [rate-limiter](https://github.com/symfony/rate-limiter) | v8.1.6 | 2026-08-07 | `rate-limiter.md` |
| [remote-event](https://github.com/symfony/remote-event) | v8.1.0 | 2026-05-29 | `remote-event.md` |
| [reprise](https://github.com/symfony/reprise) | v1.3.0 | 2026-09-26 | `reprise.md` |
| [requirements-checker](https://github.com/symfony/requirements-checker) | v2.0.3 | 2024-11-14 | `requirements-checker.md` |
| [routing](https://github.com/symfony/routing) | v8.1.8 | 2026-09-28 | `routing.md` |
| [runtime](https://github.com/symfony/runtime) | v8.1.0 | 2026-05-29 | `runtime.md` |
| [scheduler](https://github.com/symfony/scheduler) | v8.1.8 | 2026-09-26 | `scheduler.md` |
| [security-bundle](https://github.com/symfony/security-bundle) | v8.1.8 | 2026-09-24 | `security-bundle.md` |
| [security-core](https://github.com/symfony/security-core) | v8.1.8 | 2026-09-28 | `security-bundle.md` |
| [security-http](https://github.com/symfony/security-http) | v8.1.8 | 2026-09-28 | `security-bundle.md` |
| [security-csrf](https://github.com/symfony/security-csrf) | v8.1.0 | 2026-05-29 | `security-csrf.md` |
| [semaphore](https://github.com/symfony/semaphore) | v8.1.6 | 2026-08-30 | `semaphore.md` |
| [serializer](https://github.com/symfony/serializer) | v8.1.8 | 2026-09-28 | `serializer.md` |
| [stimulus-bridge](https://github.com/symfony/stimulus-bridge) | 4.0.1 (npm `@symfony/stimulus-bridge`) | 2025-04-18 | `stimulus-bundle.md` |
| [stimulus-bundle](https://github.com/symfony/stimulus-bundle) | v3.5.1 | 2026-09-19 | `stimulus-bundle.md` |
| [stopwatch](https://github.com/symfony/stopwatch) | v8.1.0 | 2026-05-29 | `stopwatch.md` |
| [string](https://github.com/symfony/string) | v8.1.7 | 2026-09-11 | `string.md` |
| [translation](https://github.com/symfony/translation) | v8.1.5 | 2026-08-21 | `translation.md` |
| [tui](https://github.com/symfony/tui) | v8.1.8 | 2026-09-28 | `tui.md` |
| [twig-bridge](https://github.com/symfony/twig-bridge) | v8.1.7 | 2026-09-14 | `twig-bridge.md` |
| [twig-bundle](https://github.com/symfony/twig-bundle) | v8.1.7 | 2026-09-11 | `twig-bundle.md` |
| [type-info](https://github.com/symfony/type-info) | v8.1.8 | 2026-09-28 | `type-info.md` |
| [uid](https://github.com/symfony/uid) | v8.1.8 | 2026-09-23 | `uid.md` |
| [ux-autocomplete](https://github.com/symfony/ux-autocomplete) | v3.5.1 | 2026-09-19 | `ux-autocomplete.md` |
| [ux-calendar-link](https://github.com/symfony/ux-calendar-link) | v3.5.1 | 2026-09-08 | `ux-calendar-link.md` |
| [ux-chartjs](https://github.com/symfony/ux-chartjs) | v3.5.1 | 2026-09-19 | `ux-chartjs.md` |
| [ux-cropperjs](https://github.com/symfony/ux-cropperjs) | v3.5.1 | 2026-09-19 | `ux-cropperjs.md` |
| [ux-dropzone](https://github.com/symfony/ux-dropzone) | v3.5.1 | 2026-09-19 | `ux-dropzone.md` |
| [ux-icons](https://github.com/symfony/ux-icons) | v3.5.1 | 2026-09-18 | `ux-icons.md` |
| [ux-live-component](https://github.com/symfony/ux-live-component) | v3.5.1 | 2026-09-19 | `ux-live-component.md` |
| [ux-google-map](https://github.com/symfony/ux-google-map) | v3.5.1 | 2026-09-19 | `ux-map.md` |
| [ux-leaflet-map](https://github.com/symfony/ux-leaflet-map) | v3.5.1 | 2026-09-19 | `ux-map.md` |
| [ux-map](https://github.com/symfony/ux-map) | v3.5.1 | 2026-09-19 | `ux-map.md` |
| [ux-native](https://github.com/symfony/ux-native) | v3.5.1 | 2026-09-19 | `ux-native.md` |
| [ux-notify](https://github.com/symfony/ux-notify) | v3.5.1 | 2026-09-19 | `ux-notify.md` |
| [ux-pagination](https://github.com/symfony/ux-pagination) | v3.5.1 | 2026-09-19 | `ux-pagination.md` |
| [ux-react](https://github.com/symfony/ux-react) | v3.5.1 | 2026-09-19 | `ux-react.md` |
| [ux-toolkit](https://github.com/symfony/ux-toolkit) | v3.5.1 | 2026-09-19 | `ux-toolkit.md` |
| [ux-translator](https://github.com/symfony/ux-translator) | v3.5.1 | 2026-09-19 | `ux-translator.md` |
| [ux-turbo](https://github.com/symfony/ux-turbo) | v3.5.1 | 2026-09-19 | `ux-turbo.md` |
| [ux-twig-component](https://github.com/symfony/ux-twig-component) | v3.5.1 | 2026-09-18 | `ux-twig-component.md` |
| [ux-vue](https://github.com/symfony/ux-vue) | v3.5.1 | 2026-09-19 | `ux-vue.md` |
| [validator](https://github.com/symfony/validator) | v8.1.8 | 2026-09-29 | `validator.md` |
| [var-dumper](https://github.com/symfony/var-dumper) | v8.1.7 | 2026-09-03 | `var-dumper.md` |
| [php-ext-deepclone](https://github.com/symfony/php-ext-deepclone) | v0.8.8 (`symfony/deepclone`) | 2026-10-07 | `var-exporter.md` |
| [var-exporter](https://github.com/symfony/var-exporter) | v8.1.6 | 2026-08-29 | `var-exporter.md` |
| [web-link](https://github.com/symfony/web-link) | v8.1.0 | 2026-05-29 | `web-link.md` |
| [web-profiler-bundle](https://github.com/symfony/web-profiler-bundle) | v8.1.8 | 2026-09-28 | `web-profiler-bundle.md` |
| [webhook](https://github.com/symfony/webhook) | v8.1.7 | 2026-08-31 | `webhook.md` |
| [webpack-encore](https://github.com/symfony/webpack-encore) | 7.2.0 (npm `@symfony/webpack-encore`) | 2026-07-26 | `webpack-encore-bundle.md` |
| [webpack-encore-bundle](https://github.com/symfony/webpack-encore-bundle) | 2.4.2 | 2026-09-17 | `webpack-encore-bundle.md` |
| [workflow](https://github.com/symfony/workflow) | v8.1.8 | 2026-09-21 | `workflow.md` |
| [yaml](https://github.com/symfony/yaml) | v8.1.8 | 2026-09-26 | `yaml.md` |

Two catalogue files have no repository of their own: `framework-bundle-testing.md` (the test tools of `symfony/framework-bundle`) and `ux-abandoned.md` (the abandoned UX packages).

## 2. Repositories covered in a parent file

**`ai-agent.md`** (14): `ai-brave-tool`, `ai-clock-tool`, `ai-filesystem-tool`, `ai-firecrawl-tool`, `ai-mapbox-tool`, `ai-mcp-tool`, `ai-ollama-tool`, `ai-open-meteo-tool`, `ai-scraper-tool`, `ai-serp-api-tool`, `ai-similarity-search-tool`, `ai-tavily-tool`, `ai-wikipedia-tool`, `ai-youtube-tool`

**`ai-chat.md`** (9): `ai-cache-message-store`, `ai-cloudflare-message-store`, `ai-doctrine-message-store`, `ai-meilisearch-message-store`, `ai-mongo-db-message-store`, `ai-pogocache-message-store`, `ai-redis-message-store`, `ai-session-message-store`, `ai-surreal-db-message-store`

**`ai-platform.md`** (43): `ai-ai-ml-api-platform`, `ai-albert-platform`, `ai-amazee-ai-platform`, `ai-anthropic-platform`, `ai-azure-platform`, `ai-bedrock-platform`, `ai-cache-platform`, `ai-cartesia-platform`, `ai-cerebras-platform`, `ai-claude-code-platform`, `ai-codex-platform`, `ai-cohere-platform`, `ai-decart-platform`, `ai-deep-seek-platform`, `ai-deepgram-platform`, `ai-docker-model-runner-platform`, `ai-eden-ai-platform`, `ai-eleven-labs-platform`, `ai-failover-platform`, `ai-fireworks-platform`, `ai-gemini-platform`, `ai-generic-platform`, `ai-higgsfield-platform`, `ai-hugging-face-platform`, `ai-lm-studio-platform`, `ai-meta-platform`, `ai-mini-max-platform`, `ai-mistral-platform`, `ai-models-dev-platform`, `ai-ollama-platform`, `ai-open-ai-platform`, `ai-open-responses-platform`, `ai-open-router-platform`, `ai-ovh-platform`, `ai-perplexity-platform`, `ai-replicate-platform`, `ai-scaleway-platform`, `ai-together-platform`, `ai-transformers-php-platform`, `ai-type-safe-platform`, `ai-venice-platform`, `ai-vertex-ai-platform`, `ai-voyage-platform`

**`ai-store.md`** (24): `ai-azure-search-store`, `ai-cache-store`, `ai-chroma-db-store`, `ai-click-house-store`, `ai-cloudflare-store`, `ai-elasticsearch-store`, `ai-manticore-search-store`, `ai-maria-db-store`, `ai-meilisearch-store`, `ai-milvus-store`, `ai-mongo-db-store`, `ai-neo4j-store`, `ai-open-search-store`, `ai-pinecone-store`, `ai-postgres-store`, `ai-qdrant-store`, `ai-redis-store`, `ai-s3vectors-store`, `ai-sqlite-store`, `ai-supabase-store`, `ai-surreal-db-store`, `ai-typesense-store`, `ai-vektor-store`, `ai-weaviate-store`

**`flex.md`** (11): `amqp-pack`, `apache-pack`, `debug-pack`, `orm-pack`, `platformsh-pack`, `profiler-pack`, `psr7-pack`, `serializer-pack`, `test-pack`, `twig-pack`, `webapp-pack`

**`mailer.md`** (20): `aha-send-mailer`, `amazon-mailer`, `azure-mailer`, `brevo-mailer`, `google-mailer`, `infobip-mailer`, `mail-pace-mailer`, `mailchimp-mailer`, `mailer-send-mailer`, `mailgun-mailer`, `mailjet-mailer`, `mailomat-mailer`, `mailtrap-mailer`, `microsoft-graph-mailer`, `postal-mailer`, `postmark-mailer`, `resend-mailer`, `scaleway-mailer`, `sendgrid-mailer`, `sweego-mailer`

**`messenger.md`** (5): `amazon-sqs-messenger`, `amqp-messenger`, `beanstalkd-messenger`, `doctrine-messenger`, `redis-messenger`

**`notifier.md`** (83): `all-my-sms-notifier`, `amazon-sns-notifier`, `bandwidth-notifier`, `bluesky-notifier`, `brevo-notifier`, `chatwork-notifier`, `click-send-notifier`, `clickatell-notifier`, `contact-everyone-notifier`, `discord-notifier`, `engagespot-notifier`, `esendex-notifier`, `expo-notifier`, `fake-chat-notifier`, `fake-sms-notifier`, `firebase-notifier`, `forty-six-elks-notifier`, `free-mobile-notifier`, `gateway-api-notifier`, `go-ip-notifier`, `google-chat-notifier`, `infobip-notifier`, `iqsms-notifier`, `isendpro-notifier`, `joli-notif-notifier`, `kaz-info-teh-notifier`, `light-sms-notifier`, `line-bot-notifier`, `line-notify-notifier`, `linked-in-notifier`, `lox24-notifier`, `mailjet-notifier`, `mastodon-notifier`, `matrix-notifier`, `mattermost-notifier`, `mercure-notifier`, `message-bird-notifier`, `message-media-notifier`, `microsoft-teams-notifier`, `mobyt-notifier`, `novu-notifier`, `ntfy-notifier`, `octopush-notifier`, `one-signal-notifier`, `orange-sms-notifier`, `ovh-cloud-notifier`, `pager-duty-notifier`, `plivo-notifier`, `prelude-notifier`, `primotexto-notifier`, `pushover-notifier`, `pushy-notifier`, `redlink-notifier`, `ring-central-notifier`, `rocket-chat-notifier`, `sendberry-notifier`, `sendinblue-notifier`, `sevenio-notifier`, `simple-textin-notifier`, `sinch-notifier`, `sipgate-notifier`, `slack-notifier`, `sms-biuras-notifier`, `sms-factor-notifier`, `sms-sluzba-notifier`, `smsapi-notifier`, `smsbox-notifier`, `smsc-notifier`, `smsense-notifier`, `smsmode-notifier`, `spot-hit-notifier`, `sweego-notifier`, `telegram-notifier`, `telnyx-notifier`, `termii-notifier`, `turbo-sms-notifier`, `twilio-notifier`, `twitter-notifier`, `unifonic-notifier`, `vonage-notifier`, `yunpian-notifier`, `zendesk-notifier`, `zulip-notifier`

**`polyfill.md`** (28): `polyfill-apcu`, `polyfill-ctype`, `polyfill-iconv`, `polyfill-intl-grapheme`, `polyfill-intl-icu`, `polyfill-intl-idn`, `polyfill-intl-messageformatter`, `polyfill-intl-normalizer`, `polyfill-io-poll`, `polyfill-mbstring`, `polyfill-php54`, `polyfill-php55`, `polyfill-php56`, `polyfill-php70`, `polyfill-php71`, `polyfill-php72`, `polyfill-php73`, `polyfill-php74`, `polyfill-php80`, `polyfill-php81`, `polyfill-php82`, `polyfill-php83`, `polyfill-php84`, `polyfill-php85`, `polyfill-php86`, `polyfill-time`, `polyfill-util`, `polyfill-uuid`

**`translation.md`** (4): `crowdin-translation-provider`, `loco-translation-provider`, `lokalise-translation-provider`, `phrase-translation-provider`

## 3. Unreleased (no stable version on Packagist)

| Repository | Packagist versions | Note |
|---|---|---|
| [amp-sql-messenger](https://github.com/symfony/amp-sql-messenger) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |
| [aws-key-management](https://github.com/symfony/aws-key-management) | 8.2.x-dev | Key Management component or one of its bridges: "Abstracts Key Management Systems (AWS KMS, Azure Key Vault, Google Cloud KMS, HashiCorp Vault Transit, KMIP, ...) behind a single interface" (GitHub description). |
| [azure-keyvault-key-management](https://github.com/symfony/azure-keyvault-key-management) | 8.2.x-dev | Key Management component or one of its bridges: "Abstracts Key Management Systems (AWS KMS, Azure Key Vault, Google Cloud KMS, HashiCorp Vault Transit, KMIP, ...) behind a single interface" (GitHub description). |
| [cloudflare-mailer](https://github.com/symfony/cloudflare-mailer) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |
| [doctrine-dbal-key-management](https://github.com/symfony/doctrine-dbal-key-management) | 8.2.x-dev | Key Management component or one of its bridges: "Abstracts Key Management Systems (AWS KMS, Azure Key Vault, Google Cloud KMS, HashiCorp Vault Transit, KMIP, ...) behind a single interface" (GitHub description). |
| [doctrine-orm-key-management](https://github.com/symfony/doctrine-orm-key-management) | 8.2.x-dev | Key Management component or one of its bridges: "Abstracts Key Management Systems (AWS KMS, Azure Key Vault, Google Cloud KMS, HashiCorp Vault Transit, KMIP, ...) behind a single interface" (GitHub description). |
| [facebook-page-notifier](https://github.com/symfony/facebook-page-notifier) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |
| [flysystem-key-management](https://github.com/symfony/flysystem-key-management) | 8.2.x-dev | Key Management component or one of its bridges: "Abstracts Key Management Systems (AWS KMS, Azure Key Vault, Google Cloud KMS, HashiCorp Vault Transit, KMIP, ...) behind a single interface" (GitHub description). |
| [google-cloud-key-management](https://github.com/symfony/google-cloud-key-management) | 8.2.x-dev | Key Management component or one of its bridges: "Abstracts Key Management Systems (AWS KMS, Azure Key Vault, Google Cloud KMS, HashiCorp Vault Transit, KMIP, ...) behind a single interface" (GitHub description). |
| [hashicorp-vault-key-management](https://github.com/symfony/hashicorp-vault-key-management) | 8.2.x-dev | Key Management component or one of its bridges: "Abstracts Key Management Systems (AWS KMS, Azure Key Vault, Google Cloud KMS, HashiCorp Vault Transit, KMIP, ...) behind a single interface" (GitHub description). |
| [instagram-notifier](https://github.com/symfony/instagram-notifier) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |
| [key-management](https://github.com/symfony/key-management) | 8.2.x-dev | Key Management component or one of its bridges: "Abstracts Key Management Systems (AWS KMS, Azure Key Vault, Google Cloud KMS, HashiCorp Vault Transit, KMIP, ...) behind a single interface" (GitHub description). |
| [kmip-key-management](https://github.com/symfony/kmip-key-management) | 8.2.x-dev | Key Management component or one of its bridges: "Abstracts Key Management Systems (AWS KMS, Azure Key Vault, Google Cloud KMS, HashiCorp Vault Transit, KMIP, ...) behind a single interface" (GitHub description). |
| [mail-kite-mailer](https://github.com/symfony/mail-kite-mailer) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |
| [mongodb-messenger](https://github.com/symfony/mongodb-messenger) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |
| [po-editor-translation-provider](https://github.com/symfony/po-editor-translation-provider) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |
| [puffer-post-mailer](https://github.com/symfony/puffer-post-mailer) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |
| [sms-proxima-notifier](https://github.com/symfony/sms-proxima-notifier) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |
| [threads-notifier](https://github.com/symfony/threads-notifier) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |
| [turbo-smtp-mailer](https://github.com/symfony/turbo-smtp-mailer) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |
| [ux-cloudflare-image](https://github.com/symfony/ux-cloudflare-image) | 3.x-dev | "Responsive images for Symfony, delivered through URL-based image providers" (GitHub description of `ux-image`) or one of its provider bridges. |
| [ux-image](https://github.com/symfony/ux-image) | 3.x-dev | "Responsive images for Symfony, delivered through URL-based image providers" (GitHub description of `ux-image`) or one of its provider bridges. |
| [ux-inspector](https://github.com/symfony/ux-inspector) | 3.x-dev | "Browser inspector for Symfony UX components: Stimulus, LiveComponent and Turbo" (GitHub description). |
| [ux-keycdn-image](https://github.com/symfony/ux-keycdn-image) | 3.x-dev | "Responsive images for Symfony, delivered through URL-based image providers" (GitHub description of `ux-image`) or one of its provider bridges. |
| [whats-app-notifier](https://github.com/symfony/whats-app-notifier) | 8.2.x-dev | Only `8.2.x-dev` exists. The bridge is not in a stable release yet. |

## 4. Abandoned or archived

| Repository | Last stable | Released | Replacement or note |
|---|---|---|---|
| [assetic-bundle](https://github.com/symfony/assetic-bundle) | v2.8.2 | 2017-07-14 | Abandoned on Packagist; replacement: symfony/webpack-encore-pack. |
| [class-loader](https://github.com/symfony/class-loader) | v3.4.47 | 2020-10-24 | Abandoned on Packagist; replacement: none named. |
| [debug](https://github.com/symfony/debug) | v4.4.44 | 2022-07-28 | Abandoned on Packagist; replacement: symfony/error-handler. |
| [force-lowest](https://github.com/symfony/force-lowest) | v4.2.0 | 2018-05-09 | Abandoned on Packagist; replacement: symfony/flex. |
| [gitter-notifier](https://github.com/symfony/gitter-notifier) | v7.1.6 | 2024-09-25 | Abandoned on Packagist; replacement: none named. |
| [icu](https://github.com/symfony/icu) | v1.2.2 | 2014-07-25 | Abandoned on Packagist; replacement: symfony/intl. |
| [inflector](https://github.com/symfony/inflector) | v5.4.47 | 2024-11-10 | Abandoned on Packagist; replacement: EnglishInflector from the String component. |
| [locale](https://github.com/symfony/locale) | v2.8.52 | 2018-11-11 | Abandoned on Packagist; replacement: symfony/intl. |
| [lts](https://github.com/symfony/lts) | v3 | 2017-10-19 | Abandoned on Packagist; replacement: symfony/flex. |
| [mcp-sdk](https://github.com/symfony/mcp-sdk) |  |  | Archived on GitHub; only dev-main on Packagist. The `symfony/mcp-bundle` description says it uses the official `mcp/sdk` instead. |
| [nexmo-notifier](https://github.com/symfony/nexmo-notifier) | v5.4.45 | 2024-09-25 | Abandoned on Packagist; replacement: symfony/vonage-notifier. |
| [oh-my-smtp-mailer](https://github.com/symfony/oh-my-smtp-mailer) | v6.4.35 | 2026-02-27 | Abandoned on Packagist; replacement: symfony/mail-pace-mailer. |
| [polyfill-xml](https://github.com/symfony/polyfill-xml) | v1.27.0 | 2022-11-03 | Abandoned on Packagist; replacement: symfony/polyfill-php72. |
| [propel1-bridge](https://github.com/symfony/propel1-bridge) | v2.6.13 | 2015-05-02 | Abandoned on Packagist; replacement: propel/propel-bundle. |
| [security](https://github.com/symfony/security) | v4.4.50 | 2023-01-24 | Abandoned on Packagist; replacement: none named. |
| [security-guard](https://github.com/symfony/security-guard) | v5.4.45 | 2024-09-25 | Abandoned on Packagist; replacement: none named. |
| [sendinblue-mailer](https://github.com/symfony/sendinblue-mailer) | v6.4.34 | 2026-02-25 | Abandoned on Packagist; replacement: symfony/brevo-mailer. |
| [sms77-notifier](https://github.com/symfony/sms77-notifier) | v7.4.17 | 2026-08-11 | Abandoned on Packagist; replacement: none named. |
| [swiftmailer-bridge](https://github.com/symfony/swiftmailer-bridge) | v2.8.52 | 2018-07-26 | Abandoned on Packagist; replacement: symfony/swiftmailer-bundle. |
| [swiftmailer-bundle](https://github.com/symfony/swiftmailer-bundle) | v3.5.4 | 2022-02-06 | Abandoned on Packagist; replacement: symfony/mailer. |
| [symfony-installer](https://github.com/symfony/symfony-installer) | v1.5.11 | 2018-04-01 | Abandoned on Packagist; replacement: none named. |
| [symfony1](https://github.com/symfony/symfony1) | 1.4.28 | 2018-04-10 | Abandoned on Packagist; replacement: none named. |
| [ux-lazy-image](https://github.com/symfony/ux-lazy-image) | v2.36.0 | 2026-05-06 | Abandoned on Packagist; replacement: none named. |
| [ux-svelte](https://github.com/symfony/ux-svelte) | v2.36.0 | 2026-05-06 | Abandoned on Packagist; replacement: none named. |
| [ux-swup](https://github.com/symfony/ux-swup) | v2.36.0 | 2026-05-06 | Abandoned on Packagist; replacement: none named. |
| [ux-toggle-password](https://github.com/symfony/ux-toggle-password) | v2.36.0 | 2026-05-06 | Abandoned on Packagist; replacement: none named. |
| [ux-turbo-mercure](https://github.com/symfony/ux-turbo-mercure) | v2.6.0 | 2022-11-22 | Abandoned on Packagist; replacement: none named. |
| [ux-typed](https://github.com/symfony/ux-typed) | v2.36.0 | 2026-05-06 | Abandoned on Packagist; replacement: none named. |
| [web-server-bundle](https://github.com/symfony/web-server-bundle) | v4.4.44 | 2022-06-27 | Abandoned on Packagist; replacement: none named. |
| [webapp-meta](https://github.com/symfony/webapp-meta) | v1.0.0 | 2021-10-20 | Abandoned on Packagist; replacement: none named. |
| [website-skeleton](https://github.com/symfony/website-skeleton) | v6.1.99 | 2022-06-15 | Abandoned on Packagist; replacement: symfony/webapp-pack. |

## 5. Legacy (no release that works with Symfony 8.1)

| Repository | Last stable | Note |
|---|---|---|
| [proxy-manager-bridge](https://github.com/symfony/proxy-manager-bridge) | v6.4.28 | Last release v6.4.28 (2025-11-02); no Symfony 7 or 8 release. Lazy objects are in var-exporter.md. |
| [acl-bundle](https://github.com/symfony/acl-bundle) | v2.4.0 | Last release v2.4.0 (2024-04-24). Does not work with Symfony 8.1, and the Symfony 8.1 docs have no ACL page. For permissions on one object, use voters (security-bundle.md). |
| [security-acl](https://github.com/symfony/security-acl) | v3.4.0 | Last release v3.4.0 (2025-08-05). Does not work with Symfony 8.1. For permissions on one object, use voters (security-bundle.md). |
| [templating](https://github.com/symfony/templating) | v6.4.24 | Last release v6.4.24 (2025-07-10); no Symfony 7 or 8 release. Use Twig (twig-bundle.md). |

## 6. Not a Composer package for applications

| Repository | Note |
|---|---|
| [.github](https://github.com/symfony/.github) | Default GitHub templates. |
| [ai](https://github.com/symfony/ai) | Monorepo of the Symfony AI packages. Primary source for the AI files. |
| [ai-demo](https://github.com/symfony/ai-demo) | Symfony AI demo application (type project). |
| [binary-utils](https://github.com/symfony/binary-utils) | Binaries used by the Symfony test suite; "no guarantees". |
| [cli](https://github.com/symfony/cli) | Issue tracker of the Symfony CLI (archived). |
| [demo](https://github.com/symfony/demo) | Demo application. |
| [intl-data](https://github.com/symfony/intl-data) | ICU data in the resource bundle formats for ICU 4.x (README). Not on Packagist. |
| [marketing](https://github.com/symfony/marketing) | symfony.com content. |
| [psr7-meta](https://github.com/symfony/psr7-meta) | Metapackage; no code. |
| [recipes](https://github.com/symfony/recipes) | Flex recipes (official). See flex.md. |
| [recipes-contrib](https://github.com/symfony/recipes-contrib) | Flex recipes (community). See flex.md. |
| [rst-parser](https://github.com/symfony/rst-parser) | No description on GitHub. Not on Packagist. |
| [stimulus-testing](https://github.com/symfony/stimulus-testing) | "Testing-library integration for Symfony UX" (GitHub description). Archived. |
| [symfony](https://github.com/symfony/symfony) | Monorepo of all components, bundles and bridges. It is also the `symfony/symfony` package. setup/flex.rst tells you to remove `symfony/symfony` from `composer.json` and require single packages through Flex. |
| [symfony-docs](https://github.com/symfony/symfony-docs) | Source of the official documentation (symfony.com/doc). Primary source for this catalogue. |
| [symfony-hello-world](https://github.com/symfony/symfony-hello-world) | Hello World Edition (archived). |
| [symfony-standard](https://github.com/symfony/symfony-standard) | Symfony Standard Edition (archived). |
| [symfony1-docs](https://github.com/symfony/symfony1-docs) | symfony 1.x docs (archived). |
| [thanks](https://github.com/symfony/thanks) | Composer plugin to star dependencies on GitHub; tooling only. |
| [the-fast-track](https://github.com/symfony/the-fast-track) | No description on GitHub. Not on Packagist. |
| [ux](https://github.com/symfony/ux) | Monorepo of the Symfony UX packages. Primary source for the UX files. |
| [ux.symfony.com](https://github.com/symfony/ux.symfony.com) | Website of Symfony UX. |
