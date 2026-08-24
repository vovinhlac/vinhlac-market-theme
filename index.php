<?php
/**
 * Fallback template.
 *
 * @package Lacvo_Market
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="lacvo-main" class="lacvo-shell" tabindex="-1">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article <?php post_class( 'lacvo-card' ); ?> id="post-<?php the_ID(); ?>">
				<header>
					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				</header>
				<div><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
		<?php the_posts_navigation(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No content found.', 'lacvo-market' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
