<?php
/**
 * Theme header.
 *
 * @package Lacvo_Market
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text" href="#lacvo-main"><?php esc_html_e( 'Skip to content', 'lacvo-market' ); ?></a>
<header class="lacvo-site-header">
	<div class="lacvo-shell">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
		</a>
		<button type="button" class="lacvo-button" data-lacvo-menu-toggle aria-controls="lacvo-primary-menu" aria-expanded="false">
			<?php esc_html_e( 'Menu', 'lacvo-market' ); ?>
		</button>
		<nav id="lacvo-primary-menu" aria-label="<?php esc_attr_e( 'Primary navigation', 'lacvo-market' ); ?>" hidden>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>
	</div>
</header>
