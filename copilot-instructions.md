# Extra Chill AI Guide

## Core Architecture
- Network is a 9-site WordPress multisite (Blog ID 6 unused); blog IDs are hardcoded in core plugins (`extrachill-plugins/extrachill-multisite/extrachill-multisite.php`) and must remain in sync with production. docs site at Blog ID 10; horoscope site planned for future Blog ID 11.
- Single theme `extrachill` serves every site via the template router (`extrachill/inc/core/template-router.php`) and exposes feature hooks instead of bespoke templates.
- Platform-critical plugins (`extrachill-multisite`, `extrachill-ai-client`, `extrachill-users`) are network-activated; site apps (chat/events/stream/newsletter) layer on through filters and action hooks.
- `extrachill.link` traffic is routed by `.github/sunrise.php` to blog ID 4 (`artist.extrachill.com`); link pages and rewrites live under `extrachill-plugins/extrachill-artist-platform/inc/core/`.
- React Native work is documentation-only (`extrachill-app/plan.md`); ignore for build considerations.
- AI/ML definitions in repo are authoritative references—never regenerate or modify them.

## Critical Workflows
- Before changes: run `composer install && composer test` from repo root to hydrate tooling and execute the global suite.
- PHP linting/fixing lives in Composer scripts (`composer run lint:php`, `composer run lint:fix`); targeted PHPUnit via `vendor/bin/phpunit --filter TestName` within component directories.
- Ship-ready packages use the shared `./build.sh` symlink inside each theme/plugin; it creates `build/<project>.zip` only and reinstalls dev deps afterward.
- No JS bundlers are present—ship plain assets and version enqueues with `filemtime()` (see `extrachill/functions.php`).

## Coding Patterns
- Load PHP with explicit `require_once` trees; Composer autoloaders exist for dev-only tooling.
- Naming/layout: snake_case functions, PascalCase classes, camelCase locals, kebab-case files, 4-space indents with same-line braces.
- Always pair capability helpers (`ec_can_manage_*`) and nonce checks (`wp_verify_nonce`) with context-aware escaping (`esc_html`, `esc_attr`, `esc_url`).
- Multisite access must wrap `switch_to_blog()`/`restore_current_blog()` in try/finally blocks and rely on known blog IDs; only `extrachill-search` enumerates sites dynamically.
- Cache busting and conditional loading are mandatory: enqueue CSS/JS only where needed and version via `filemtime()`.

## Integration Points
- Extend UI through documented hooks (`extrachill_homepage_hero`, `extrachill_navigation_main_menu`, `extrachill_footer_main_content`) instead of creating new templates.
- Reuse centralized helpers such as `ec_get_link_page_data()` and `extrachill_multisite_search()` before crafting new queries.
- Guard optional integrations: bbPress checks `class_exists('bbPress')`, WooCommerce checks `function_exists('WC')`, and cross-plugin calls require `function_exists` checks.
- Cross-domain URLs are handcrafted (see `extrachill/inc/header/community-cta.php`); follow established slug patterns like `/r/{forum}` and `/u/{user}`.

## Gotchas & References
- Network plugins impact every site; coordinate changes in `extrachill-multisite` and `extrachill-users` with thorough multisite testing.
- `extrachill-community` ships without a build step—format PHP/JS manually.
- Community caches (10-minute `wp_cache_set`) need purging when query shapes change.
- Always review relevant CLAUDE/agent docs (`AGENTS.md`, component `CLAUDE.md`) before edits and keep inline docs current.
- Missing data should fail loudly—do not introduce permissive fallbacks.
````