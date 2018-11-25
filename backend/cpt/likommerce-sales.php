<?php
/**
 * REGISTER CUSTOM POST TYPE FOR SALES
 */
if ( ! function_exists('lk24_cpt_sales') ) {

	function lk24_cpt_sales() {

		$labels = array(
			'name'                  => _x( 'Sales', 'Post Type General Name', 'lk24' ),
			'singular_name'         => _x( 'Sale', 'Post Type Singular Name', 'lk24' ),
			'menu_name'             => __( 'Sales', 'lk24' ),
			'name_admin_bar'        => __( 'Sales', 'lk24' ),
			'archives'              => __( 'Sales Archives', 'lk24' ),
			'attributes'            => __( 'Sales Attributes', 'lk24' ),
			'parent_item_colon'     => __( 'Parent Sale:', 'lk24' ),
			'all_items'             => __( 'All Sales', 'lk24' ),
			'add_new_item'          => __( 'Add New Sales', 'lk24' ),
			'add_new'               => __( 'Add New', 'lk24' ),
			'new_item'              => __( 'New Sale', 'lk24' ),
			'edit_item'             => __( 'Edit Sale', 'lk24' ),
			'update_item'           => __( 'Update Sale', 'lk24' ),
			'view_item'             => __( 'View Sale', 'lk24' ),
			'view_items'            => __( 'View Sales', 'lk24' ),
			'search_items'          => __( 'Search Sale', 'lk24' ),
			'not_found'             => __( 'Not Sale found', 'lk24' ),
			'not_found_in_trash'    => __( 'Not Sale found in Trash', 'lk24' ),
			'featured_image'        => __( 'Sale Image', 'lk24' ),
			'set_featured_image'    => __( 'Set Sale image', 'lk24' ),
			'remove_featured_image' => __( 'Remove Sale image', 'lk24' ),
			'use_featured_image'    => __( 'Use as Sale image', 'lk24' ),
			'insert_into_item'      => __( 'Insert into Sale', 'lk24' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Sale', 'lk24' ),
			'items_list'            => __( 'Sales list', 'lk24' ),
			'items_list_navigation' => __( 'Sales list navigation', 'lk24' ),
			'filter_items_list'     => __( 'Filter Sales list', 'lk24' ),
		);
		$args = array(
			'label'                 => __( 'Sale', 'lk24' ),
			'description'           => __( 'Likoer24 Sales and Quotes', 'lk24' ),
			'labels'             	=> $labels,
			'supports'              => array( 'title'),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => true, // After dev set to false
			'menu_position'         => 5,
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
			'query_var'             => 'sale',
			'capability_type'       => 'post',
			'capabilities' => array(
				'create_posts' => false, 
			),
			'map_meta_cap' => false,
			//https://codepad.co/snippet/mF6HAnth
			'show_in_rest'          => true,
			'rest_base'             => 'lk24-sales',
		);
		register_post_type( 'lk24_sale', $args );

	}
	add_action( 'init', 'lk24_cpt_sales', 0 );

}