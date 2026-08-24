<?php
/**
 * Public assets and storefront performance handling.
 *
 * @package Lacvo_Market
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Return true only for the real storefront homepage. */
function lacvo_market_is_storefront_home(): bool {
	if ( ! is_front_page() ) {
		return false;
	}

	$virtual_routes = array(
		'lacvo_auth',
		'lacvo_blog',
		'lacvo_flash_sale',
		'lacvo_order_lookup',
		'lacvo_demo_product',
		'lacvo_demo_landing',
	);

	foreach ( $virtual_routes as $query_var ) {
		$value = get_query_var( $query_var );
		if ( null !== $value && '' !== (string) $value && '0' !== (string) $value ) {
			return false;
		}
	}

	return true;
}

/** Add a scoped body class to the performance-optimized homepage. */
function lacvo_market_performance_home_body_class( array $classes ): array {
	if ( lacvo_market_is_storefront_home() ) {
		$classes[] = 'lacvo-performance-home';
	}
	return array_values( array_unique( $classes ) );
}
add_filter( 'body_class', 'lacvo_market_performance_home_body_class' );

/** Enqueue compiled assets with cache-busting file versions. */
function lacvo_market_enqueue_assets(): void {
	$css_path = LACVO_MARKET_DIR . '/assets/dist/app.css';
	$js_path  = LACVO_MARKET_DIR . '/assets/dist/app.js';

	wp_enqueue_style(
		'lacvo-market',
		LACVO_MARKET_URI . '/assets/dist/app.css',
		array(),
		file_exists( $css_path ) ? (string) filemtime( $css_path ) : LACVO_MARKET_VERSION
	);

	wp_enqueue_script(
		'lacvo-market',
		LACVO_MARKET_URI . '/assets/dist/app.js',
		array(),
		file_exists( $js_path ) ? (string) filemtime( $js_path ) : LACVO_MARKET_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	wp_localize_script(
		'lacvo-market',
		'lacvoMarket',
		array(
			'menuOpen'       => __( 'Open menu', 'lacvo-market' ),
			'menuClose'      => __( 'Close menu', 'lacvo-market' ),
			'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
			'searchNonce'    => wp_create_nonce( 'lacvo_live_search' ),
			'quickBuyNonce'  => wp_create_nonce( 'lacvo_quick_buy' ),
			'reviewNonce'    => wp_create_nonce( 'lacvo_review_actions' ),
			'promotionNonce' => wp_create_nonce( 'lacvo_promotion_spin' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'lacvo_market_enqueue_assets' );

/** Inline a small above-the-fold stylesheet on the real storefront home page. */
function lacvo_market_print_home_critical_css(): void {
	if ( ! lacvo_market_is_storefront_home() ) {
		return;
	}

	$path = LACVO_MARKET_DIR . '/assets/dist/critical-home.css';
	if ( ! is_readable( $path ) ) {
		return;
	}

	$css = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- immutable local asset.
	if ( ! is_string( $css ) || '' === trim( $css ) ) {
		return;
	}

	printf( "<style id=\"lacvo-market-critical-css\">%s</style>\n", $css ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted packaged CSS.
}
add_action( 'wp_head', 'lacvo_market_print_home_critical_css', 7 );

/**
 * Remove WooCommerce scripts/styles not used by the custom homepage UI.
 * Commerce pages keep the normal WooCommerce frontend assets.
 */
function lacvo_market_prune_home_assets(): void {
	if ( ! lacvo_market_is_storefront_home() || is_admin() ) {
		return;
	}

	foreach ( array( 'wc-cart-fragments', 'woocommerce', 'wc-add-to-cart', 'wc-add-to-cart-variation', 'wc-checkout', 'wc-cart' ) as $handle ) {
		wp_dequeue_script( $handle );
	}

	foreach ( array( 'woocommerce-general', 'woocommerce-layout', 'woocommerce-smallscreen', 'wc-blocks-style' ) as $handle ) {
		wp_dequeue_style( $handle );
	}
}
add_action( 'wp_enqueue_scripts', 'lacvo_market_prune_home_assets', 999 );
