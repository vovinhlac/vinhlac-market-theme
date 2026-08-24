<?php
/**
 * Focused WooCommerce presentation helpers used by the public portfolio snapshot.
 *
 * @package Lacvo_Market
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Return a small accessible-safe inline icon. */
function lacvo_market_icon( string $name ): string {
	$paths = array(
		'cart'     => '<path d="M3 4h2l2 10h9l2-7H7"/><circle cx="9" cy="19" r="1"/><circle cx="17" cy="19" r="1"/>',
		'external' => '<path d="M14 3h7v7"/><path d="M10 14 21 3"/><path d="M21 14v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h6"/>',
		'zap'      => '<path d="M13 2 3 14h9l-1 8 10-12h-9z"/>',
		'fire'     => '<path d="M12 22c4 0 7-3 7-7 0-5-4-8-6-12 0 4-2 6-4 8-1-2-1-3-1-5-2 2-3 5-3 8 0 5 3 8 7 8z"/>',
		'star'     => '<path d="m12 2 3 6 7 1-5 5 1 7-6-3-6 3 1-7-5-5 7-1z"/>',
		'tag'      => '<path d="M20 13 13 20 4 11V4h7z"/><circle cx="8.5" cy="8.5" r="1.5"/>',
		'book'     => '<path d="M4 19a2 2 0 0 1 2-2h14V4H6a2 2 0 0 0-2 2z"/><path d="M6 17h14v4H6a2 2 0 0 1 0-4z"/>',
		'gift'     => '<path d="M20 12v9H4v-9"/><path d="M2 7h20v5H2z"/><path d="M12 22V7"/>',
	);
	$path = $paths[ $name ] ?? $paths['star'];
	return '<svg aria-hidden="true" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
}

/** Categorize a product for UI treatment. */
function lacvo_market_product_kind( WC_Product $product ): string {
	if ( $product->is_downloadable() ) {
		return 'download';
	}
	return $product->is_virtual() ? 'virtual' : 'standard';
}

/** Read an optional product demo URL. */
function lacvo_market_product_demo_url( WC_Product $product ): string {
	return esc_url_raw( (string) $product->get_meta( '_lacvo_demo_url', true ) );
}

/** Return simplified flash-sale metadata when a future end time is configured. */
function lacvo_market_flash_sale_data( WC_Product $product ): array {
	$end = (int) $product->get_meta( '_lacvo_flash_sale_end', true );
	if ( $end <= time() ) {
		return array();
	}
	$limit = max( 0, (int) $product->get_meta( '_lacvo_flash_sale_limit', true ) );
	$sold  = max( 0, (int) $product->get_meta( '_lacvo_flash_sale_sold', true ) );
	return array(
		'end'       => $end,
		'has_slots' => $limit > 0,
		'remaining' => $limit > 0 ? max( 0, $limit - $sold ) : 0,
	);
}

/** Calculate the visible discount percentage for simple sale prices. */
function lacvo_market_sale_percentage( WC_Product $product ): int {
	$regular = (float) $product->get_regular_price();
	$sale    = (float) $product->get_sale_price();
	if ( $regular <= 0 || $sale <= 0 || $sale >= $regular ) {
		return 0;
	}
	return (int) round( ( ( $regular - $sale ) / $regular ) * 100 );
}

/** Render a compact delivery badge for product cards. */
function lacvo_market_delivery_badge( WC_Product $product ): string {
	$label = $product->is_downloadable() || $product->is_virtual()
		? __( 'Digital delivery', 'lacvo-market' )
		: __( 'Available', 'lacvo-market' );
	return '<span class="product-card__delivery">' . esc_html( $label ) . '</span>';
}
