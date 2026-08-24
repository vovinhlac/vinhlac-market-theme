<?php
/**
 * Fallback SEO metadata and structured data.
 *
 * The theme yields to a dedicated SEO suite when one is active. Product
 * structured data remains owned by WooCommerce to avoid duplicate entities.
 *
 * @package Lacvo_Market
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Detect common SEO plugins before emitting fallback metadata. */
function lacvo_market_has_seo_plugin(): bool {
	return defined( 'WPSEO_VERSION' )
		|| defined( 'RANK_MATH_VERSION' )
		|| defined( 'AIOSEO_VERSION' )
		|| defined( 'SEOPRESS_VERSION' )
		|| defined( 'THE_SEO_FRAMEWORK_VERSION' )
		|| defined( 'SLIM_SEO_VER' );
}

/** Build a concise description for the current request. */
function lacvo_market_seo_description(): string {
	if ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			$text = has_excerpt( $post ) ? get_the_excerpt( $post ) : $post->post_content;
			return wp_trim_words( wp_strip_all_tags( strip_shortcodes( $text ) ), 32, '…' );
		}
	}

	if ( is_category() || is_tag() || is_tax() ) {
		$description = term_description();
		return $description ? wp_trim_words( wp_strip_all_tags( $description ), 32, '…' ) : '';
	}

	return is_front_page() ? (string) get_bloginfo( 'description' ) : '';
}

/** Resolve a canonical URL for the current public page. */
function lacvo_market_seo_canonical(): string {
	if ( is_singular() ) {
		return (string) get_permalink();
	}
	if ( is_front_page() ) {
		return home_url( '/' );
	}
	if ( is_category() || is_tag() || is_tax() ) {
		$url = get_term_link( get_queried_object() );
		return is_wp_error( $url ) ? '' : (string) $url;
	}
	return '';
}

/** Safely print one JSON-LD document. */
function lacvo_market_print_json_ld( array $data ): void {
	printf(
		'<script type="application/ld+json">%s</script>',
		wp_json_encode(
			$data,
			JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
		)
	); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- encoded JSON document.
}

/** Emit fallback metadata only when another SEO suite is not active. */
function lacvo_market_render_fallback_seo(): void {
	if ( is_admin() || is_feed() || lacvo_market_has_seo_plugin() ) {
		return;
	}

	$description = lacvo_market_seo_description();
	$canonical   = lacvo_market_seo_canonical();

	if ( $description ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
	}
	if ( $canonical ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );
	}

	if ( is_front_page() ) {
		lacvo_market_print_json_ld(
			array(
				'@context' => 'https://schema.org',
				'@type'    => 'WebSite',
				'name'     => get_bloginfo( 'name' ),
				'url'      => home_url( '/' ),
			)
		);
	}
}
add_action( 'wp_head', 'lacvo_market_render_fallback_seo', 5 );
