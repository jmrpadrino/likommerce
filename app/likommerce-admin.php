<?php
/**
 * Admin Functions 
 */

/**
 * ADD IMAGE FIELD TO TAXONOMY 
 */

function lk24_taxonomy_add_new_meta_field(){
	// this will add the custom meta field to the add new term page
?>
<div class="form-field">
	<input type="text" value="" class="regular-text process_custom_images" id="process_custom_images" name="term_meta[lk24labelimg]">
	<button class="set_custom_images button">Set category Image</button>
	<button class="clear_custom_image button" style="color: red">Remove Image</button>
	<p class="description"><?php _e( 'Click the button above','pippin' ); ?></p>
</div>
<?php
}
add_action( 'labelcategory_add_form_fields', 'lk24_taxonomy_add_new_meta_field', 10, 2 );

function lk24_taxonomy_edit_new_meta_field($term_id){
	// this will add the custom meta field to the add new term page
	$t_id = $term_id->term_id;
	$term_meta = get_option( "taxonomy_$t_id" );
?>
<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[custom_term_meta]"><?php _e( 'Label Category Image ID', 'pippin' ); ?></label></th>
	<td>
		<?php 
			$thumb_url = LIKOMMERCE_PLUGIN_URI . '/app/images/lk24-thumbnail-placeholder.jpg';
			if ($term_meta[lk24labelimg]){
				$term_attachment_id = $term_meta[lk24labelimg];
				$term_image = wp_get_attachment_image_src( $term_attachment_id, 'medium');
				// https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
				$thumb_url = $term_image[0];
			}
		?>
		<img id="lk24-category-thumbnail" src="<?= $thumb_url ?>" width="250">
		<input type="number" value="<?= ($term_meta) ? $term_meta[lk24labelimg] : '' ?>" class="regular-text process_custom_images" id="process_custom_images" name="term_meta[lk24labelimg]">
		<button class="set_custom_images button">Set category Image</button>
		<button class="clear_custom_image button-secondary" style="color: red">Remove Image</button>
	</td>
	<p class="description"><?php _e( 'Click the button above','pippin' ); ?></p>
</tr>
<?php
}
add_action( 'labelcategory_edit_form_fields', 'lk24_taxonomy_edit_new_meta_field', 10, 2 );

add_action ( 'admin_enqueue_scripts', function () {
	if (is_admin ())
		wp_enqueue_media ();
} );
function lk24_add_script_on_taxonomy_view(){
	if (isset($_GET['taxonomy']) && ($_GET['taxonomy'] == 'labelcategory')){
?>
<script>
	jQuery(document).ready(function() {
		var $ = jQuery;
		if ($('.set_custom_images').length > 0) {
			if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
				$(document).on('click', '.set_custom_images', function(e) {
					e.preventDefault();
					var button = $(this);
					var id = button.prev();
					wp.media.editor.send.attachment = function(props, attachment) {
						id.val(attachment.id);
						lk24_input_image_changed()
					};
					wp.media.editor.open(button);
					return false;
				});
			}
		}
		$('#process_custom_images').change( function(){
			lk24_input_image_changed()
		})
		function lk24_input_image_changed(){
			console.log('hola');
			// HACER AJAX
		}
	});
</script>
<?php
	} // END IF
}
add_action('admin_head', 'lk24_add_script_on_taxonomy_view');

function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "taxonomy_$t_id", $term_meta );
	}
}  
add_action( 'edited_labelcategory', 'save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_labelcategory', 'save_taxonomy_custom_meta', 10, 2 );
//https://wordpress.stackexchange.com/questions/112592/add-media-button-in-custom-plugin

// Add the custom columns to the book post type:
function my_custom_taxonomy_columns( $columns )
{
	$columns['cat-thumb'] = __('Thumbnail', 'likommerce');

	return $columns;
}
add_filter('manage_edit-labelcategory_columns' , 'my_custom_taxonomy_columns');

// Add the data to the custom columns for the book post type:
function my_custom_taxonomy_columns_content( $content, $column_name, $term_id )
{
    if ( 'cat-thumb' == $column_name ) {
		$term_meta = get_option( "taxonomy_$term_id" );
		$thumb_url = LIKOMMERCE_PLUGIN_URI . '/app/images/lk24-thumbnail-placeholder.jpg';
		if ($term_meta[lk24labelimg]){
			$term_attachment_id = $term_meta[lk24labelimg];
			$term_image = wp_get_attachment_image_src( $term_attachment_id, 'thumbnail');
			$thumb_url = $term_image[0];
		}
        $content = '<img src="'.$thumb_url.'" width="40">';
    }
	return $content;
}
add_filter( 'manage_labelcategory_custom_column', 'my_custom_taxonomy_columns_content', 10, 3 );
// https://codex.wordpress.org/Plugin_API/Filter_Reference/manage_$taxonomy_id_columns

function lk24_admin_scripts(){
	wp_register_style( 'lk24_admin_css', LIKOMMERCE_PLUGIN_URI . '/app/css/likommerce-admin-style.css', false, '1.0.0' );
	wp_register_style( 'lk24_icons_pack', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css', false, '5.5.0' );
	wp_enqueue_style( 'lk24_admin_css' );
	wp_enqueue_style( 'lk24_icons_pack' );
}
add_action('admin_enqueue_scripts', 'lk24_admin_scripts');