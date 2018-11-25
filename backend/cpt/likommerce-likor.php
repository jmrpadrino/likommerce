<?php
/**
 * REGISTER CUSTOM POST TYPE FOR LIQUOR
 */
if ( ! function_exists('lk24_cpt_liqueurs') ) {

	function lk24_cpt_liqueurs() {

		$labels = array(
			'name'                  => _x( 'Liqueurs', 'Post Type General Name', 'lk24' ),
			'singular_name'         => _x( 'Liquor', 'Post Type Singular Name', 'lk24' ),
			'menu_name'             => __( 'Liqueurs', 'lk24' ),
			'name_admin_bar'        => __( 'Liqueurs', 'lk24' ),
			'archives'              => __( 'Liqueurs Archives', 'lk24' ),
			'attributes'            => __( 'Liqueurs Attributes', 'lk24' ),
			'parent_item_colon'     => __( 'Parent Liquor:', 'lk24' ),
			'all_items'             => __( 'All Liqueurs', 'lk24' ),
			'add_new_item'          => __( 'Add New Liqueurs', 'lk24' ),
			'add_new'               => __( 'Add New', 'lk24' ),
			'new_item'              => __( 'New Liquor', 'lk24' ),
			'edit_item'             => __( 'Edit Liquor', 'lk24' ),
			'update_item'           => __( 'Update Liquor', 'lk24' ),
			'view_item'             => __( 'View Liquor', 'lk24' ),
			'view_items'            => __( 'View Liqueurs', 'lk24' ),
			'search_items'          => __( 'Search Liquor', 'lk24' ),
			'not_found'             => __( 'Not Liquor found', 'lk24' ),
			'not_found_in_trash'    => __( 'Not Liquor found in Trash', 'lk24' ),
			'featured_image'        => __( 'Liquor Image', 'lk24' ),
			'set_featured_image'    => __( 'Set Liquor image', 'lk24' ),
			'remove_featured_image' => __( 'Remove Liquor image', 'lk24' ),
			'use_featured_image'    => __( 'Use as Liquor image', 'lk24' ),
			'insert_into_item'      => __( 'Insert into Liquor', 'lk24' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Liquor', 'lk24' ),
			'items_list'            => __( 'Liqueurs list', 'lk24' ),
			'items_list_navigation' => __( 'Liqueurs list navigation', 'lk24' ),
			'filter_items_list'     => __( 'Filter Liqueurs list', 'lk24' ),
		);
		$rewrite = array(
			'slug'                  => 'liquor',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Liquor', 'lk24' ),
			'description'           => __( 'Likoer 24 Liquor', 'lk24' ),
			'labels'             	=> $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'taxonomies'            => array( 'liqueurs' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true, // After dev set to false
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'Liqueurs',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'query_var'             => 'Liquor',
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
			'rest_base'             => 'lk24-Liqueurs',
		);
		register_post_type( 'lk24-liquor', $args );

	}
	add_action( 'init', 'lk24_cpt_liqueurs', 0 );

}