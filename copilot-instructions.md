# AI Assistant Instructions for Extra Chill Platform

Enable AI agents to make high-quality, production-safe contributions to the Extra Chill WordPress ecosystem immediately.

## 1. Big Picture Architecture

**7-Site WordPress Multisite Network**: The Extra Chill platform consists of seven interconnected WordPress sites with native cross-domain authentication and shared user sessions.

### Core Sites & Components
1. **extrachill.com**: Main website - blog posts, music journalism, newsletter integration
2. **community.extrachill.com**: Community forums - bbPress integration, user interactions, artist platform
3. **shop.extrachill.com**: E-commerce - WooCommerce integration, merchandise sales
4. **app.extrachill.com**: Mobile API - React Native app backend (planning stage only)
5. **chat.extrachill.com**: AI chatbot system with ChatGPT-style interface
6. **artist.extrachill.com**: Artist platform and profiles
7. **events.extrachill.com**: Event calendar hub powered by Data Machine

**Blog ID Resolution**: All plugins use dynamic `get_blog_id_from_url('domain.extrachill.com', '/')` for site identification rather than hardcoded IDs. WordPress automatically caches blog IDs via blog-id-cache for performance.

### Plugins (Site-Specific Installation in `/extrachill-plugins/`)
- **extrachill-multisite/**: Network-activated plugin providing centralized multisite functionality, team members system, Turnstile integration
- **extrachill-artist-platform/**: Artist profiles, link pages, analytics, subscription system (community site)
- **extrachill-community/**: bbPress forums, user management, social features (community site)
- **extrachill-newsletter/**: Sendy integration, email campaigns (main site)
- **extrachill-news-wire/**: Music festival coverage, custom post types (main site)
- **extrachill-shop/**: WooCommerce enhancements, e-commerce features (shop site)
- **extrachill-contact/**: Contact forms with newsletter integration (main site)
- **extrachill-events/**: Event management system (main site)
- **extrachill-admin-tools/**: Centralized admin tools, 404 logging (network-wide)
- **extrachill-blocks/**: Custom Gutenberg blocks for community engagement (trivia, voting, name generators)
- **extrachill-mobile-api/**: Mobile app API endpoints (planning stage only - empty plugin file with comprehensive documentation)
- **extrachill-chat/**: AI chatbot with homepage template override for chat.extrachill.com
- **extrachill-events/**: Event calendar integration with homepage template override for events.extrachill.com

### Theme
- **extrachill/**: Unified theme serving all sites with conditional functionality

### Mobile & Planning
- **extrachill-app/**: React Native mobile app (planning stage only, no implementation)

### Architectural Principles
- **WordPress Multisite Native**: Direct database queries via `switch_to_blog()`/`restore_current_blog()`
- **Domain-Based Blog ID Resolution**: Uses `get_blog_id_from_url()` with automatic blog-id-cache for maintainable, readable code (no hardcoded blog IDs)
- **Network-Activated Core**: `extrachill-multisite` provides shared functionality across all sites
- **Site-Specific Plugins**: Each site has tailored plugin combinations for its purpose
- **Unified Theme**: Single theme with conditional loading adapts to each site's needs via template override filters
- **Cross-Domain Sessions**: Native WordPress authentication eliminates custom token complexity

## 2. Critical Developer Workflows

### Build & Deployment
```bash
# All projects: Install dependencies and run tests
composer install && composer test

# Production builds: Run in each plugin/theme directory
./build.sh  # Creates /build/[project]/ directory and /build/[project].zip file (13 of 14 plugins have build.sh)

# PHP quality checks
composer run lint:php && composer run lint:fix
vendor/bin/phpunit --filter TestClassName
```

### Theme Development
```bash
# extrachill theme (has build system)
./build.sh  # Production build with optimized assets

# extrachill-community plugin (no build system)
# Plugin files edited directly - filemtime() handles cache busting
# Integrates with extrachill theme on community.extrachill.com
```

### React Native Development
```bash
# Currently planning stage only - see extrachill-app/plan.md
# No React Native code, package.json, or build scripts exist yet
```

### Multisite Development
```bash
# Network-activated plugins (extrachill-multisite) affect all sites
# Site-specific plugins installed per site based on requirements
# Theme changes affect all sites - test across network
```

## 3. Project-Specific Conventions

### WordPress Plugin Architecture
- **Direct Include Loading**: ALL plugins use `require_once` includes - NO PSR-4 autoloading for plugin code
  - **Composer Autoloading**: Exists in `composer.json` but ONLY for development dependencies (PHPUnit, PHPCS)
  - **extrachill-artist-platform**: Singleton class with direct includes in constructor
  - **extrachill-multisite**: Procedural pattern with direct includes in initialization function
  - **extrachill-community**: Procedural patterns with master loader system
  - **extrachill-admin-tools**: Procedural filter-based tool registration
  - **extrachill-blocks**: Procedural automatic block discovery
- **Network vs Site-Specific**: Network plugins (multisite) vs site-specific installations
- **Centralized Loading**: Main plugin files load includes in logical order via initialization functions
- **Filter-Based Registration**: Services register via WordPress filters for extensibility
- **Security First**: Nonces, capability checks (`ec_can_manage_*()`), prepared statements, `wp_unslash()` before sanitization

### Security Patterns
- **Admin Access Control**: Non-administrators redirected from wp-admin (`extrachill_redirect_admin()`)
- **Admin Bar Hiding**: Non-admins don't see admin bar (`extrachill_hide_admin_bar_for_non_admins()`)
- **Login Redirect Handling**: Admins bypass frontend redirects (`extrachill_prevent_admin_auth_redirect()`)

### Code Style Guidelines
- **PHP**: WordPress Coding Standards (WPCS), direct `require_once` includes, nonces/capability checks, prepared statements for user input
- **Naming**: snake_case functions, PascalCase classes, camelCase vars, UPPER_SNAKE_CASE constants, kebab-case files
- **Imports**: `require_once` for all includes, Composer autoloader ONLY for dev dependencies, conditional loading with file_exists()
- **Formatting**: 4 spaces indent, 80-120 char lines, same-line braces, single space after commas
- **Error Handling**: WP patterns with logging; no fallback placeholders
- **Security**: Escaping (esc_html, esc_attr), no secrets in code
- **Comments**: Only for nuanced behavior; remove outdated docs

### JavaScript Architecture Patterns
- **Event-Driven Communication**: CustomEvent dispatching between management/preview modules
- **IIFE Modules**: All JS wrapped in self-executing functions with strict mode
- **WordPress Native AJAX**: `wp_ajax_*` hooks with proper nonce handling
- **Conditional Loading**: Assets loaded contextually with filemtime() versioning
- **CustomEvent Patterns**: Standardized events like `infoChanged`, `linksChanged`, `backgroundChanged`

### Theme Architecture Patterns
- **Universal Template Routing**: Theme uses `inc/core/template-router.php` with WordPress native `template_include` filter for proper template routing
- **Template Filters**: Each page type supports `extrachill_template_*` filters for plugin customization
- **Emergency Fallback**: `index.php` serves as minimal emergency fallback only
- **Hook-Based Menus**: Action hooks for menu extensibility (`extrachill_navigation_main_menu`, `extrachill_footer_main_content`)
- **Modular CSS Loading**: Root variables first, then page-specific styles with proper dependencies
- **Template Hierarchy**: Custom taxonomy templates (artist, venue, festival) with REST API support
- **Plugin Integration Hooks**: Homepage sections via action hooks (`extrachill_homepage_hero`, `extrachill_homepage_content_top`)
- **Asset Organization**: All assets in `assets/css/` and `assets/js/` directories
- **Conditional WooCommerce Loading**: E-commerce assets only load on store pages for performance

### Data Architecture
- **Single Source of Truth**: Functions like `ec_get_link_page_data()` centralize data access
- **Filter Extensibility**: `apply_filters('extrch_get_link_page_data', $data)`
- **Live Preview Overrides**: Data functions support preview mode modifications
- **Validation Layers**: Input sanitization and type checking at data boundaries
- **Multisite Queries**: Direct database access via `switch_to_blog()` with domain-based blog ID resolution
- **Custom Taxonomies**: Artist, venue, festival taxonomies with REST API support
- **Plugin Integration Mapping**: Taxonomy-to-styling mappings for cross-plugin compatibility

## 4. Integration Points & Dependencies

### Cross-Component Communication
- **Multisite Functions**: Domain-based blog ID resolution via `get_blog_id_from_url()`, `switch_to_blog()`, `restore_current_blog()`
- **Avatar Menu Injection**: `ec_avatar_menu_items` filter for plugin-theme integration
- **Forum Integration**: bbPress hooks and custom forum section overrides
- **Theme Guards**: `function_exists()`/`class_exists()` for WooCommerce/bbPress dependencies
- **Theme Plugin Hooks**: Homepage sections via `extrachill_homepage_*` action hooks
- **Menu System Hooks**: Navigation extensibility via `extrachill_navigation_*` action hooks
- **Plugin Integration Hooks**: Cross-plugin functionality via filter/action overrides

### External Dependencies
- **bbPress**: Required for community features (guarded with `class_exists()`)
- **WooCommerce**: Optional, guarded integration with `function_exists()`
- **Font Awesome**: Icon system with custom social platform extensions
- **Google Fonts**: Local font loading (no external CDNs)
- **Composer Packages**: QR code generation, testing frameworks
- **Cross-Domain License Systems**: Product purchases affecting other sites in multisite network

### API Endpoints
- **Legacy REST**: `/wp-json/extrachill/v1/*` maintained for mobile app
- **WordPress Native**: Core WP REST API + bbPress endpoints
- **Authentication**: Bearer token headers for mobile, cookie-based for web

## 5. Security & Code Quality Standards

### WordPress Security Patterns
- **Input Handling**: `wp_unslash()` before all sanitization functions
- **Output Escaping**: `esc_html()`, `esc_attr()`, `esc_url()` consistently
- **Database Security**: Prepared statements for all dynamic queries
- **File Uploads**: Size/type validation, cleanup procedures
- **Admin Access Control**: Network-wide admin restrictions for non-administrators

### Code Organization
- **Loading Pattern**: Direct `require_once` includes throughout all plugins
- **File Structure**: Feature-based directories with clear separation
- **Hook Integration**: Extensive use of `add_action()`/`add_filter()` for extensibility
- **Error Handling**: WordPress patterns with logging, no silent failures

## 6. Common Patterns & Examples

### Plugin Initialization
```php
class ExtraChillArtistPlatform {
    private static $instance = null;

    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        require_once EXTRACHILL_ARTIST_PLATFORM_PLUGIN_DIR . 'inc/core/artist-platform-post-types.php';
        $this->init_hooks();
    }
}
```

### Network-Activated Plugin Pattern
```php
// extrachill-multisite plugin - network-wide functionality
add_action('admin_init', 'extrachill_redirect_admin');
function extrachill_redirect_admin() {
    if (!current_user_can('administrator') && is_admin() && !wp_doing_ajax()) {
        wp_safe_redirect(home_url('/'));
        exit();
    }
}
```

### AJAX Handler Pattern
```php
add_action('wp_ajax_my_action', function() {
    // Security checks
    if (!wp_verify_nonce($_POST['nonce'], 'my_nonce')) {
        wp_die('Security check failed');
    }

    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }

    // Process request
    $response = array('success' => true);
    wp_send_json($response);
});
```

### Asset Enqueueing
```php
wp_enqueue_style(
    'my-feature',
    plugin_dir_url(__FILE__) . 'assets/css/my-feature.css',
    array('extrachill-root'), // Dependencies
    filemtime(plugin_dir_path(__FILE__) . 'assets/css/my-feature.css')
);
```

### JavaScript Module Pattern
```javascript
(function() {
    'use strict';

    const MyModule = {
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            // Event binding
        }
    };

    document.addEventListener('DOMContentLoaded', MyModule.init.bind(MyModule));
})();
```

### JavaScript Event Communication
```javascript
// Management module dispatches event
document.dispatchEvent(new CustomEvent('infoChanged', {
    detail: { title: newTitle, bio: newBio }
}));

// Preview module listens for updates
document.addEventListener('infoChanged', function(e) {
    updatePreviewInfo(e.detail);
});
```

### Theme Hook-Based Menu System
```php
// Plugin can add menu items via hooks
add_action('extrachill_navigation_main_menu', 'my_plugin_add_menu_item', 15);
add_action('extrachill_footer_main_content', 'my_plugin_add_footer_section', 20);
```

## 7. Build System Standards

### Production Packaging
- **Clean Process**: Remove dev files, install prod dependencies, validate structure
- **Exclusion Management**: `.buildignore` files control production contents
- **Version Extraction**: Automatically reads version from plugin/theme headers
- **ZIP Generation**: Standardized naming in `/dist` directory

### File Exclusions
```
.git/, node_modules/, vendor/, .claude/, CLAUDE.md, README.md,
build.sh, package.json, composer.lock, .buildignore, tests/
```

## 8. Adding New Features

### Network Plugin Features
1. Add to `extrachill-plugins/extrachill-multisite/inc/core/` for network-wide functionality
2. Add to `extrachill-plugins/extrachill-multisite/inc/<site>/` for site-specific network features
3. Use network activation checks and multisite functions
4. Follow admin access control patterns

### Theme Features
1. Add conditional logic in `extrachill/functions.php`
2. Create feature files in `extrachill/inc/<area>/`
3. Enqueue assets with filemtime() versioning
4. Use narrow page conditions for loading
5. Extend existing CSS/JS rather than replacing

### JavaScript Features
1. Create IIFE module in appropriate assets directory
2. Use CustomEvent for inter-module communication
3. Follow WordPress AJAX patterns
4. Localize script with nonces and AJAX URLs

## 9. What NOT To Do

- Don't introduce global asset bundles or inline concatenation
- Don't assume WooCommerce/bbPress active without guards
- Don't bypass existing escaping or security patterns
- Don't add external font/CDN dependencies
- Don't resurrect removed functionality (check git history)
- Don't flush rewrite rules automatically in code
- Don't modify admin access controls without network security review

## 10. PR/Change Documentation

Include in PR descriptions:
- Feature summary and architectural impact
- Multisite site impact (which sites affected)
- Conditional loading review (performance considerations)
- Taxonomy/CPT changes (note rewrite flush requirement)
- New hooks/filters introduced
- Security implications and testing approach
- Cross-component integration points affected
- Network activation requirements for new plugins

---

*This guidance synthesizes patterns from existing CLAUDE.md files and codebase analysis. Update this file when discovering new patterns or when architectural decisions change.*