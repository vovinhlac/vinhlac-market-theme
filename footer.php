<?php
/**
 * Theme footer.
 *
 * @package Lacvo_Market
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="lacvo-site-footer">
	<div class="lacvo-shell">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
