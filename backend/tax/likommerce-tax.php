<?php

if ( ! function_exists( 'lk24_label_categories' ) ) {

// Register Custom Taxonomy
function lk24_label_categories() {

	$labels = array(
		'name'                       => _x( 'Label Categories', 'Taxonomy General Name', 'likommerce' ),
		'singular_name'              => _x( 'Label Category', 'Taxonomy Singular Name', 'likommerce' ),
		'menu_name'                  => __( 'Categories', 'likommerce' ),
		'all_items'                  => __( 'All Items', 'likommerce' ),
		'parent_item'                => __( 'Parent Item', 'likommerce' ),
		'parent_item_colon'          => __( 'Parent Item:', 'likommerce' ),
		'new_item_name'              => __( 'New Item Name', 'likommerce' ),
		'add_new_item'               => __( 'Add New Item', 'likommerce' ),
		'edit_item'                  => __( 'Edit Item', 'likommerce' ),
		'update_item'                => __( 'Update Item', 'likommerce' ),
		'view_item'                  => __( 'View Item', 'likommerce' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'likommerce' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'likommerce' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'likommerce' ),
		'popular_items'              => __( 'Popular Items', 'likommerce' ),
		'search_items'               => __( 'Search Items', 'likommerce' ),
		'not_found'                  => __( 'Not Found', 'likommerce' ),
		'no_terms'                   => __( 'No items', 'likommerce' ),
		'items_list'                 => __( 'Items list', 'likommerce' ),
		'items_list_navigation'      => __( 'Items list navigation', 'likommerce' ),
	);
	$rewrite = array(
		'slug'                       => 'label-category',
		'with_front'                 => true,
		'hierarchical'               => true,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'query_var'                  => 'labels-categories',
		'rewrite'                    => $rewrite,
		'show_in_rest'               => true,
		'rest_base'                  => 'label-categories',
	);
	register_taxonomy( 'labelcategory', array( 'lk24-labels' ), $args );

}
add_action( 'init', 'lk24_label_categories', 0 );

}