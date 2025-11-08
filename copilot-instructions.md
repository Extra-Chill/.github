# Extra Chill AI Guide

## Architecture
- 9-site WordPress multisite with cross-domain auth; blog IDs are hardcoded for speed (see `extrachill-plugins/extrachill-multisite/extrachill-multisite.php`).
- Single `extrachill` theme serves every site and routes templates via `extrachill/inc/core/template-router.php`; most interfaces inject content through theme action hooks rather than custom templates.
- Plugins live under `extrachill-plugins/`; network-activated core (`extrachill-multisite`, `extrachill-ai-client`, `extrachill-users`) load first, while site apps (chat/events/stream/newsletter) attach via filters.
- `extrachill.link` maps to `artist.extrachill.com` via `.github/sunrise.php`; sunrise boots WordPress early to route link pages and preserve extrachill.link URLs while using blog ID 4 under the hood.
- React Native app lives in planning docs (`extrachill-app/plan.md`); no JS/mobile build yet.
- All AI/ML definitions shipped in repo are canonical—never rewrite or regenerate them.

## Workflows
- Run `composer install && composer test` at repo root before feature work; tooling lives in root `composer.json` and plugin-specific manifests.
- Each shippable theme/plugin has `./build.sh` (symlink to `.github/build.sh`) which creates `build/<project>.zip` only; run inside the target directory.
- PHP linting uses `composer run lint:php` and fixer `composer run lint:fix`; targeted PHPUnit via `vendor/bin/phpunit --filter TestName` where suites exist.
- No JS bundlers; cache-bust assets with `filemtime()` versions (see `extrachill/functions.php` enqueue helpers).

## Conventions
- PHP only uses direct `require_once` include trees (example: `extrachill-plugins/extrachill-artist-platform/extrachill-artist-platform.php`); composer autoload is dev-only.
- Naming: snake_case functions, PascalCase classes, camelCase locals, kebab-case filenames; keep 4-space indents and same-line braces.
- Always verify capability/nonces (`ec_can_manage_*`, `wp_verify_nonce`) and escape output (`esc_html`, `esc_attr`, `esc_url`).
- Multisite queries must wrap `switch_to_blog()`/`restore_current_blog()` and use known IDs; only `extrachill-search` enumerates sites dynamically.
- Avoid fallbacks that mask failure; missing data should error loudly, matching guidance in `AGENTS.md`.

## Integration Patterns
- Theme extension happens through hooks like `extrachill_homepage_hero`, `extrachill_navigation_main_menu`, `extrachill_footer_main_content`; custom pages rarely ship bespoke templates.
- Community/forum features rely on bbPress; guard usage with `class_exists('bbPress')`. WooCommerce integrations do the same with `function_exists('WC')`.
- Cross-site URLs are manually assembled (see `extrachill/inc/header/community-cta.php`); follow existing slug patterns like `/r/{forum}` and `/u/{user}`.
- Assets are organized under `extrachill/assets/` and plugin `assets/`; enqueue styles/scripts with dependency handles and `filemtime()` for versioning.
- Network data access uses centralized helpers such as `ec_get_link_page_data()` (newsletter) and `extrachill_multisite_search()` (search plugin); reuse before adding new queries.
- When touching link pages, propagate changes through `extrachill-artist-platform/inc/core/artist-platform-rewrite-rules.php` and sunrise routing so extrachill.link URLs keep working.

## Gotchas
- Network plugins affect every site—coordinate changes in `extrachill-multisite` and `extrachill-users` with extensive multisite testing.
- `extrachill-community` has no build step; edits go straight into PHP/JS, so double-check formatting manually.
- Cached community activity (`wp_cache_set`) sticks for 10 minutes; purge or bump keys when changing query shapes.
- Respect CLAUDE/agent docs (e.g., `AGENTS.md`, plugin-level `CLAUDE.md`) for project-specific rules before editing.
- Document nuanced behavior with short docblocks; remove or update stale comments to maintain trust in inline notes.
````