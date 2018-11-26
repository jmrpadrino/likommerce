<?php
/**
 * TEMPLATE FOR LICOR ARCHIVE
 */
get_header();

if ( have_posts() ){
?>
<div class="lk24-product-list lk24-licor-list">
<?php
	while ( have_posts() ){
		the_post();

		$product_id 				= get_the_id();
		$product_title 				= get_the_title();
		$product_regular_price 		= get_post_meta( $product_id, META_PREFIX . 'regular_price', true );
		$product_sale_price 		= get_post_meta( $product_id, META_PREFIX . 'sale_price', true );
		$product_description 		= get_post_meta( $product_id, META_PREFIX . 'description', true );

		/**
		 * IF PRODUCT COMES FORM PARENT GO TO CART
		 * ELSE GO TO FIND CHILDREN PRODUCT
		 */
		if ( isset( $_GET['parentid'] ) && !empty( $_GET['parentid'] ) ){
			$parent_id = $_GET['parentid'];
			$link = get_the_permalink( $product_id ) . '?parentid=' . $parent_id;
		}else{
			$link = get_the_permalink( $product_id );
		}

		// echo $product_id . $product_title . $product_regular_price . $product_sale_price . $product_description;
?>
<div id="product-<?= $product_id ?>" class="lk24-product-info-placeholder product-<?= $product_id ?>">
	<div class="lk24-producto-info-thumbnail">
		<a href="<?= $link ?>">
			<?= get_the_post_thumbnail( $product_id, 'medium', array( 'alt' => $product_title, 'title' => $product_title) ) ?>
		</a>
	</div>
	<div class="lk24-producto-info-meta">
		<a href="<?= $link ?>"><h2 class="lk24-product-info-meta-title"><?= $product_title ?></h2></a>
	</div>
</div>
<?php
	}
?>
</div> <!-- END PRODUCT LIST -->
<?php
}else{
	_e('No products published yet', 'likommerce');
}
?>
<?php
get_footer();
