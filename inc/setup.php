<?php
/**
 * Theme setup and registrations.
 *
 * @package Lacvo_Market
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function lacvo_market_setup(): void {
	load_theme_textdomain( 'lacvo-market', LACVO_MARKET_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/dist/app.css' );
	add_theme_support(
		'html5',
		array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array( 'height' => 64, 'width' => 64, 'flex-height' => true, 'flex-width' => true )
	);
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 560,
			'single_image_width'    => 900,
			'product_grid'          => array(
				'default_rows' => 4, 'min_rows' => 2, 'max_rows' => 8,
				'default_columns' => 4, 'min_columns' => 2, 'max_columns' => 4,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary navigation', 'lacvo-market' ),
			'footer'  => __( 'Footer links', 'lacvo-market' ),
		)
	);

	add_image_size( 'lacvo-product-card', 720, 540, true );
	add_image_size( 'lacvo-post-card', 960, 600, true );
}
add_action( 'after_setup_theme', 'lacvo_market_setup' );

function lacvo_market_widgets_init(): void {
	for ( $column = 1; $column <= 3; $column++ ) {
		register_sidebar(
			array(
				'name'          => sprintf( __( 'Footer column %d', 'lacvo-market' ), $column ),
				'id'            => 'footer-' . $column,
				'before_widget' => '<section id="%1$s" class="footer-widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="footer-widget__title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'lacvo_market_widgets_init' );

function lacvo_market_body_classes( array $classes ): array {
	$classes[] = 'lacvo-market';
	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		$classes[] = 'lacvo-market--commerce';
	}
	return $classes;
}
add_filter( 'body_class', 'lacvo_market_body_classes' );

function lacvo_market_register_blog_route(): void {
	add_rewrite_rule( '^blog/page/([0-9]+)/?$', 'index.php?lacvo_blog=1&paged=$matches[1]', 'top' );
	add_rewrite_rule( '^blog/?$', 'index.php?lacvo_blog=1', 'top' );
}
add_action( 'init', 'lacvo_market_register_blog_route', 20 );

function lacvo_market_register_flash_sale_route(): void {
	add_rewrite_rule( '^flash-sale/?$', 'index.php?lacvo_flash_sale=1', 'top' );
}
add_action( 'init', 'lacvo_market_register_flash_sale_route', 20 );

function lacvo_market_register_order_lookup_route(): void {
	add_rewrite_rule( '^order-lookup/?$', 'index.php?lacvo_order_lookup=1', 'top' );
}
add_action( 'init', 'lacvo_market_register_order_lookup_route', 20 );

function lacvo_market_register_auth_routes(): void {
	add_rewrite_rule( '^sign-in/?$', 'index.php?lacvo_auth=login', 'top' );
	add_rewrite_rule( '^sign-up/?$', 'index.php?lacvo_auth=register', 'top' );
}
add_action( 'init', 'lacvo_market_register_auth_routes', 20 );

function lacvo_market_query_vars( array $vars ): array {
	$vars[] = 'lacvo_blog';
	$vars[] = 'lacvo_flash_sale';
	$vars[] = 'lacvo_order_lookup';
	$vars[] = 'lacvo_auth';
	return $vars;
}
add_filter( 'query_vars', 'lacvo_market_query_vars' );

function lacvo_market_send_security_headers(): void {
	if ( is_admin() || headers_sent() ) {
		return;
	}
	header( 'X-Content-Type-Options: nosniff', true );
	header( 'X-Frame-Options: SAMEORIGIN', true );
	header( 'Referrer-Policy: strict-origin-when-cross-origin', true );
}
add_action( 'send_headers', 'lacvo_market_send_security_headers', 20 );
