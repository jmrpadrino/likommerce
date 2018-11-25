<?php
/* 
 * @wordpress-plugin
 * Plugin Name: Likommerce
 * Plugin URI: https://github.com/jmrpadrino/likommerce
 * Version: 0.1
 * Description: This plugin provides this website with an e-commerce tool, exclusive to "Likoer24.de". It has been made under the specific requirement of Likoer24. With this plugin the customer when visiting the website will be able to accommodate his pack of 24 bottles labeled with the label and liquor flavor of his preference. It comes with different payment methods, sends the invoice to the customer and allows you to have a sales history.
 * Author: José Rodriguez
 * Author URI: https://github.com/jmrpadrino/likommerce
 * Text Domain: likommerce
 * Domain Path: /languages
 * License: GPLv3
 */
/*
    Likommerce is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation version 3.

    Likommerce is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Likommerce.
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'LIKOMMERCE_BASE_NAME', plugin_basename(__FILE__) );
define( 'LIKOMMERCE_PLUGIN_DIR', trailingslashit( dirname(__FILE__) ) );
define( 'LIKOMMERCE_PLUGIN_URI', plugins_url( '', __FILE__) );

/* ADMIN */
require_once 'app/likommerce-setup.php';					// Likommerce Definitions
require_once 'app/likommerce-admin.php';					// Likommerce WordPress Admin Behaviors
require_once 'app/likommerce-settings.php';					// Likommerce WordPress Admin Settings

/* BACKEND */
require_once 'backend/cpt/likommerce-labels.php'; 			// Likommerce Custom Post types or Labels
require_once 'backend/cpt/likommerce-likor.php'; 			// Likommerce Custom Post types or Licors
require_once 'backend/cpt/likommerce-sales.php'; 			// Likommerce Custom Post types or Sales
require_once 'backend/tax/likommerce-tax.php'; 				// All e-commerce Custom Taxonomies
require_once 'backend/user/likommerce-user.php'; 			// All e-commerce Add Custom User
require_once 'backend/metaboxes/likommerce-metaboxes.php'; 			// All e-commerce Add Custom User

/* SHORTCODES */
require_once 'shortcodes/likommerce-shortcodes.php'; 		// All e-commerce Add Custom User

/* FRONTEND */
require_once 'shop/likommerce-shop-setup.php'; 	// All e-commerce Add Custom User

function mostrar($arreglo){
	echo '<pre>';
	var_dump($arreglo);
	echo '</pre>';
} 


