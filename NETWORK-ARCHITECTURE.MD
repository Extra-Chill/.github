This document provides an overview of the Extra Chill Platform WordPress multisite network, a comprehensive music community ecosystem.

## Network Architecture

The Extra Chill Platform operates as a **WordPress multisite network** consisting of **nine (9) interconnected sites** (Blog ID 6 is unused; docs.extrachill.com at Blog ID 10; horoscope.extrachill.com planned for Blog ID 11 but not yet provisioned):

1. **extrachill.com** (Blog ID 1) - Main music journalism and content site
2. **community.extrachill.com** (Blog ID 2) - Community forums and user authentication hub
3. **shop.extrachill.com** (Blog ID 3) - E-commerce platform with WooCommerce
4. **artist.extrachill.com** (Blog ID 4) - Artist platform and profiles
5. **chat.extrachill.com** (Blog ID 5) - AI chatbot system with ChatGPT-style interface
6. **events.extrachill.com** (Blog ID 7) - Event calendar hub powered by Data Machine
7. **stream.extrachill.com** (Blog ID 8) - Live streaming platform (Phase 1 UI)
8. **newsletter.extrachill.com** (Blog ID 9) - Newsletter operations and Sendy integration hub
9. **docs.extrachill.com** (Blog ID 10) - Documentation hub

### Blog ID Resolution

**Site Discovery**: Core plugins rely on a centralized hardcoded blog ID map for performance. 

All sites use the **extrachill theme** with the **universal template routing system**. Individual plugins hook into the theme to provide site-specific functionality.

## Network-Activated Plugins

**ExtraChill Multisite** - Network-activated plugin providing centralized multisite functionality across all sites in the network, including:
- Cross-site data access using `switch_to_blog()` and `restore_current_blog()`
- Admin access control across network
- Cloudflare Turnstile integration
- Ad-free license validation system
- Unified comment and author management
- Newsletter bridge function for Sendy integration

**ExtraChill Users** - Network-activated user management plugin providing:
- Authentication system (login/register/password reset via Gutenberg blocks)
- Team member system with manual override support
- User creation on community.extrachill.com
- Profile URL resolution (`ec_get_user_profile_url()`)
- Custom avatar system
- Network-wide avatar menu
- Online user tracking across all sites

**ExtraChill Search** - Network-activated universal search plugin providing:
- Real-time multisite search across all network sites via `extrachill_multisite_search()` function
- Dynamic site discovery via `get_sites()` with automatic WordPress blog-id-cache
- Flexible post type support (posts, pages, bbPress topics/replies, custom post types)
- Meta query support for advanced filtering
- Cross-site pagination and contextual excerpts
- Search results template with site badges

**ExtraChill AI Client** - Network-activated AI provider library providing:
- Centralized API key management for all AI providers (OpenAI, Anthropic, Google Gemini, Grok, OpenRouter)
- Network-wide configuration accessible to all plugins across all sites
- Filter-based architecture for AI requests (`ai_request` filter)
- Shared library pattern eliminating duplicate API key storage

**ExtraChill API** - Network-activated REST API infrastructure providing:
- Centralized REST endpoint management under `extrachill/v1` namespace
- Automatic route discovery via RecursiveIteratorIterator from `inc/routes/` directory
- 50+ endpoints across 15 categories (auth, artists, analytics, shop, community, blog, chat, events, newsletter, docs, admin, activity, media, stream, tools)
- All plugins consume API endpoints for cross-platform data sharing and functionality

**ExtraChill Newsletter** - Network-activated newsletter system providing:
- Sendy integration for email campaign management
- Subscription forms available network-wide via hook integrations
- Newsletter custom post type and admin UI (newsletter.extrachill.com only)
- Network-wide settings stored in `get_site_option('extrachill_newsletter_settings')`
- Conditional loading based on site context

**Plugin Architecture**: All Extra Chill plugins use direct `require_once` includes for loading. Composer autoloading exists only for development dependencies (PHPUnit, PHPCS) and external libraries (ai-http-client).

## Site 1: extrachill.com (Main Site)

The **main site** in the multisite network serving as the foundational blog and informational music website. Hosts music journalism, festival coverage, and general content.

**Site-Specific Plugins**:
- ExtraChill Contact - Contact form system with newsletter integration
- ExtraChill Events - Calendar and event management
- ExtraChill News Wire - Festival Wire custom post type for music coverage
- ExtraChill Blog - Blog-specific functionality for the main site

**Network Plugin Integration**: ExtraChill Newsletter (network-activated) provides subscription forms via hook integrations

**Excluded Plugins**: WooCommerce, bbPress (handled by other sites in network)

## Site 2: community.extrachill.com (Community Site)

The **community hub** where users register and join to interact across the entire multisite network. Serves as the central authentication point for network-wide user accounts.

