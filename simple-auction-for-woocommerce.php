<?php

/**
 * Plugin Name: Simple Auction for WooCommerce
 * Description: Simplified auction feature that works with woocommerce.
 * Version: 1.0
 * Author: Jethro
 * Author URI: 
 * Text Domain: simple-auction-for-woocommerce
 * Domain Path: /languages/
 * Requires at least: 5.7
 * Requires PHP: 7.2
 */

defined('ABSPATH') || exit;

// Path Constants ======================================================================================================

define('SAFW_PLUGIN_URL',             plugins_url() . '/simple-auction-for-woocommerce/');
define('SAFW_PLUGIN_DIR',             plugin_dir_path(__FILE__));
define('SAFW_CSS_ROOT_URL',           SAFW_PLUGIN_URL . 'css/');
define('SAFW_JS_ROOT_URL',            SAFW_PLUGIN_URL . 'js/');

// Require autoloader
require_once 'inc/autoloader.php';

// Run
require_once 'simple-auction-for-woocommerce.plugin.php';
$safw = Simple_Auction_For_WooCommerce::instance();
$GLOBALS['safw'] = $safw;
