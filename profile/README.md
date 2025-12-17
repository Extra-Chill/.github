# Extra Chill

A WordPress development ecosystem supporting Extra Chill, an independent music platform. 

## About

Extra Chill is a music publication and community platform built on WordPress multisite architecture, featuring artist profiles, community forums, newsletter systems, and e-commerce integration.

### Network Architecture

- **extrachill.com** - Main music publication site (Blog ID 1)
- **community.extrachill.com** - Community forums and user authentication hub (Blog ID 2)
- **shop.extrachill.com** - E-commerce platform with WooCommerce (Blog ID 3)
- **artist.extrachill.com** - Artist platform and profiles (Blog ID 4)
- **chat.extrachill.com** - AI chatbot system with ChatGPT-style interface (Blog ID 5)
- **events.extrachill.com** - Event calendar hub (Blog ID 7)
- **stream.extrachill.com** - Live streaming platform (Phase 1 UI) (Blog ID 8)
- **newsletter.extrachill.com** - Newsletter management and archive hub (Blog ID 9)
- **docs.extrachill.com** - Documentation hub (Blog ID 10)
- **horoscope.extrachill.com** - Planned site (future Blog ID 11)

## Repositories

### WordPress Plugins

**Network-Activated (Production)**
- **extrachill-multisite** - Core network-wide functionality and cross-site data access
- **extrachill-users** - Cross-site user management with team member system
- **extrachill-search** - Universal multisite search across all network sites
- **extrachill-ai-client** - AI provider library with centralized API key management
- **extrachill-api** - REST API infrastructure for all custom endpoints
- **extrachill-newsletter** - Network-wide newsletter system with Sendy integration
- **extrachill-admin-tools** - Centralized administrative tools for platform management
- **extrachill-dev** - Development tools and debugging utilities

**Site-Specific (Production)**
- **extrachill-artist-platform** - Comprehensive artist profiles and link pages
- **extrachill-community** - Forum integration and community features
- **extrachill-blog** - Blog-specific functionality for the main site
- **extrachill-events** - Calendar and event management
- **extrachill-chat** - AI chatbot system for chat.extrachill.com
- **extrachill-stream** - Live streaming platform for artist members (Phase 1 UI)
- **extrachill-docs** - Documentation hub for docs.extrachill.com
- **extrachill-horoscopes** - Wook-themed horoscopes (site not yet provisioned)
- **extrachill-shop** - WooCommerce integration and cross-domain license handling
- **extrachill-news-wire** - Festival Wire custom post type and coverage tools
- **extrachill-contact** - Contact forms with Sendy integration hooks
- **blocks-everywhere** - Forked from Automattic/blocks-everywhere, enables Gutenberg blocks in bbPress in the Extra Chill Community

**Planning Stage**
- **extrachill-app** - React Native mobile app (planning stage only - no implementation)

### WordPress Themes
- **extrachill** - Main theme for all sites

### Infrastructure & Dependencies
- **isolated-block-editor** - Forked from Automattic/isolated-block-editor, standalone Gutenberg editor that replaces any textarea with full block editor functionality, used by blocks-everywhere and other components

### Shared Infrastructure
- **.github/build.sh** - Universal build script symlinked into all 21 plugins and the theme
- **AGENTS.md** - Architectural documentation files in root and individual projects

## Technology Stack

- **WordPress Multisite** - Core platform with native cross-site data access
- **PHP** - Procedural WordPress patterns with direct includes (`require_once`)
- **JavaScript** - Event-driven frontend interactions via CustomEvent system
- **Composer** - Development dependencies and external libraries (ai-http-client)
- **React Native** - Mobile app (planning stage only - no implementation)

## Architecture Overview

**Hardcoded Blog IDs**: All plugins and theme use hardcoded blog IDs for performance.

**Newsletter Integration System**: Five-plugin architecture with centralized `extrachill_multisite_subscribe()` bridge function in extrachill-newsletter plugin.

**Universal Build System**: Shared `.github/build.sh` script symlinked into every production plugin (21 of 21 total) and the theme for consistent release packaging with automatic project type detection.

**Template Override System**: Theme uses `template_include` filter with plugin-extensible template routing allowing plugins to control specific site homepages (chat, events, stream).

## Getting Started

Each repository contains its own `AGENTS.md` file with project-specific development guidance. See the organization's shared `AGENTS.md` for cross-repository standards.

## Built by

**Chris Huber** - Founder & Editor
🌐 [chubes.net](https://chubes.net) | 🎵 [extrachill.com](https://extrachill.com)
