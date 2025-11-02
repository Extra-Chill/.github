<?php
/**
 * extrachill.link Domain Mapping
 *
 * Maps extrachill.link to artist.extrachill.com while preserving extrachill.link URLs in the frontend.
 * Copy this file to wp-content/sunrise.php on the server.
 */

$extra_domains = [
    'extrachill.link' => 4,      // artist.extrachill.com
    'www.extrachill.link' => 4   // artist.extrachill.com (with www)
];

// Domain mapping happens FIRST - before any redirects
if (
    isset( $_SERVER['HTTP_HOST'] )
    && array_key_exists( $_SERVER['HTTP_HOST'], $extra_domains )
) {
    $mask_domain = $_SERVER['HTTP_HOST'];
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $request_path = trim( parse_url( $request_uri, PHP_URL_PATH ), '/' );

    // Set WordPress multisite globals
    $blog_id      = $extra_domains[ $mask_domain ]; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
    $current_blog = get_site( $blog_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

    // Network ID (should always be 1 unless running multiple networks)
    $current_site = get_network( 1 ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

    if ( $current_blog ) {
        $origin_domain = $current_blog->domain . untrailingslashit( $current_blog->path );

        // Replace artist.extrachill.com URLs with extrachill.link in frontend
        add_filter( 'home_url', function( $url ) use ( $mask_domain, $origin_domain ) {
            return str_replace( $origin_domain, $mask_domain, $url );
        } );
    }

    // Redirect join flow to artist site login with from_join parameter
    if ($request_path === 'join') {
        header('Location: https://artist.extrachill.com/login/?from_join=true', true, 301);
        exit;
    }

    // Artist platform plugin handles root and link page routing via template_include filter
}