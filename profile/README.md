# Extra Chill

Extra Chill is an independent music platform built with WordPress Multisite. We are always evolving. This is where we keep our code. 

## Multisite network (blog IDs)

- **extrachill.com** - Main publication site (Blog ID 1)
- **community.extrachill.com** - Forums + authentication hub (Blog ID 2)
- **shop.extrachill.com** - WooCommerce store (Blog ID 3)
- **artist.extrachill.com** - Artist platform (Blog ID 4)
- **chat.extrachill.com** - AI chat (Blog ID 5)
- **events.extrachill.com** - Events calendar (Blog ID 7)
- **stream.extrachill.com** - Streaming (Phase 1 UI) (Blog ID 8)
- **newsletter.extrachill.com** - Newsletter operations (Blog ID 9)
- **docs.extrachill.com** - Documentation hub (Blog ID 10)
- **wire.extrachill.com** - News wire (Blog ID 11)
- **horoscope.extrachill.com** - Horoscopes (Blog ID 12)

Canonical reference: `.github/NETWORK-ARCHITECTURE.MD`

## Repositories

### WordPress plugins

**Network-activated (production)**
- **extrachill-multisite** - Multisite foundation (domain mapping, access controls, shared helpers)
- **extrachill-users** - Network-wide authentication + user management
- **extrachill-ai-client** - Shared AI provider library
- **extrachill-api** - Central REST API ecosystem (`/wp-json/extrachill/v1/`)
- **extrachill-search** - Universal multisite search
- **extrachill-newsletter** - Sendy integration + network subscription hooks
- **extrachill-admin-tools** - Platform admin utilities
- **extrachill-analytics** - Network analytics tracking
- **extrachill-seo** - Meta/structured data + multisite SEO tooling

**Local-only (not deployed)**
- **extrachill-dev** - Development/debug utilities

**Site-activated (production)**
- **extrachill-artist-platform** - Artist profiles, link pages, analytics
- **extrachill-community** - Forums integration and community features
- **extrachill-blog** - Main-site extensions
- **extrachill-events** - events.extrachill.com templates + Data Machine Events integration
- **extrachill-chat** - chat.extrachill.com experience
- **extrachill-stream** - stream.extrachill.com experience (Phase 1 UI)
- **extrachill-docs** - docs.extrachill.com docs surface
- **extrachill-horoscopes** - Horoscope features
- **extrachill-shop** - WooCommerce integration + cross-domain license handling
- **extrachill-news-wire** - news wire custom post type + workflows
- **extrachill-contact** - Contact forms (Turnstile + newsletter hooks)

**Forked dependencies**
- **isolated-block-editor** - Automattic fork; standalone Gutenberg editor
- **blocks-everywhere** - Enables blocks in contexts like bbPress

### Theme

- **extrachill** - Shared theme used across all sites

### Mobile app

- **extrachill-app** - React Native (Expo/TypeScript)

## Developer ops tooling (Homeboy)

Homeboy is a general-purpose developer ops tool (macOS app + CLI) developed alongside this platform and used for day-to-day operations like deployments, remote WP-CLI, PM2, logs, DB tasks, and remote files.

- Source in this monorepo: `homeboy/`
- Get started: `homeboy/README.md`
- CLI reference: `homeboy/homeboy-cli/README.md`

## Events stack (Data Machine)

`events.extrachill.com` is powered by **Data Machine** (publisher ops) and the **Data Machine Events** plugin. Extra Chill extends the frontend and theme integration via `extrachill-events`.

## Platform invariants

- **Blog ID single source of truth**: runtime code uses `ec_get_blog_id()` / `ec_get_domain_map()` from `extrachill-plugins/network/extrachill-multisite/inc/core/blog-ids.php`. Numeric mapping is reserved for `.github/sunrise.php`.
- **Domain mapping (`extrachill.link`)**: `.github/sunrise.php` routes `extrachill.link` to blog 4 and preserves frontend URLs.
- **Build packaging**: each plugin/theme has `./build.sh` symlinked to `/.github/build.sh` and outputs `build/<name>.zip`.

## Built by

Chris Huber - https://chubes.net - https://extrachill.com
