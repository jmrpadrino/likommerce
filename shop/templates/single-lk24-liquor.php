<?php
/**
 * TEMPLATE FOR LICOR ARCHIVE
 */
get_header();
the_post();

$product_id = get_the_id();
$product_sku = get_post_meta( $product_id, META_PREFIX . 'sku', true);
$product_regular_price = get_post_meta( $product_id, META_PREFIX . 'regular_price', true);
$product_sale_price = get_post_meta( $product_id, META_PREFIX . 'sale_price', true);
$product_description = get_post_meta( $product_id, META_PREFIX . 'description', true);

$label_archive_link = get_post_type_archive_link( 'lk24-labels' );

?>
<div id="product-<?= $product_id ?>" class="lk24-single-product-placeholder single-product-<?= $product_id ?>">
	<?php do_action('lk24-before-single-thumbnail') ?>
	<div class="lk24-single-product-thumbnail">
		<?= the_post_thumbnail() ?>
	</div>
	<?php do_action('lk24-after-single-thumbnail') ?>

	<?php do_action('lk24-single-product-meta') ?>
	<div class="lk24-single-product-form">
		<div class="lk24-single-product-meta">
			<h1 class="lk24-single-product-title"><?= the_title() ?></h1>
			<p class="lk24-single-product-sku"><?= esc_html_x('Product Code', 'likommerce') .': '. $product_sku ?></p>
			<div class="lk24-single-product-price-placeholder">
				<ul>
					<li class="lk24-single-product-regular-price">&euro;<span id="lk24_regular_price"><?= $product_regular_price ?></span></li>
					<li class="lk24-single-product-regular-price">&euro;<span id="lk24_sale_price"><?= $product_sale_price ?></span></li>
				</ul>
				<p class="lk24-single-product-short-description"><?= $product_description ?></p>
			</div>
		</div>
		<?php do_action('lk24-before-single-product-meta') ?>
		<?php do_action('lk24-after-single-form') ?>
		<form id="single-form" role="form" action="<?= home_url('select-label-category') ?>/" method="post">
			<input type="hidden" name="parentid" value="<?= $product_id ?>">
			<label for="qty"><?php _e('How many packages do you need?','likommerce') ?></label>
			<input type="number" name="qty" min="1" max="20" value="0" required>
			<?php wp_nonce_field('lk24_selecting_parent', 'lk24_nonce') ?>
			<button type="submit" name="single-submit" value="true"><?php _e('Select Label', 'likommerce') ?></button>
		</form>
		<?php do_action('lk24-after-single-form') ?>
	</div>
</div>
<?php do_action('lk24-after-single-product-placeholder') ?>
<?php
get_footer();
