<?php
/**
 * COOKIES
 */
// CREATE COOKIE
function lk24_create_cookie(){
    if(!isset($_COOKIE['lk24_cart_cookie'])){

        $cookie = md5(strtotime(date('Ymd h:i:s')));

        setcookie(
			'lk24_cart_cookie',
			$cookie,
			time() + (365 * 24 * 60 * 60), // SET 1 YEAR LIFETIME
			COOKIEPATH,
			COOKIE_DOMAIN
		); // 1 año
    }else{
        $cookie = $_COOKIE['lk24_cart_cookie'];
    }
    return $cookie;
}

// REMOVE COOKIE
function lk24_remove_cookie(){
    unset($_COOKIE['lk24_cart_cookie']);
    setcookie(
		'lk24_cart_cookie',
		'',
		time() - ( 15 * 60 ), // SET LESS THAN CURRENT MOMMENT
		COOKIEPATH,
		COOKIE_DOMAIN
	);
};

/**
 * DATABAE FUNCTIONS
 */

// CHECK IF ORDER EXISTS
function lk24_order_exists( $cookie ){
	global $wpdb;
	$sql = "SELECT * FROM "
		. $wpdb->prefix
		. "lk24_orders WHERE cookie_sesion = '"
		. $cookie
		. "'";
	$order = $wpdb->get_results($sql);
	return $order;
}

// CREAT ORDER
function lk24_create_order( $cookie, $post ){

	if (lk24_order_exists($cookie)) return;

	global $wpdb;
	$wpdb->insert(
        $wpdb->prefix . 'lk24_orders',
        array(
            'cookie_sesion' => $cookie,
            'date' => date('Y-m-d h:i:s'),
            'tax_rate' => get_option('lk24_shop_tax', 19)
        )
    );
}

// GET ORDER ID
function lk24_get_order_id($cookie){
	global $wpdb;
	$sql = "SELECT id FROM "
		. $wpdb->prefix
		. "lk24_orders WHERE cookie_sesion = '"
		. $cookie
		. "'";
	$order = $wpdb->get_results($sql);
	return $order;
}

// GET ITEMS FROM ORDER
function lk24_get_order_items($cookie){
	global $wpdb;
	$order_id = lk24_get_order_id($cookie);
	$sql = "SELECT * FROM "
		. $wpdb->prefix
		. "lk24_order_items WHERE id_order = '"
		. $order_id[0]->id
		. "'";
	$item = $wpdb->get_results($sql);

	return $item;
}

// ADD ITEM TO ORDER
function lk24_add_item_to_order($cookie, $post){

	if(lk24_find_item_order($post)) return;

	global $wpdb;
	$order_id = lk24_get_order_id($cookie);

	$wpdb->insert(
		$wpdb->prefix . 'lk24_order_items',
		array(
            'id_order' => $order_id[0]->id,
            'parent_id' => $post['parentid'],
            'qty' => $post['qty'],
            'parent_price' => lk24_get_product_price( $post['parentid'] ),
            'child_id' => $post['selected_label'],
            'child_price' => lk24_get_product_price( $post['selected_label'] ),
            'nonce' => $post['lk24_nonce']
        )
	);
}

// FIND ITEM ON ORDER
function lk24_find_item_order($post){
	global $wpdb;
	$sql = "SELECT nonce, parent_id, child_id FROM "
		. $wpdb->prefix
		. "lk24_order_items WHERE nonce = '"
		. $post['lk24_nonce']
		. "' AND parent_id = '"
		. $post['parentid']
		. "' AND child_id = '"
		. $post['selected_label']
		. "'";
	$item = $wpdb->get_results($sql);

	return $item;
}

// REMOVE ITEM FROM ORDER
function lk24_remode_item_from_order(){
	$wpdb->delete( 'table', array( 'ID' => 1 ) );
}

/**
 * CART FUNCTIONS
 */

// GET PRODUCT PRICE
function lk24_get_product_price( $id ){
	$price = get_post_meta($id, META_PREFIX . 'regular_price', true);
	return $price;
}

// REORDER PRODUCTO INFO TO MATCH TABLE STRUCTURE
function lk24_reorder_item_info($item){
	$parent_product = get_post($item->parent_id);
	$child_product = get_post($item->child_id);
	$thumb = get_the_post_thumbnail_url($item->parent_id, 'thumbnail');
	$row = array(
		'label_thumb_url' => $thumb,
		'label_name' => $parent_product->post_title,
		'label_price' => lk24_get_product_price($parent_product->ID),
		'licor_name' => $child_product->post_title,
		'licor_price' => lk24_get_product_price($child_product->ID),
		'qty' => $item->qty
	);

	if('lk24-liquor' == $parent_product->post_type){
		$thumb = get_the_post_thumbnail_url($item->child_id, 'thumbnail');
		$row = array(
			'label_thumb_url' => $thumb,
			'label_name' => $child_product->post_title,
			'label_price' => lk24_get_product_price($child_product->ID),
			'licor_name' => $parent_product->post_title,
			'licor_price' => lk24_get_product_price($parent_product->ID),
			'qty' => $item->qty
		);
	}
	return $row;
}
