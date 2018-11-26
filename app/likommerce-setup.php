<?php
/**
 * DEFINITIONS 
 */

define('LK24_DEFAULT_THUMBNAIL', plugin_basename(__FILE__) . '');
define('META_PREFIX', 'lk24_');

global 	$licor, 
		$label, 
		$quote, 
		$user;

$licor 	= '';
$label 	= '';
$quote 	= '';
$user 	= '';
// https://codex.wordpress.org/Global_Variables

/**
 * ADDING SETTING LINK ON PLUGIN LIST 
 */

add_filter( 'plugin_action_links','lk24_settings_plugin_link', 10, 2 );
function lk24_settings_plugin_link( $links, $file ){
	if ( $file == LIKOMMERCE_BASE_NAME ){
        /*
         * Insert the link at the beginning
         */
        //$in = '<a href="options-general.php?page=likommerce-settings">' . __('Settings','likommerce') . '</a>';
        //array_unshift($links, $in);

        /*
         * Insert at the end
         */
        $links[] = '<a href="options-general.php?page=likommerce-settings">'.__('Settings','likommerce').'</a>';
    }
    return $links;
}
// https://wordpress.stackexchange.com/questions/25030/adding-plugin-settings-link-upon-activation

add_action('pre_get_posts', function(){
    flush_rewrite_rules();
});

function lk24_shop_scripts(){
	wp_register_style( 'lk24-shop', LIKOMMERCE_PLUGIN_URI . '/shop/css/likommerce-shop.css', false, '1.0.0' );
	wp_enqueue_style( 'lk24-shop' );
}
add_action('wp_enqueue_scripts', 'lk24_shop_scripts');
