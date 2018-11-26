<?php
// IF TRY TO GET DIRECTLY BY URL
if(
	!isset ( $_POST['nonce'] ) &&
	!isset ( $_POST['parentid'] ) &&
	! wp_verify_nonce( $_POST['lk24_nonce'], 'lk24_selecting_parent')
){
	$location = get_site_url();
	wp_redirect( $location, 301 );
	exit;
}
//lk24_remove_cookie();
get_header();

$parent_id = $_POST['parentid'];
$parent_object = get_post($parent_id);
$parent_name = $parent_object->post_title;
$parent_regular_price = get_post_meta( $parent_id, META_PREFIX . 'regular_price', true);
$parent_link = get_the_permalink($parent_id);
$quantity = $_POST['qty'];
$subtotal = $quantity * $parent_regular_price;

if (
	isset( $_POST['selected_category'] ) &&
	!empty( $_POST['selected_category'] )
){
	$parent_category_id = $_POST['selected_category'];
	$parent_category_object = get_term_by( 'term_id', $parent_category_id, 'labelcategory');
	$parent_category_title = $parent_category_object->name;
?>
<form name="lk24-select-category" role="form" method="post" action="<?= home_url('likommerce-cart')?>/">
	<input type="hidden" name="parentid" value="<?= $parent_id ?>">
	<input type="hidden" name="qty" value="<?= $quantity ?>">
	<div class="lk24-category-selection-title">
		<div>
			<h5><?= _e('Parent Product', 'likommerce') ?></h5>
			<ul class="parent-product-meta">
				<li><?= '<strong>'. esc_html_x('Licor Selected','likormmerce') . ':</strong> <a href="'.$parent_link.'">' . $parent_name . '('. esc_html_x('edit','likormeerce') .')</a>' ?> - &euro;<?= $parent_regular_price ?></li>
				<li><?= '<strong>'. esc_html_x('Quantity','likormmerce') . ':</strong> ' . $quantity .' '. _n('box', 'boxes', $quantity, 'likommerce') ?></li>
				<li><?= '<strong>'. esc_html_x('Subtotal','likormmerce') . ':</strong> &euro;' . $subtotal ?></li>
			</ul>
			<h1><?= esc_html_x('Label category', 'likommerce') . ': '. $parent_category_title . ' - ' .esc_html_x('Select label category', 'likommerce') ?></h1>
		</div>
		<?php wp_nonce_field('lk24_selecting_label', 'lk24_nonce') ?>
		<button type="submit" name="category-selected" value="true"><?= _e('Add to cart', 'likommerce') ?></button>
	</div>
	<div class="lk24-product-list lk24-label-category-list">
		<?php
			$thumb_url = LIKOMMERCE_PLUGIN_URI . '/app/images/lk24-thumbnail-placeholder.jpg';
			$args = array(
				'post_type' => 'lk24-labels',
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'labelcategory',
						'field' => 'term_id',
						'terms' => $parent_category_id
					)
				)
			);
			$labels = new WP_Query($args);

  			if ($labels->have_posts()){
				while ($labels->have_posts()){
					$labels->the_post();
					if (get_the_post_thumbnail_url())
						$thumb_url = get_the_post_thumbnail_url(null, 'medium');
		?>
		<div id="label-<?= get_the_ID() ?>" class="lk24-product-info-placeholder lk24-category-item label-<?= get_the_ID() ?>">
			<input id="category-<?= get_the_ID() ?>" type="radio" name="selected_label" value="<?= get_the_ID() ?>" required>
			<label for="category-<?= get_the_ID() ?>">
				<img src="<?= $thumb_url ?>" class="lk24-category-thumbnail" width="320" alt="<?= get_the_title() ?>" title="<?= get_the_title() ?>">
				<h2><?= get_the_title() ?></h2>
			</label>
		</div>
		<?php
				} // END WHILE
			}else{
		?>
		<p><?= _e('Thera are no labels on this category','likommerce') ?></p>
		<?php } // END IF ?>
	</div>
</form>
<?php
}else{
?>
<form name="lk24-select-category" role="form" method="post">
	<input type="hidden" name="parentid" value="<?= $parent_id ?>">
	<input type="hidden" name="qty" value="<?= $quantity ?>">
	<div class="lk24-category-selection-title">
		<div>
			<h5><?= _e('Parent Product', 'likommerce') ?></h5>
			<ul class="parent-product-meta">
				<li><?= '<strong>'. esc_html_x('Licor Selected','likormmerce') . ':</strong> <a href="'.$parent_link.'">' . $parent_name . '('. esc_html_x('edit','likormeerce') .')</a>' ?> - &euro;<?= $parent_regular_price ?></li>
				<li><?= '<strong>'. esc_html_x('Quantity','likormmerce') . ':</strong> ' . $quantity .' '. _n('box', 'boxes', $quantity, 'likommerce') ?></li>
				<li><?= '<strong>'. esc_html_x('Subtotal','likormmerce') . ':</strong> &euro;' . $subtotal ?></li>
			</ul>
			<h1><?= _e('Select label category') ?></h1>
		</div>
		<button type="submit" name="category-selected" value="true"><?= _e('Next Step' , 'likommerce') ?></button>
	</div>
	<div class="lk24-product-list lk24-label-category-list">
		<?php
			$categories = get_terms( 'labelcategory', array(
				'hide_empty' => false,
			) );
	  		$thumb_url = LIKOMMERCE_PLUGIN_URI . '/app/images/lk24-thumbnail-placeholder.jpg';
	  		foreach($categories as $cat){
				$term_id = $cat->term_id;
				$term_name = $cat->name;
				$term_slug = $cat->slug;
				$term_meta = get_option( "taxonomy_$term_id" );
				if($term_meta[lk24labelimg]){
					$term_attachment_id = $term_meta[lk24labelimg];
					$term_image = wp_get_attachment_image_src( $term_attachment_id, 'medium');
					$thumb_url = $term_image[0];
				}
		?>
		<div id="category-<?= $term_slug ?>" class="lk24-product-info-placeholder lk24-category-item category-<?= $term_slug ?>">
			<input id="category-<?= $term_id ?>" type="radio" name="selected_category" value="<?= $term_id ?>" required>
			<label for="category-<?= $term_id ?>">
				<img src="<?= $thumb_url ?>" class="lk24-category-thumbnail" width="320" alt="<?= $term_name ?>" title="<?= $term_name ?>">
				<h2><?= $term_name ?></h2>
			</label>
		</div>
		<?php } // END FOREACH ?>
	</div>
</form>
<?php
} // END IF HAVEN'T SELECTED CATEGORY
get_footer();
