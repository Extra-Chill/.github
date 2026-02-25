<?php
/**
 * extrachill.link Domain Mapping
 *
 * Maps extrachill.link to artist.extrachill.com (blog_id 4) for WordPress multisite.
 * This is the proper WordPress multisite domain mapping approach without a plugin.
 */

// Only run if this is a multisite install
if ( ! defined( 'MULTISITE' ) || ! MULTISITE ) {
    return;
}

$extra_domains = [
    'extrachill.link'    => 4,
    'www.extrachill.link' => 4
];

if (
    isset( $_SERVER['HTTP_HOST'] )
    && array_key_exists( strtolower( $_SERVER['HTTP_HOST'] ), $extra_domains )
) {
    $mapped_blog_id = $extra_domains[ strtolower( $_SERVER['HTTP_HOST'] ) ];
    
    // Force WordPress to use the correct blog ID
    global $blog_id;
    $blog_id = $mapped_blog_id;
    
    // Set the current blog globals
    global $current_site, $current_blog;
    $current_site = get_network( 1 );
    $current_blog = get_site( $mapped_blog_id );
    
    // Add the artist link page rewrite rule directly to WordPress
    // This runs at priority 0 to ensure it's added before other plugins
    add_filter( 'rewrite_rules_array', function( $rules ) {
        // Only add this rule for extrachill.link domain
        if ( isset( $_SERVER['HTTP_HOST'] ) && stripos( $_SERVER['HTTP_HOST'], 'extrachill.link' ) !== false ) {
            
            // Excluded slugs
            $excluded = 'wp-admin|wp-login|wp-json|artists?|link-page|manage-artist|manage-link-page|join';
            
            // Add the main rule at the top
            $new_rules = [
                '^(' . $excluded . ')/?$' => 'index.php?$1',
                '^([^/]+)/?$' => 'index.php?artist_link_page=$matches[1]',
            ];
            
            return array_merge( $new_rules, $rules );
        }
        return $rules;
    }, 0 );
}
