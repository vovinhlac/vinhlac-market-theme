<?php
/**
 * Blog/guide card.
 *
 * @package Lacvo_Market
 */

$is_guide = 'lacvo_guide' === get_post_type();
if ( $is_guide ) {
	$terms   = get_the_terms( get_the_ID(), 'lacvo_guide_category' );
	$primary = is_array( $terms ) && $terms ? reset( $terms ) : null;
} else {
	$categories = get_the_category();
	$primary    = $categories ? $categories[0] : null;
}
$read_label = $is_guide ? __( 'View guides', 'lacvo-market' ) : __( 'Read more', 'lacvo-market' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $is_guide ? 'post-card guide-card' : 'post-card' ); ?>>
	<a class="post-card__image" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'lacvo-post-card', array( 'loading' => 'lazy' ) ); ?>
		<?php else : ?>
			<span class="post-card__placeholder"><?php echo lacvo_market_icon( $is_guide ? 'book' : 'gift' ); ?></span>
		<?php endif; ?>
	</a>
	<div class="post-card__body">
		<?php if ( $primary instanceof WP_Term ) : ?>
			<a class="post-card__pill" href="<?php echo esc_url( get_term_link( $primary ) ); ?>"><?php echo esc_html( strtoupper( $primary->name ) ); ?></a>
		<?php elseif ( $is_guide ) : ?>
			<span class="post-card__pill"><?php esc_html_e( 'GUIDES', 'lacvo-market' ); ?></span>
		<?php endif; ?>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
		<div class="post-card__footer">
			<time datetime="<?php echo esc_attr( get_the_modified_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_modified_date() ); ?></time>
			<a class="post-card__link" href="<?php the_permalink(); ?>"><?php echo esc_html( $read_label ); ?> →</a>
		</div>
	</div>
</article>
