<?php
/**
 * SHOP SETUP
 */

/**
 * CREATING DATBASE TABLES FOR TEMPORAL CART SHOP
 */
/**
 * dataStructureConfiguration: acción que se ejecuta cuando los
 * plugins se cargan. Se crean las tablas para almacenar tamporalmente
 * los datos del trayecto del pedido del usuario.
 */
function lk24_data_structure_configuration(){

    global $wpdb;

    $collate = '';
    if ( $wpdb->has_cap( 'collation' ) ) {
        $collate = $wpdb->get_charset_collate();
    }

    $tablequote = $wpdb->prefix . 'lk24_orders';
    $tablequoteitems = $wpdb->prefix . 'lk24_order_items';
    $tablecustomer = $wpdb->prefix . 'lk24_customers';
    $tablebilling = $wpdb->prefix . 'lk24_billing_info';

    if ( $wpdb->get_var("SHOW TABLES LIKE '" . $tablequote . "'") != $tablequote ){
        // QUOTE HEADER TABLE
        $sql = 'CREATE TABLE `' . $tablequote . '` (
		`id` BIGINT(20) UNSIGNED AUTO_INCREMENT,
        `cookie_sesion` VARCHAR(255),
        `date` DATETIME,
		`tax_rate` BIGINT(20),
        PRIMARY KEY (id)
        ) '.$collate.'; ';

		// QUOTE CUSTOMER TABLE
        $sql .= 'CREATE TABLE `' . $tablequoteitems . '` (
        `id` BIGINT(20) UNSIGNED AUTO_INCREMENT,
        `id_order` BIGINT(20),
        `parent_id` BIGINT(20),
		`qty` INT(4),
		`parent_price` BIGINT(20),
		`child_id` BIGINT(20),
		`child_price` BIGINT(20),
		`nonce` VARCHAR(250),
        PRIMARY KEY (id)
        ) '.$collate.'; ';

        // QUOTE CUSTOMER TABLE
        $sql .= 'CREATE TABLE `' . $tablecustomer . '` (
        `id` BIGINT(20) UNSIGNED AUTO_INCREMENT,
        `id_order` BIGINT(20),
        `main` BOOLEAN,
        `set_invoice` BOOLEAN,
        `title` VARCHAR(10),
        `name` VARCHAR(250),
        `lastname` VARCHAR(250),
        `gender` VARCHAR(20),
        `phone` VARCHAR(25),
        `email` VARCHAR(250),
        `day` INT(2),
        `month` INT(2),
        `year` INT(4),
        `country` VARCHAR(2),
        `state` INT(255),
        `street` text,
        `city` text,
        `zip_code` text,
        PRIMARY KEY (id)
        ) '.$collate.'; ';

		// QUOTE BILLING INFORMATION TABLE
        $sql .= 'CREATE TABLE `' . $tablebilling . '` (
        `id` BIGINT(20) UNSIGNED AUTO_INCREMENT,
        `id_order` BIGINT(20),
        `title` VARCHAR(10),
        `name` VARCHAR(250),
        `lastname` VARCHAR(250),
        `gender` VARCHAR(20),
        `phone` VARCHAR(25),
        `email` VARCHAR(250),
        `day` INT(2),
        `month` INT(2),
        `year` INT(4),
        `country` VARCHAR(2),
        `state` INT(255),
        `street` text,
        `city` text,
        `zip_code` text,
        PRIMARY KEY (id)
        ) '.$collate.'; ';

//        mostrar($sql);
//        die;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        dbDelta($sql);

    }
}
add_action('plugins_loaded', 'lk24_data_structure_configuration');

/**
 * REDIRECTIONS TO PROPPER VIEWS
 */
