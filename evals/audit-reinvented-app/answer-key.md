# Answer key: audit-reinvented-app

The graders of this case check each line below. Run the case with:

```bash
claude plugin eval . --case audit-reinvented-app --runs 1 --ablation none --scaffold --trust-plugin --allow-tools Write "Bash(bash *)" "Bash(git *)" "Bash(mkdir *)" "Bash(cp *)" "Bash(cat *)"
```

## Reinvented feature

| File | Package | Replacement |
|---|---|---|
| `src/Service/ImportLock.php` | lock | `LockFactory`, or `LockableTrait` in the command |
| `src/Service/PartnerApiClient.php` | http-client | `HttpClientInterface` with `RetryableHttpClient` |
| `src/Util/Slugger.php` | string | `AsciiSlugger` |
| `src/Util/UuidGenerator.php` | uid | `Uuid::v4()` or `Uuid::v7()` |
| `src/Security/LoginThrottle.php` | security-bundle, rate-limiter | `login_throttling` on the firewall |
| `src/Util/HtmlCleaner.php` | html-sanitizer | `HtmlSanitizer` |
| `src/Config/EnvLoader.php` | dotenv | `Dotenv::bootEnv()`, or the Runtime component |

## Outdated API use

| File | Package | Current API |
|---|---|---|
| `src/Controller/ProductController.php` | routing | `Symfony\Component\Routing\Attribute\Route` |
| `src/Controller/ProductController.php` | http-foundation | `$request->query->get('page')` |
| `src/Entity/User.php` | security-bundle | no `eraseCredentials()`, `__serialize()` |
| `src/Dto/SignUp.php` | validator | named arguments, `Length(min: 3, max: 50)` |
| `config/packages/framework.php` | framework-bundle | YAML, or `App::config([...])` |

## Decoys (no finding)

- `src/Service/PriceCalculator.php`: business rules.
- `src/Command/ReportCommand.php`: a correct invokable command.
- `src/Service/WelcomeMailer.php`: correct Mailer use.
