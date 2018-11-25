<?php
/**
 * REGISTER CUSTOM POST TYPE FOR LABELS
 */
if ( ! function_exists('lk24_cpt_labels') ) {

	function lk24_cpt_labels() {

		$labels = array(
			'name'                  => _x( 'Labels', 'Post Type General Name', 'lk24' ),
			'singular_name'         => _x( 'Label', 'Post Type Singular Name', 'lk24' ),
			'menu_name'             => __( 'Labels', 'lk24' ),
			'name_admin_bar'        => __( 'Labels', 'lk24' ),
			'archives'              => __( 'Labels Archives', 'lk24' ),
			'attributes'            => __( 'Labels Attributes', 'lk24' ),
			'parent_item_colon'     => __( 'Parent Label:', 'lk24' ),
			'all_items'             => __( 'All Labels', 'lk24' ),
			'add_new_item'          => __( 'Add New Labels', 'lk24' ),
			'add_new'               => __( 'Add New', 'lk24' ),
			'new_item'              => __( 'New Label', 'lk24' ),
			'edit_item'             => __( 'Edit Label', 'lk24' ),
			'update_item'           => __( 'Update Label', 'lk24' ),
			'view_item'             => __( 'View Label', 'lk24' ),
			'view_items'            => __( 'View Labels', 'lk24' ),
			'search_items'          => __( 'Search Label', 'lk24' ),
			'not_found'             => __( 'Not label found', 'lk24' ),
			'not_found_in_trash'    => __( 'Not label found in Trash', 'lk24' ),
			'featured_image'        => __( 'Label Image', 'lk24' ),
			'set_featured_image'    => __( 'Set label image', 'lk24' ),
			'remove_featured_image' => __( 'Remove label image', 'lk24' ),
			'use_featured_image'    => __( 'Use as label image', 'lk24' ),
			'insert_into_item'      => __( 'Insert into label', 'lk24' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Label', 'lk24' ),
			'items_list'            => __( 'Labels list', 'lk24' ),
			'items_list_navigation' => __( 'Labels list navigation', 'lk24' ),
			'filter_items_list'     => __( 'Filter Labels list', 'lk24' ),
		);
		$rewrite = array(
			'slug'                  => 'label',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Label', 'lk24' ),
			'description'           => __( 'Likoer 24 Label', 'lk24' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			'taxonomies'            => array( 'labels' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true, // After dev set to false
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'labels',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'query_var'             => 'label',
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
			'rest_base'             => 'lk24-labels',
		);
		register_post_type( 'lk24-labels', $args );

	}
	add_action( 'init', 'lk24_cpt_labels', 0 );

}