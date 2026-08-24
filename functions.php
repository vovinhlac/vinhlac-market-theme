<?php
/**
 * VinhLac Market portfolio bootstrap.
 *
 * The public repository contains a focused source snapshot for code review,
 * rather than the full production distribution package.
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
require_once LACVO_MARKET_DIR . '/inc/schema.php';
require_once LACVO_MARKET_DIR . '/inc/woocommerce.php';
