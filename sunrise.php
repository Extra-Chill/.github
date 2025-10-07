<?php
/**
 * extrachill.link Domain Mapping
 *
 * Maps extrachill.link to artist.extrachill.com while preserving
 * extrachill.link URLs in the frontend.
 *
 * This file should be copied to wp-content/sunrise.php on the server.
 *
 * NOTE: Update blog_id below with actual artist.extrachill.com blog ID from WordPress Network Admin
 */

$extra_domains = [
    // 'domain' => blog_id
    'extrachill.link' => 4  // Artist site ID where artist platform plugin resides (artist.extrachill.com)
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

        // Replace community.extrachill.com URLs with extrachill.link in frontend
        add_filter( 'home_url', function( $url ) use ( $mask_domain, $origin_domain ) {
            return str_replace( $origin_domain, $mask_domain, $url );
        } );
    }

    // Handle only specific redirects AFTER domain mapping is established
    if ($request_path === 'join') {
        header('Location: https://artist.extrachill.com/login/?from_join=true', true, 301);
        exit;
    }

    // Let the artist platform plugin handle root domain and /extra-chill routing
    // via its template_include filter now that domain mapping is active
}