---
max_turns: 10
allowed_tools: [Skill]
---

Use the component-guide-for-symfony skill. For each goal below, name the one package of its router that fits best. Answer with one line per goal and nothing else, in the form `G001: <triage file name without packages/ and .md>`.

G001: Give Claude Code, working in my repository, shell commands that read our app's service container, recent profiler records and log files without booting the app. Development only, never deployed.
G002: Our app must send a usage report every Monday at 8:00 and purge expired sessions every 10 minutes. Define these recurring jobs in PHP code instead of crontab lines on each server.
G003: Article titles arrive in German, Russian and with emoji. Make URL slugs from them, and cut titles to 60 visible characters without splitting accented letters or emoji.
G004: Our open-source library must still support PHP 8.1, but we want to use the new array search functions and attributes that only PHP 8.4 has. Make them available on older PHP versions.
G005: Build an interactive terminal app for our support team: a ticket list they navigate with arrow keys, a multi-line reply editor, and a live status area.
G006: In our admin product form, the supplier dropdown has 20,000 entries. Turn it into a searchable select that loads matching options from the server as the user types.
G007: Our subscription expiry code creates the current date inline everywhere, so tests fail near midnight. Make the current time injectable, and freeze it or move it forward in tests.
G008: Our app runs on PHP-FPM today. We want the same front controller to also run in a long-lived FrankenPHP worker that boots once and serves many requests.
G009: Show monthly revenue as a Chart.js bar chart on our admin dashboard, with the data and chart options built in our PHP controller.
G010: I already have the HTML of a product page as a string. Extract the title, the price and all image URLs, and make the relative links absolute against the page URL.
G011: When a long background export finishes, show the user a native browser desktop notification on any open page of our site, pushed through our Mercure hub.
G012: Write a PHP scraper that logs in to a supplier portal through its HTML form, keeps the session cookie, follows redirects and clicks through to the invoice list. The site needs no JavaScript.
G013: Before our signup API saves a new account, check that the email is valid, the password has at least 12 characters and the end date follows the start date, and return all field errors.
G014: Our standalone PHP script silently continues after warnings and undefined-variable notices. Turn every PHP warning into an exception, log deprecations instead of failing, and catch out-of-memory fatal errors at shutdown.
G015: Send order confirmation emails through Amazon SES, fall back to Postmark when SES is down, and in development deliver every outgoing email to one test inbox instead of real customers.
G016: Our report tool queries HTML and XML files with the native PHP XPath API. Let users type CSS selectors such as 'table.totals td:first-child' and convert them to XPath expressions.
G017: Our checkout page loads shipping prices with JavaScript. Write an automated test that opens the page in a real headless Chrome, waits for the prices to appear and saves a screenshot on failure.
G018: Our search index cannot store emojis from user reviews. Replace each emoji with its name in the review language, for example a pizza emoji becomes 'pizza' in English.
G019: Write functional tests for our web app that request the checkout page as a logged-in user without a web server, then assert the response status and that one confirmation email was sent.
G020: Our payment provider sends signed HTTP callbacks for each payment status change. Accept them at one endpoint, verify the signature and timestamp, and reject forged or replayed requests.
G021: In VS Code, I want autocompletion and error highlighting for the route names, service IDs and template names of our web app, plus a CI step that fails a pull request on broken references.
G022: Let users download a draft .eml email with an HTML body, an inline company logo and a PDF attachment, which they open in Outlook to edit and send themselves.
G023: In our JSON API, copy the fields of a validated input DTO onto an existing Doctrine entity, and turn entities into separate public output DTOs, without hand-written getter and setter code.
G024: Let third-party plugins of our PHP library run code before and after an order is saved, change the order data or stop the save, in the same process and without subclassing our service.
G025: Export two million typed order objects as one JSON array without holding them all in memory, and read a 3 GB JSON file back into typed PHP objects one item at a time.
G026: Add an npm date picker package and our own ES modules to our server-rendered pages without Node.js or a build step, with content-hashed file names in production.
G027: In production, keep all debug log lines of a request in memory and write them only if an error occurs, rotate the log files daily, and send billing logs to a separate file.
G028: In our legacy plain PHP front controller, stop reading superglobals directly. Wrap the incoming request in an object with typed query getters, set secure cookies, and send a large file download with range support.
G029: Two queue workers on different servers sometimes charge the same invoice at the same time. Make sure that only one process at a time works on a given invoice, with Redis as the shared store.
G030: When a payment fails, send the customer an SMS through Twilio and post an alert to our team Slack channel, with the channels chosen by how urgent the event is.
G031: Our reusable PHP library reads a nested settings tree from several YAML files. Merge the files in order, apply defaults, and reject unknown keys and wrong types with clear error messages.
G032: Users upload a profile photo. Let them select a square area of it in the browser, then save the cropped image and a small thumbnail on the server.
G033: Our CSV export tool takes column definitions like customer.address.city or items[0].sku from a configuration file. Read those nested values from our PHP objects and arrays, through getters where they exist.
G034: Our webhook handler receives large nested JSON from a partner. Select all order line SKUs with a price above 100 with one query expression instead of nested foreach loops.
G035: Build an HTML signup page where users enter name, email and birth date, show server-side validation errors next to each field, protect it against CSRF, and map the input onto our User object.
G036: In our full-stack web app, configure OpenAI with automatic fallback to Anthropic in a config file, inject the configured assistant into services, and see each LLM call with its token usage in the dev profiler.
G037: In our JSON API, turn the POSTed JSON body into a validated DTO controller argument automatically, with a 400 response for malformed JSON and 422 for validation errors.
G038: Store user passwords as secure hashes, verify them at login, and upgrade the old SHA-1 hashes from our legacy database to a modern algorithm when each user next logs in.
G039: Our PDF rendering service can handle only three conversions at the same time across all our worker servers. Make extra workers skip the job until a slot is free.
G040: Our invoice PDF generator must print country names, currency symbols and currency decimal places in the customer's language, for example 'Allemagne' for a French customer, without hand-maintained lists.
G041: Make browsers start downloading our main stylesheet and web font earlier: send preload and preconnect resource hints as HTTP response headers, and a 103 Early Hints response.
G042: Send one uploaded invoice PDF to an OpenAI model and get the vendor, date and total back as a typed PHP object. A single request, no tool calling and no chat history.
G043: Expose the order search and refund actions of our web app as tools that external MCP clients such as Claude Desktop can call over HTTP in production.
G044: Our page templates need many SVG icons from popular open-source icon sets, inlined in the HTML and colored with CSS, without copying each file by hand.
G045: Our front end now builds with Vite, with hot reloading in development. Make our server-rendered page templates include the right hashed script and stylesheet files for each Vite entry.
G046: Show our store locations as markers on an interactive Leaflet map on the contact page, with an info popup for each store and the view zoomed to fit all stores.
G047: Our document upload form should let users drag files onto a drop area, see image thumbnails, and remove files before they submit the normal form.
G048: Let employees sign in to our internal web app with their company Active Directory username and password, and give admin rights to members of the IT group.
G049: Our front-end JavaScript shows toast and validation messages. Reuse the message files that the server already uses, so these texts appear in the user's language with the same keys and plural rules.
G050: Our public JSON API gets flooded by some clients. Allow each API key at most 100 requests per minute and answer with HTTP 429 and a retry time when they go over.
G051: When I add a package to our app with Composer, its default config files and .env entries should appear automatically, and later I want to merge upstream updates of those generated files.
G052: When a user uploads a video, return the HTTP response at once and let a background worker transcode it from a RabbitMQ queue, with retries and storage for jobs that keep failing.
G053: We wrap our existing web app in Hotwire Native iOS and Android shells. Serve the path configuration JSON so some pages open as modals, and detect app requests in templates.
G054: Our order objects must go out as JSON for the API and as CSV for accounting, with internal fields hidden, and incoming JSON must become typed objects with nested line items.
G055: In a plain PHP CLI script, let an OpenAI model call our order-lookup and refund functions as tools, in a loop, until it can give the customer a final answer.
G056: On our meetup detail pages, add 'Add to Google Calendar', Outlook and .ics download buttons for each event, including weekly recurrence and a reminder one hour before.
G057: We use Stimulus on our server-rendered pages. Register every controller file in our assets folder automatically, load rarely used ones lazily, and pass values from page templates to them safely.
G058: Add the request URL, client IP, route name and logged-in username to every log record of our web app, so that we can trace each production error back to a user.
G059: Map clean URLs like /products/{category}/{slug} to our page handlers, reject non-numeric page numbers with a 404, and build the same URLs by name inside a console command that sends emails.
G060: During development, my temporary variable debug output breaks the JSON responses of my API. Send it to a separate terminal window or the dev toolbar instead, with the request that it came from.
G061: Make our server-rendered pages follow links and submit forms without full page reloads, and push each newly posted comment live to every open page through our Mercure hub.
G062: Our CLI tool reads hand-edited YAML configuration files and writes them back after changes. Parse them safely, report the line of each syntax error, and dump readable indented output.
G063: Our RPC library must read the parameter types of each handler method, including docblock types like array<string, list<int>> or array shapes, and check that incoming values match them.
G064: Our blog posts move through draft, review, published and rejected states. Allow each change only from the right state and only for reviewers, and log every change.
G065: Our CLI tool must run ffmpeg on user-uploaded files with unsafe file names, stream its progress output live, and kill it if it runs longer than five minutes.
G066: Add email and password login to our web app, keep users signed in with a remember-me cookie, and allow only administrators to open the pages under /admin.
G067: Our plain HTML delete buttons post to a controller. Stop other websites from tricking a logged-in user's browser into submitting them.
G068: In our framework-free CLI tool, print complex nested objects as a readable colored tree while debugging, and in tests compare an object's printed structure with expected text.
G069: Push live score updates from our PHP app to 10,000 open browser pages at once, including private updates only for logged-in subscribers, without polling and without holding connections in PHP.
G070: Embed Vue 3 single-file components in our existing server-rendered pages, and give each one its initial props from the page template.
G071: Our reusable PHP class takes an options array in its constructor. Apply defaults, reject unknown keys, check that each value has the right type, and require a 'host' key with a clear error.
G072: Our build step computes a large configuration object graph. Save it as a PHP file that OPcache loads fast, keeping private properties and shared object references.
G073: Let back-office admins type pricing rules such as 'order.total > 100 and customer.vip' into a text field, then check the syntax and evaluate the rules safely in PHP at runtime.
G074: Build a product search box that updates the result list on the page as the user types, with all state and logic in PHP and no custom JavaScript.
G075: With Doctrine, load the entity from the slug in the URL straight into the controller argument with an automatic 404, and reject sign-ups whose email already exists in the users table.
G076: Index our 2,000 Markdown help articles as embeddings in Postgres, then find the most relevant chunks for a customer question so that the LLM can answer from our own docs.
G077: Our standalone PHP script needs database credentials from a committed .env file, with a git-ignored local override file on each developer machine. Real server environment variables must still win.
G078: Before each deploy, verify that the production server's PHP has the needed extensions and sane php.ini settings, and fail the deploy script with an error when something is missing.
G079: Our API documentation generator must list every field of each DTO class with its type, including collection item types written only in docblocks, its docblock summary, and whether it is writable.
G080: Our CLI tool must list all PHP files under src/ that changed in the last 24 hours, skip vendor and everything that .gitignore excludes, and sort them by name.
G081: Our CLI worker wires 40 classes by hand in one bootstrap file. Build the object graph from constructor type hints, and inject all classes that implement one interface as a list.
G082: Give our Tailwind app ready-made accessible UI pieces such as dialogs, dropdown menus and a date picker in shadcn style, copied into our templates so we can edit them.
G083: Our nightly job calls a partner REST API for 500 product IDs. Send the requests in parallel, retry 503 responses with backoff, and fail cleanly on timeouts.
G084: Our open-source PHP library must type-hint only lightweight interfaces for caching, HTTP calls and translation, so that each host app plugs in its own implementation and we depend on no concrete package.
G085: Our CSV import service is slow. Measure how long each phase takes (parse, validate, save) and how much memory it uses, so we can see which phase to optimize.
G086: In development, show a toolbar at the bottom of each page and a browsable history of past requests with database queries, logs, sent emails and timings, also for our JSON API calls.
G087: Keep our production Stripe API key encrypted in the git repository, readable by the app as an environment variable, with the decryption key stored only on the production server.
G088: Our support chatbot page forgets the conversation after each request. Keep the message history of each conversation in Redis between requests and send it to the LLM agent on every new user message.
G089: Our product page runs a 2-second SQL report on every request. Keep the result in Redis for an hour, and drop every cached entry that contains a product when that product changes.
G090: In our HTML page templates, build links from route names, show the edit button only to users with permission, and render our forms with Bootstrap 5 markup.
G091: Our blog accepts rich-text HTML comments. Remove script tags, event handler attributes and javascript: links before we store and display them, but keep bold, italics, lists and normal links.
G092: Some servers run our app in a subfolder, and production serves images from a CDN. Generate correct image URLs in templates, with a version suffix that changes on every deploy.
G093: Override the page templates of a third-party admin package we installed, and add our own price-formatting filter for templates that uses an injected currency service.
G094: Embed a few rich React widgets in our existing server-rendered pages, and give each one its initial data as props from the page template.
G095: Our page templates repeat the same alert and product card markup everywhere. Turn them into reusable template parts with typed inputs, backed by PHP classes that load data from services.
G096: Our front-end upgrade is blocked by the old Swup page-transition and Typed.js integration packages we installed years ago. Replace them with our own small controllers so we can upgrade.
G097: Our legacy library reads the system clock and sleeps with native PHP calls, so its PHPUnit tests wait for real. Fake the time in those tests without changing the library code.
G098: Build a CLI tool that imports a customer CSV: the file path as an argument, a --dry-run flag, a yes/no confirmation prompt, a progress bar and a summary table at the end.
G099: We already receive our email provider's delivery callbacks. Now write the code that reacts to each bounce and spam complaint by disabling that address, running in a background worker.
G100: Generate the boilerplate for a new Product entity with its fields and repository, plus a CRUD controller, a form and list and edit templates, instead of writing them by hand.
G101: Our product list page and JSON API return thousands of rows from a Doctrine query. Split them into pages with numbered links that keep the current filters in the URL.
G102: Our web shop must show all interface texts in English, German and Czech with correct plural forms, choose the language from the URL, and list texts that nobody has translated yet.
G103: Our deploy script must write a generated config file so that readers never see half of it, mirror a directory tree, and throw exceptions instead of PHP warnings when a disk operation fails.
G104: A third-party SDK accepts and returns only PSR-7 messages. Let our web controllers pass the current request to it and send its PSR-7 response back to the browser.
G105: Our orders need IDs that are unique across servers, sort by creation time, work as Doctrine primary keys, and look short in public URLs.
