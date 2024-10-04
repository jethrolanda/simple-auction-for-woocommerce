<?php

namespace SAFW\Plugin;

/**
 * Plugins custom settings page that adheres to wp standard
 * see: https://developer.wordpress.org/plugins/settings/custom-settings-page/
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

class Account
{

  /**
   * The single instance of the class.
   *
   * @since 1.0
   */
  protected static $_instance = null;


  /**
   * Class constructor.
   *
   * @since 1.0.0
   */
  public function __construct()
  {
    add_action('init', array($this, 'bbloomer_add_premium_support_endpoint'));
    add_filter('query_vars', array($this, 'bbloomer_premium_support_query_vars'), 0);
    add_filter('woocommerce_account_menu_items', array($this, 'bbloomer_add_premium_support_link_my_account'));
    add_action('woocommerce_account_premium-support_endpoint', array($this, 'bbloomer_premium_support_content'));
    // Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format
  }

  /**
   * Main Instance.
   * 
   * @since 1.0
   */
  public static function instance()
  {
    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }


  // ------------------
  // 1. Register new endpoint (URL) for My Account page
  // Note: Re-save Permalinks or it will give 404 error

  function bbloomer_add_premium_support_endpoint()
  {
    add_rewrite_endpoint('premium-support', EP_ROOT | EP_PAGES);
  }


  // ------------------
  // 2. Add new query var

  function bbloomer_premium_support_query_vars($vars)
  {
    $vars[] = 'premium-support';
    return $vars;
  }


  // ------------------
  // 3. Insert the new endpoint into the My Account menu

  function bbloomer_add_premium_support_link_my_account($items)
  {
    $items['premium-support'] = 'Premium Support';
    return $items;
  }


  // ------------------
  // 4. Add content to the new tab

  function bbloomer_premium_support_content()
  {
    echo '<h3>Premium WooCommerce Support</h3>';
    echo '<p>Welcome to the WooCommerce support area. As a premium customer, you can submit a ticket should you have any WooCommerce issues with your website, snippets or customization. <i>Please contact your theme/plugin developer for theme/plugin-related support.</i></p>';
    echo do_shortcode(' /* your shortcode here */ ');
  }
}
