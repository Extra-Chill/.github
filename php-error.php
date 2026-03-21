<?php
/**
 * Extra Chill — Custom Fatal Error Page
 *
 * WordPress drop-in that replaces the default "There has been a critical error"
 * message with a branded error page. WordPress loads this file automatically
 * from wp-content/php-error.php when a fatal error occurs.
 *
 * Because this runs during a fatal error, WordPress is only partially loaded.
 * All styles and markup must be fully self-contained — no external assets,
 * no theme functions, no database queries.
 *
 * @see WP_Fatal_Error_Handler::display_default_error_template()
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// WordPress passes the error via $error variable.
// In recovery mode, $message may also be set.
http_response_code( 500 );
header( 'Content-Type: text/html; charset=utf-8' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title>Something went wrong &mdash; Extra Chill</title>
	<style>
		@font-face {
			font-family: 'Lobster';
			src: url('/wp-content/themes/extrachill/assets/fonts/Lobster-Regular.woff2') format('woff2');
			font-weight: 400;
			font-style: normal;
			font-display: swap;
		}

		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: 'Helvetica', 'Open Sans', sans-serif;
			background: #fff;
			color: #000;
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 2rem;
			-webkit-font-smoothing: antialiased;
		}

		.error-container {
			text-align: center;
			max-width: 540px;
		}

		.brand {
			font-family: 'Lobster', cursive;
			font-size: 2.25rem;
			color: #000;
			text-decoration: none;
			display: inline-block;
			margin-bottom: 2rem;
		}

		.brand:hover {
			color: #53940b;
		}

		h1 {
			font-family: 'Helvetica', 'Open Sans', sans-serif;
			font-size: 1.5rem;
			font-weight: 600;
			margin-bottom: 1rem;
			color: #000;
		}

		p {
			font-size: 1.125rem;
			line-height: 1.6;
			color: #6b7280;
			margin-bottom: 1.5rem;
		}

		.actions {
			display: flex;
			gap: 1rem;
			justify-content: center;
			flex-wrap: wrap;
		}

		a.button {
			display: inline-block;
			padding: 0.625rem 1.5rem;
			border-radius: 8px;
			font-size: 1rem;
			font-weight: 500;
			text-decoration: none;
			transition: background 0.15s, color 0.15s;
		}

		a.button-primary {
			background: #53940b;
			color: #fff;
		}

		a.button-primary:hover {
			background: #3d6b08;
		}

		a.button-secondary {
			background: #f1f5f9;
			color: #000;
		}

		a.button-secondary:hover {
			background: #e2e8f0;
		}

		.error-code {
			margin-top: 2.5rem;
			font-size: 0.8125rem;
			color: #b0b0b0;
		}

		@media (prefers-color-scheme: dark) {
			body {
				background: #1a1a1a;
				color: #e5e5e5;
			}

			.brand {
				color: #e5e5e5;
			}

			.brand:hover {
				color: #53940b;
			}

			h1 {
				color: #e5e5e5;
			}

			p {
				color: #b0b0b0;
			}

			a.button-secondary {
				background: #2a2a2a;
				color: #e5e5e5;
			}

			a.button-secondary:hover {
				background: #333;
			}

			.error-code {
				color: #666;
			}
		}
	</style>
</head>
<body>
	<div class="error-container">
		<a href="https://extrachill.com" class="brand">Extra Chill</a>

		<h1>Something went wrong</h1>

		<p>
			We hit a snag on our end. The issue has been logged and we're
			looking into it. Try refreshing, or head back to the homepage.
		</p>

		<div class="actions">
			<a href="https://extrachill.com" class="button button-primary">Go Home</a>
			<a href="javascript:location.reload()" class="button button-secondary">Refresh</a>
		</div>

		<p class="error-code">HTTP 500 &mdash; Internal Server Error</p>
	</div>
</body>
</html>
