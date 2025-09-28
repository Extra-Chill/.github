# AI Assistant Instructions for Extra Chill Platform

Purpose: Enable AI agents ### Mult### WordPress Plugin Architecture
- **Mixed PSR-4/Procedural**: Some plugins use PSR-4 autoloading, others procedural patterns
- **Network vs Site-Specific**: Network plugins (multisite) vs site-specific installations
- **Centralized Loading**: Main plugin files load includes in logical order via `load_includes()`
- **Filter-Based Registration**: Services register via WordPress filters for extensibility
- **Security First**: Nonces, capability checks (`ec_can_manage_*()`), prepared statements, `wp_unslash()` before sanitizationSecurity Patterns
-### Cross-Component Communication
- **Multisite Functions**: Hardcoded blog IDs (main=1, community=2, shop=3, app=4), `switch_to_blog()`, `restore_current_blog()`
- **Avatar Menu Injection**: `ec_avatar_menu_items` filter for plugin-theme integration
- **Forum Integration**: bbPress hooks and custom forum section overrides
- **Theme Guards**: `function_exists()`/`class_exists()` for WooCommerce/bbPress dependencies
- **Network-Activated Hooks**: `extrachill-multisite` provides shared functionalitymin Access Control**: Non-administrators redirected from wp-admin (`extrachill_redirect_admin()`)
- **Admin Bar Hiding**: Non-admins don't see admin bar (`extrachill_hide_admin_bar_for_non_admins()`)
- **Login Redirect Handling**: Admins bypass frontend redirects (`extrachill_prevent_admin_auth_redirect()`)e high-quality, production-safe contributions to the Extra Chill WordPress ecosystem immediately.

## 1. Big Picture Architecture

**4-Site WordPress Multisite Network**: The Extra Chill platform consists of four interconnected WordPress sites with native cross-domain authentication and shared user sessions.

### Core Sites & Components
- **extrachill.com (Blog ID: 1)**: Main website - blog posts, music journalism, newsletter integration
- **community.extrachill.com (Blog ID: 2)**: Community forums - bbPress integration, user interactions, artist platform
- **shop.extrachill.com (Blog ID: 3)**: E-commerce - WooCommerce integration, merchandise sales
- **app.extrachill.com (Blog ID: 4)**: Mobile API - React Native app backend (planning stage)

### Plugins (Site-Specific Installation)
- **extrachill-multisite/**: Network-activated plugin providing centralized multisite functionality
- **extrachill-artist-platform/**: Artist profiles, link pages, analytics, subscription system (community site)
- **extrachill-community/**: bbPress forums, user management, social features (community site)
- **extrachill-newsletter/**: Sendy integration, email campaigns (main site)
- **extrachill-news-wire/**: Music festival coverage, custom post types (main site)
- **extrachill-shop/**: WooCommerce enhancements, e-commerce features (shop site)
- **extrachill-contact/**: Contact forms with newsletter integration (main site)
- **extrachill-events/**: Event management system (main site)
- **extrachill-admin-tools/**: Centralized admin tools, 404 logging (network-wide)
- **extrachill-mobile-api/**: Mobile app API endpoints (planning stage - app site)

### Themes
- **extrachill/**: Unified theme serving all sites with conditional functionality

### Mobile & Planning
- **extrachill-app/**: React Native mobile app (planning stage only, no implementation)

### Architectural Principles
- **WordPress Multisite Native**: Direct database queries via `switch_to_blog()`/`restore_current_blog()`
- **Hardcoded Blog IDs**: main=1, community=2, shop=3, app=4 for maximum performance
- **Network-Activated Core**: `extrachill-multisite` provides shared functionality across all sites
- **Site-Specific Plugins**: Each site has tailored plugin combinations for its purpose
- **Unified Theme**: Single theme with conditional loading adapts to each site's needs
- **Cross-Domain Sessions**: Native WordPress authentication eliminates custom token complexity

## 2. Critical Developer Workflows

### Build & Deployment
```bash
# All projects: Install dependencies and run tests
composer install && composer test

# Production builds: Run in each plugin/theme directory
./build.sh  # Creates dist/[project].zip excluding dev files

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
# Site-specific plugins installed per site based on MULTISITE-ARCHITECTURE.MD
# Theme changes affect all sites - test across network
```

## 3. Project-Specific Conventions

### WordPress Plugin Architecture
- **PSR-4 Autoloading**: All plugins use Composer with namespace structure (`Chubes\\Extrachill\\`)
- **Singleton Pattern**: Core classes (ExtraChillArtistPlatform, templates, assets)
- **Centralized Loading**: Main plugin file loads includes in logical order via `load_includes()`
- **Filter-Based Registration**: Services register via WordPress filters for extensibility
- **Security First**: Nonces, capability checks (`ec_can_manage_*()`), prepared statements, `wp_unslash()` before sanitization

### JavaScript Architecture Patterns
- **Event-Driven Communication**: CustomEvent dispatching between management/preview modules
- **IIFE Modules**: All JS wrapped in self-executing functions with strict mode
- **WordPress Native AJAX**: `wp_ajax_*` hooks with proper nonce handling
- **Conditional Loading**: Assets loaded contextually with filemtime() versioning
- **CustomEvent Patterns**: Standardized events like `infoChanged`, `linksChanged`, `backgroundChanged`

### Asset Management
- **Dynamic Versioning**: `filemtime($path)` for all enqueues (no cache-busting query strings)
- **Contextual Loading**: Page-specific CSS/JS with narrow conditions
- **Dependency Management**: CSS handles declared with proper dependencies
- **File Existence Checks**: Always verify assets exist before enqueuing
- **Theme Guards**: `function_exists()`/`class_exists()` for WooCommerce/bbPress dependencies

### Data Architecture
- **Single Source of Truth**: Functions like `ec_get_link_page_data()` centralize data access
- **Filter Extensibility**: `apply_filters('extrch_get_link_page_data', $data)`
- **Live Preview Overrides**: Data functions support preview mode modifications
- **Validation Layers**: Input sanitization and type checking at data boundaries
- **Multisite Queries**: Direct database access via `switch_to_blog()` with hardcoded blog IDs

## 4. Integration Points & Dependencies

### Cross-Component Communication
- **Multisite Functions**: Hardcoded blog IDs (community=2, main=1, shop=3), `switch_to_blog()`, `restore_current_blog()`
- **Avatar Menu Injection**: `ec_avatar_menu_items` filter for plugin-theme integration
- **Forum Integration**: bbPress hooks and custom forum section overrides
- **Theme Guards**: `function_exists()`/`class_exists()` for WooCommerce/bbPress dependencies

### External Dependencies
- **bbPress**: Required for community features (guarded with `class_exists()`)
- **WooCommerce**: Optional, guarded integration with `function_exists()`
- **Font Awesome**: Icon system with custom social platform extensions
- **Google Fonts**: Local font loading (no external CDNs)
- **Composer Packages**: QR code generation, testing frameworks

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
- **Namespace Structure**: PSR-4 following project naming (`Chubes\\Extrachill\\`)
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
1. Add to `extrachill-multisite/inc/core/` for network-wide functionality
2. Add to `extrachill-multisite/inc/<site>/` for site-specific network features
3. Use network activation checks and multisite functions
4. Follow admin access control patterns

### Theme Features
1. Add conditional logic in `functions.php`
2. Create feature files in `inc/<area>/`
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