This document provides an overview of the Extra Chill Platform WordPress multisite network, a comprehensive music community ecosystem.

## Network Architecture

The Extra Chill Platform operates as a **WordPress multisite network** consisting of **four (4) interconnected sites**:

- **Blog ID 1**: extrachill.com (Main Site)
- **Blog ID 2**: community.extrachill.com (Community Site)
- **Blog ID 3**: shop.extrachill.com (E-commerce Site)
- **Blog ID 4**: app.extrachill.com (Mobile API - Planning Stage)

All sites use the **extrachill theme** with the **universal template routing system**. Individual plugins hook into the theme to provide site-specific functionality.

## Network-Activated Plugin

**ExtraChill Multisite** - Network-activated plugin providing centralized multisite functionality across all sites in the network, including:
- Cross-site data access using `switch_to_blog()` and `restore_current_blog()`
- Real-time multisite search integration
- Admin access control across network
- Team members system and Turnstile integration
- Ad-free license validation system
- Unified comment and author management

**Plugin Architecture**: All Extra Chill plugins use direct `require_once` includes for loading. Composer autoloading exists only for development dependencies (PHPUnit, PHPCS).

## Site 1: extrachill.com (Main Site - Blog ID 1)

The **main site** in the multisite network serving as the foundational blog and informational music website. Hosts music journalism, festival coverage, and general content.

**Site-Specific Plugins**:
- ExtraChill Newsletter - Email campaign management with Sendy integration
- ExtraChill Contact - Contact form system with newsletter integration
- ExtraChill Events - Calendar and event management
- ExtraChill News Wire - Festival Wire custom post type for music coverage

**Excluded Plugins**: WooCommerce, bbPress (handled by other sites in network)

## Site 2: community.extrachill.com (Community Site - Blog ID 2)

The **community hub** where users register and join to interact across the entire multisite network. Serves as the central authentication point for network-wide user accounts.

**Site-Specific Plugins**:
- ExtraChill Community - Community platform with forum functionality and theme integration
- ExtraChill Artist Platform - Comprehensive artist profiles, link pages, analytics, and forum integration
- ExtraChill Blocks - Custom Gutenberg blocks for community engagement (trivia, voting, name generators)
- bbPress - Forum software for community discussions

**Multisite Integration**: User accounts created here authenticate across all network sites using WordPress native multisite authentication

## Site 3: shop.extrachill.com (E-commerce Site - Blog ID 3)

The **merchandise store** providing e-commerce functionality for the Extra Chill Platform with WooCommerce integration.

**Site-Specific Plugins**:
- ExtraChill Shop - WooCommerce integration with cross-domain ad-free license system
- WooCommerce - E-commerce platform for merchandise sales

**Cross-Site Features**: Ad-free license validation accessed by other sites in network via `switch_to_blog(3)`

## Site 4: app.extrachill.com (Mobile API - Blog ID 4)

**React Native mobile application backend** planned to use community authentication for mobile app integration.

**Current Status**: Planning stage only - no implementation exists

**Planned Plugins**:
- ExtraChill Mobile API - Currently contains only empty plugin file (1 line) and documentation

**Architecture Plan**: React Native frontend consuming WordPress Block Data API with native multisite authentication integration