function lk24_template_redirect_checkout( ){
    if ( strpos($_SERVER['REQUEST_URI'], 'likommerce-checkout/') ) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(LIKOMMERCE_PLUGIN_DIR . 'shop/templates/likommerce-checkout.php');
        exit();
    }
	if ( strpos($_SERVER['REQUEST_URI'], 'select-label-category') ) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(LIKOMMERCE_PLUGIN_DIR . 'shop/templates/likommerce-label-category-list.php');
        exit();
    }
	if ( strpos($_SERVER['REQUEST_URI'], 'likommerce-cart') ) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(LIKOMMERCE_PLUGIN_DIR . 'shop/templates/likommerce-cart.php');
        exit();
    }
}
add_action( 'template_redirect', 'lk24_template_redirect_checkout' );
// https://markjaquith.wordpress.com/2014/02/19/template_redirect-is-not-for-loading-templates/
// https://mihaivalentin.com/wordpress-tutorial-load-the-template-you-want-with-template_redirect/

/**
 * TEMPLATES FOR PROPPER VIEWS
 */

function lk24_include_template( $template )
{	
	/**
	 * TEMPLATES FOR ARCHIVE VIEWS
	 */

	// ARCHIVE TEMPLATE FOR LABELS
	if( is_post_type_archive( 'lk24-labels' ) ) {
        // Use Plugin template
        $template = LIKOMMERCE_PLUGIN_DIR 
            . 'shop/templates/archive-lk24-labels.php';
        // to override archive template
        $active_template = TEMPLATEPATH;
        if (is_child_theme()){
            $active_template = STYLESHEETPATH;
        }
        
        $archive_file = scandir($active_template);
        $found = array_search('archive-lk24-labels.php', $archive_file);
        
        if ($found){
            $template = $active_template . '/archive-lk24-labels.php';
        }
    }

	// ARCHIVE TEMPLATE FOR LICOR
    if( is_post_type_archive( 'lk24-liquor' ) ) {
        // Use Plugin template
        $template = LIKOMMERCE_PLUGIN_DIR 
            . 'shop/templates/archive-lk24-liquor.php';
        // to override archive template
        $active_template = TEMPLATEPATH;
        if (is_child_theme()){
            $active_template = STYLESHEETPATH;
        }
        
        $archive_file = scandir($active_template);
        $found = array_search('archive-lk24-liquor.php', $archive_file);
        
        if ($found){
            $template = $active_template . '/archive-lk24-liquor.php';
        }
    }

	/**
	 * TEMPLATES FOR CATEGORIES VIEWS
	 */
    
    // SINGLE TEMPLATE FOR LABELS
    if( is_tax( 'labelcategory' ) ) {
        // Use Plugin template
        $template = LIKOMMERCE_PLUGIN_DIR
            . 'shop/templates/single-lk24-labels.php';
        // to override archive template
        $active_template = TEMPLATEPATH;
        if (is_child_theme()){
            $active_template = STYLESHEETPATH;
        }
        $archive_file = scandir($active_template);
        $found = array_search('single-lk24-labels.php', $archive_file);
        if ($found){
            $template = $active_template . '/single-lk24-labels.php';
        }
    }

    /**
	 * TEMPLATES FOR SINGLE VIEWS
	 */

    // SINGLE TEMPLATE FOR LABELS
    if( is_singular( 'lk24-labels' ) || is_single( 'lk24-labels' ) ) {
        // Use Plugin template
        $template = LIKOMMERCE_PLUGIN_DIR
            . 'shop/templates/single-lk24-labels.php';
        // to override archive template
        $active_template = TEMPLATEPATH;
        if (is_child_theme()){
            $active_template = STYLESHEETPATH;
        }
        $archive_file = scandir($active_template);
        $found = array_search('single-lk24-labels.php', $archive_file);
        if ($found){
            $template = $active_template . '/single-lk24-labels.php';
        }
    }

	// SINGLE TEMPLATE FOR LICOR
    if( is_singular( 'lk24-liquor' ) || is_single( 'lk24-liquor' ) ) {
        // Use Plugin template
        $template = LIKOMMERCE_PLUGIN_DIR
            . 'shop/templates/single-lk24-liquor.php';
        // to override archive template
        $active_template = TEMPLATEPATH;
        if (is_child_theme()){
            $active_template = STYLESHEETPATH;
        }
        $archive_file = scandir($active_template);
        $found = array_search('single-lk24-liquor.php', $archive_file);
        if ($found){
            $template = $active_template . '/single-lk24-liquor.php';
        }
    }

    return $template;
}
add_filter( 'template_include', 'lk24_include_template' );
