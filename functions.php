<?php
/**
 * VinhLac Market bootstrap.
 *
 * @package Lacvo_Market
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LACVO_MARKET_VERSION', '2.0.52' );
define( 'LACVO_MARKET_DIR', get_template_directory() );
define( 'LACVO_MARKET_URI', get_template_directory_uri() );

require_once LACVO_MARKET_DIR . '/inc/setup.php';
require_once LACVO_MARKET_DIR . '/inc/enqueue.php';
require_once LACVO_MARKET_DIR . '/inc/customizer.php';
require_once LACVO_MARKET_DIR . '/inc/contact-settings.php';
require_once LACVO_MARKET_DIR . '/inc/template-tags.php';
require_once LACVO_MARKET_DIR . '/inc/demo-viewer.php';
require_once LACVO_MARKET_DIR . '/inc/search.php';
require_once LACVO_MARKET_DIR . '/inc/schema.php';
require_once LACVO_MARKET_DIR . '/inc/woocommerce.php';
require_once LACVO_MARKET_DIR . '/inc/blog-filter.php';
require_once LACVO_MARKET_DIR . '/inc/order-lookup.php';