**Site-Specific Plugins**:
- ExtraChill Community - Community platform with forum functionality and theme integration (consumes community API endpoints for upvoting, drafts, user search)
- ExtraChill Artist Platform - Comprehensive artist profiles, link pages, analytics, and forum integration (consumes artists, analytics, shop API endpoints)
- ExtraChill Blocks - Custom Gutenberg blocks for community engagement (trivia, voting, name generators)
- bbPress - Forum software for community discussions

**Multisite Integration**: User accounts created here authenticate across all network sites using WordPress native multisite authentication

## Site 3: shop.extrachill.com (E-commerce Site)

The **merchandise store** providing e-commerce functionality for the Extra Chill Platform with WooCommerce integration.

**Site-Specific Plugins**:
- ExtraChill Shop - WooCommerce integration with cross-domain ad-free license system (consumes shop API endpoints for products, Stripe Connect, webhooks)
- WooCommerce - E-commerce platform for merchandise sales

**Cross-Site Features**: Ad-free license validation accessed by other sites in network using dynamic site discovery

## Site 4: artist.extrachill.com (Artist Platform)

**Artist profiles and link pages** providing comprehensive artist platform functionality.

**Site-Specific Plugins**:
- ExtraChill Artist Platform - Artist profiles, link pages, analytics, subscription system, forum integration

**Cross-Site Integration**: Integrates with community forums and multisite user authentication, consumes artists, analytics, and shop API endpoints

## Site 5: chat.extrachill.com (AI Chat System)

**AI chatbot interface** providing ChatGPT-style conversational AI for logged-in users across the multisite network.

**Site-Specific Plugins**:
- ExtraChill Chat - Homepage template override providing AI chatbot interface (consumes chat API endpoints for message history, conversation management)
- ExtraChill AI Client - Network-activated AI provider integration (shared across all sites)

**Authentication**: WordPress multisite native authentication - any logged-in user from any network site can access chat

**Integration**: Uses `extrachill_template_homepage` filter for complete homepage control


## Site 6: events.extrachill.com (Event Calendar Hub)

**Event calendar and festival coverage** powered by Data Machine event automation.

**Site-Specific Plugins**:
- Data Machine - Event automation and content pipeline
- datamachine-events - Calendar block and event post type
- ExtraChill Events - Homepage template override for calendar display

**Calendar Setup**: Uses WordPress static homepage with datamachine-events calendar block for full event display and filtering

**Integration**: Uses `extrachill_template_homepage` filter for complete homepage control

## Site 7: stream.extrachill.com (Live Streaming Platform)

The **live streaming surface** designed for artist members, currently operating as a Phase 1 non-functional UI while streaming infrastructure is finalized.

**Site-Specific Plugins**:
- Extra Chill Stream - Homepage template override delivering the streaming dashboard interface

**Current Status**: UI scaffolding in place with roadmap for media ingestion, access control, and artist scheduling workflows

**Integration**: Shares multisite authentication, leverages `extrachill_template_homepage` for layout control, and will consume artist platform data and stream API endpoints on launch

## Site 8: newsletter.extrachill.com (Newsletter Operations)

The **dedicated newsletter hub** centralizes Sendy-powered email campaign management away from the main site while maintaining multisite authentication.

**Site-Specific Plugins**:
- Extra Chill Newsletter - Sendy integration, list segmentation, and campaign orchestration for the Extra Chill audience

**Cross-Site Integration**: Receives subscriber data from forms embedded across the network via `extrachill-newsletter` hooks and shares engagement metrics back to the main site dashboards

## API Integration Architecture

The **Extra Chill API** serves as the central nervous system for plugin interconnectivity across the multisite network, enabling seamless data flow and cross-platform functionality.

### API-Driven Plugin Communication

All site-activated plugins consume REST API endpoints provided by the network-activated `extrachill-api` plugin, creating a loosely-coupled architecture where plugins can function independently while sharing data when available.

### Key Integration Patterns

- **Artist Platform** ↔ **Shop**: Subscription data drives product recommendations and discount eligibility
- **Community** ↔ **Artist Platform**: Forum discussions enhance artist profiles and engagement tracking
- **Users** ↔ **Analytics**: User behavior informs personalized content across all sites
- **Shop** ↔ **Analytics**: Purchase patterns generate product recommendations and loyalty rewards
- **Newsletter** ↔ **Users**: Subscription status and preferences sync across user profiles
- **Chat** ↔ **AI Client**: Conversational AI powered by centralized AI provider management

### Data Flow Architecture

The API ecosystem enables real-time data synchronization across sites while maintaining performance through:
- Function existence checks for graceful degradation
- Circuit breaker patterns for fault tolerance
- Comprehensive error handling and logging
- Standardized authentication and permission systems