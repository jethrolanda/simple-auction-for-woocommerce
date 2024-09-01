<?php

namespace SAFW\Plugin;

defined('ABSPATH') || exit(); // Exit if accessed directly.

class Auction
{

  /**
   * The single instance of the class.
   *
   * @since 1.0
   */
  protected static $_instance = null;

  /**
   * Auction_CPT constructor
   *   
   * @access public
   * @since 1.0
   */
  public function __construct()
  {

    // Bidding Area On single product page
    add_action('woocommerce_auction_add_to_cart', array($this, 'display_auction_data_single_product_page'));

    // Clear cart on add to cart
    add_filter('woocommerce_add_to_cart_validation', array($this, 'so_validate_add_cart_item'), 10, 5);

    // Redirect to checkout page
    add_action('woocommerce_add_to_cart', array($this, 'add_to_cart_action'), 90);
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

  /**
   * Auction Page template
   *
   * Add the auction template
   * 
   * @since 1.0
   * @return void
   */
  public function display_auction_data_single_product_page()
  {

    global $product;

    if (method_exists($product, 'get_type') && $product->get_type() == 'auction') {

      wc_get_template('single-product/add-to-cart/single-product.php', array(), '', SAFW_TEMPLATES_ROOT_DIR);
    }
  }

  /**
   * Empty cart on add to cart
   *
   * @since 1.0
   * @return bool
   */
  public static function so_validate_add_cart_item($passed, $product_id, $quantity, $variation_id = '', $variations = '')
  {
    WC()->cart->empty_cart();
    return $passed;
  }

  /**
   * Rediret to checkout page on add to cart
   *
   * @since 1.0
   * @return void
   */
  public static function add_to_cart_action($url = false)
  {
    wp_safe_redirect(\wc_get_checkout_url());
    exit;
  }
}
