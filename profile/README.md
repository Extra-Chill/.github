# Extra Chill

A WordPress development ecosystem supporting Extra Chill, an independent music platform. 

## About

Extra Chill is a music publication and community platform built on WordPress multisite architecture, featuring artist profiles, community forums, newsletter systems, and e-commerce integration.

### Network Architecture

- **extrachill.com** - Main music publication site
- **community.extrachill.com** - Community forums and user authentication hub
- **shop.extrachill.com** - E-commerce platform with WooCommerce
- **artist.extrachill.com** - Artist platform and profiles
- **chat.extrachill.com** - AI chatbot system with ChatGPT-style interface
- **events.extrachill.com** - Event calendar hub
- **stream.extrachill.com** - Live streaming platform (Phase 1 non-functional UI)
- **app.extrachill.com** - Mobile API backend (planning stage only - no implementation)

## Repositories

### WordPress Plugins

**Network-Activated (Production)**
- **extrachill-multisite** - Core network-wide functionality and cross-site data access
- **extrachill-users** - Cross-site user management with team member system
- **extrachill-search** - Universal multisite search across all network sites
- **extrachill-ai-client** - AI provider library with centralized API key management

**Site-Specific (Production)**
- **extrachill-artist-platform** - Comprehensive artist profiles and link pages
- **extrachill-community** - Forum integration and community features
- **extrachill-events** - Calendar and event management
- **extrachill-admin-tools** - Centralized administrative tools
- **extrachill-blocks** - Custom Gutenberg blocks for community engagement
- **extrachill-login-register** - Network-wide authentication with Cloudflare Turnstile
- **extrachill-chat** - AI chatbot system for chat.extrachill.com
- **extrachill-stream** - Live streaming platform for artist members (Phase 1 non-functional UI)

**Development Stage**
- **extrachill-shop** - WooCommerce integration and e-commerce functionality
- **extrachill-newsletter** - Email campaigns and Sendy subscriptions
- **extrachill-news-wire** - Festival Wire custom post type
- **extrachill-contact** - Contact forms and Sendy integration

**Planning Stage**
- **extrachill-mobile-api** - Mobile app API (empty plugin file - no implementation)

### WordPress Themes
- **extrachill** - Main theme for all sites

### Shared Infrastructure
- **sunrise.php** - extrachill.link domain mapping to community.extrachill.com
- **.github/build.sh** - Universal build script symlinked into all plugins and theme
- **CLAUDE.md** - Architectural documentation files in root and individual projects

## Technology Stack

- **WordPress Multisite** - Core platform with native cross-site data access
- **PHP** - Procedural WordPress patterns with direct includes (`require_once`)
- **JavaScript** - Event-driven frontend interactions via CustomEvent system
- **Composer** - Development dependencies and external libraries (ai-http-client)
- **React Native** - Mobile app (planning stage only - no implementation)

## Architecture Overview

**Domain-Based Site Resolution**: All plugins use `get_blog_id_from_url()` for site identification with automatic WordPress blog-id-cache for performance and maintainable code.

**Newsletter Integration System**: Three-plugin architecture with centralized `extrachill_multisite_subscribe()` bridge function, zero hardcoded credentials, and filter-based integration registration.

**Universal Build System**: Shared `.github/build.sh` script symlinked into all 16 implemented plugins and theme for consistent production ZIP generation with automatic project type detection.

**Template Override System**: Theme uses `template_include` filter with plugin-extensible template routing allowing plugins to control specific site homepages (chat, events, stream).

## Getting Started

Each repository contains its own `CLAUDE.md` file with project-specific development guidance. See the organization's shared `CLAUDE.md` for cross-repository standards.

## Built by

**Chris Huber** - Founder & Editor
🌐 [chubes.net](https://chubes.net) | 🎵 [extrachill.com](https://extrachill.com)
