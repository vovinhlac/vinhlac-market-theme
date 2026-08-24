<?php
/**
 * Product card for loops.
 *
 * @package Lacvo_Market
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}

$terms      = get_the_terms( $product->get_id(), 'product_cat' );
$term       = is_array( $terms ) && $terms ? reset( $terms ) : null;
$term_url   = '';
if ( $term instanceof WP_Term ) {
	$term_link = get_term_link( $term );
	$term_url  = is_wp_error( $term_link ) ? '' : (string) $term_link;
}
$kind       = lacvo_market_product_kind( $product );
$demo_url   = lacvo_market_product_demo_url( $product );
$flash      = lacvo_market_flash_sale_data( $product );
$discount   = lacvo_market_sale_percentage( $product );
$total_sale = max( 0, (int) $product->get_meta( '_lacvo_real_sales', true ) );
$is_hot     = ! empty( $flash ) || $total_sale >= 5;
$is_best    = $total_sale >= 10;
?>
<li <?php wc_product_class( 'product-card', $product ); ?>>
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
	<a class="product-card__image" href="<?php the_permalink(); ?>">
		<span class="product-card__badges" aria-hidden="true">
			<?php if ( $flash ) : ?><span class="product-card__promo-badge is-flash"><?php echo lacvo_market_icon( 'zap' ); ?><?php esc_html_e( 'Flash', 'lacvo-market' ); ?></span><?php endif; ?>
			<?php if ( $is_hot ) : ?><span class="product-card__promo-badge is-hot"><?php echo lacvo_market_icon( 'fire' ); ?><?php esc_html_e( 'Hot', 'lacvo-market' ); ?></span><?php endif; ?>
			<?php if ( $is_best ) : ?><span class="product-card__promo-badge is-best"><?php echo lacvo_market_icon( 'star' ); ?><?php esc_html_e( 'Best-selling', 'lacvo-market' ); ?></span><?php endif; ?>
			<?php if ( $product->is_on_sale() && ! $flash ) : ?><span class="product-card__promo-badge is-sale"><?php echo lacvo_market_icon( 'tag' ); ?><?php esc_html_e( 'Sale', 'lacvo-market' ); ?></span><?php endif; ?>
		</span>
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'lacvo-product-card', array( 'loading' => 'lazy' ) );
		} else {
			echo wc_placeholder_img( 'lacvo-product-card' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</a>
	<div class="product-card__body">
		<div class="product-card__labels">
			<div class="product-card__status-row">
				<?php echo lacvo_market_delivery_badge( $product ); ?>
			</div>
			<div class="product-card__category-row">
				<?php if ( $term instanceof WP_Term && $term_url ) : ?>
					<a class="product-card__category" href="<?php echo esc_url( $term_url ); ?>"><?php echo esc_html( $term->name ); ?></a>
				<?php endif; ?>
			</div>
		</div>
		<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
		<h2 class="woocommerce-loop-product__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<?php if ( $flash ) : ?>
			<div class="product-card__flash" data-product-flash-end="<?php echo esc_attr( (string) $flash['end'] ); ?>">
				<span class="product-card__flash-time"><?php echo lacvo_market_icon( 'zap' ); ?><b data-flash-clock>00:00:00</b></span>
				<?php if ( ! empty( $flash['has_slots'] ) ) : ?><span><?php echo esc_html( $flash['remaining'] ); ?></span><?php endif; ?>
			</div>
		<?php endif; ?>
		<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
		<div class="product-card__footer">
			<div class="product-card__price-row">
				<div class="product-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
				<?php if ( $discount ) : ?><span class="product-card__discount">-<?php echo esc_html( (string) $discount ); ?>%</span><?php endif; ?>
			</div>
			<div class="product-card__actions <?php echo $demo_url ? 'has-demo' : 'no-demo'; ?>">
				<?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
					<button type="button" class="product-card__buy" data-quick-buy="<?php echo esc_attr( (string) $product->get_id() ); ?>">
						<?php echo lacvo_market_icon( 'cart' ); ?>
						<span><?php esc_html_e( 'Buy now', 'lacvo-market' ); ?></span>
					</button>
				<?php else : ?>
					<a class="product-card__buy is-disabled" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Out of stock', 'lacvo-market' ); ?></a>
				<?php endif; ?>
				<?php if ( $demo_url ) : ?>
					<a class="product-card__demo" href="<?php echo esc_url( $demo_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Open the demo in a new tab', 'lacvo-market' ); ?>" title="<?php esc_attr_e( 'View demo', 'lacvo-market' ); ?>"><?php echo lacvo_market_icon( 'external' ); ?><span class="product-card__demo-label"><?php esc_html_e( 'View demo', 'lacvo-market' ); ?></span></a>
				<?php endif; ?>
			</div>
		</div>
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>
</li>
