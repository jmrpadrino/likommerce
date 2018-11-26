<?php

/**
 * ADDING METABOX TO LABELS AND LICOR CUSTOM POST TYPES
 */

/**
 * Register meta box(es).
 */
function lk24_register_meta_boxes() {
    add_meta_box( 
		'meta-box-id', 
		'<i class="fas fa-shopping-cart"></i> ' . __( 'Product Data', 'likommerce' ), 
		'lk24_display_callback', 
		array( 'lk24-labels', 'lk24-liquor') 
	);
}
add_action( 'add_meta_boxes', 'lk24_register_meta_boxes' );
// https://developer.wordpress.org/reference/functions/add_meta_box/
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function lk24_display_callback( $post ) {
	
	$sku		 	= get_post_meta( $post->ID, META_PREFIX . 'sku', true );
	$regular_price 	= get_post_meta( $post->ID, META_PREFIX . 'regular_price', true );
	$sale_price 	= get_post_meta( $post->ID, META_PREFIX . 'sale_price', true );
	$description 	= get_post_meta( $post->ID, META_PREFIX . 'description', true );
	
	?>
	<div class="lk24-meta-field-wrapper">
		<div class="lk24-meta-field-label">
			<label for="lk24_sku"><i class="fas fa-shopping-bag"></i> <?= _e('Stock-keeping unit (SKU)', 'likommerce')?></label>
		</div>
		<div class="lk24-meta-field-input">
			<input id="lk24_sku" class="lk24-price-input" name="lk24_sku" type="text" value="<?= $sku ?>">
			<p class="description">Tart macaroon chocolate bar gingerbread pie liquorice topping.</p>
		</div>
	</div>
	<div class="lk24-meta-field-wrapper">
		<div class="lk24-meta-field-label">
			<label for="lk24_regular_price"><i class="fas fa-euro-sign"></i> <?= _e('Regular Price', 'likommerce')?></label>
		</div>
		<div class="lk24-meta-field-input">
			<input id="lk24_regular_price" class="lk24-price-input" name="lk24_regular_price" type="number" min="0" step="0.01" value="<?= $regular_price ?>">
			<p class="description">Tart macaroon chocolate bar gingerbread pie liquorice topping.</p>
		</div>
	</div>
	<div class="lk24-meta-field-wrapper">
		<div class="lk24-meta-field-label">
			<label for="lk24_sale_price"><i class="fas fa-euro-sign"></i> <?= _e('Sale Price', 'likommerce')?></label>
		</div>
		<div class="lk24-meta-field-input">
			<input id="lk24_sale_price" class="lk24-price-input" name="lk24_sale_price" type="number" min="0" step="0.01" value="<?= $sale_price ?>">
			<p class="description">Tart macaroon chocolate bar gingerbread pie liquorice topping.</p>
		</div>
	</div>
	<div class="lk24-meta-field-wrapper">
		<div class="lk24-meta-field-label">
			<label for="lk24_short_desc"><i class="fas fa-pen"></i> <?= _e('Short Description', 'likommerce')?></label>
		</div>
		<div class="lk24-meta-field-input">
			<textarea id="lk24_short_desc" name="lk24_short_desc" rows="8"><?= $description ?></textarea>
			<p class="description">Tart macaroon chocolate bar gingerbread pie liquorice topping.</p>
		</div>
	</div>
	<?php    
	wp_nonce_field('lk24_saving_metadata', 'lk24_nonce');
	// https://codex.wordpress.org/Function_Reference/wp_nonce_field
}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function lk24_save_meta_box( $post_id ) {

	
    if ( ! isset( $_POST['lk24_nonce'] ) ) {
        return;
    }
 
    if ( ! wp_verify_nonce( $_POST['lk24_nonce'], 'lk24_saving_metadata') ) {
        return;
    }
 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
 
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
	
	update_post_meta( $post_id, META_PREFIX . 'sku',  $_POST['lk24_sku'] );
	update_post_meta( $post_id, META_PREFIX . 'regular_price',  $_POST['lk24_regular_price'] );
	update_post_meta( $post_id, META_PREFIX . 'sale_price', $_POST['lk24_sale_price'] );
	update_post_meta( $post_id, META_PREFIX . 'description', $_POST['lk24_short_desc'] );
	
}
add_action( 'save_post', 'lk24_save_meta_box' );
// https://codex.wordpress.org/Function_Reference/wp_verify_nonce
