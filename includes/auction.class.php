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
    // Product Add to cart
    // add_action('woocommerce_auction_add_to_cart', array($this, 'woocommerce_uwa_auction_add_to_cart'), 30);
    // Bidding Area On single product page
    add_action('woocommerce_auction_add_to_cart', array($this, 'woocommerce_uwa_auction_bid'));

    // add_action('wp_loaded', array($this, 'add_to_cart_action'), 20);

    add_filter('woocommerce_add_to_cart_validation', array($this, 'so_validate_add_cart_item'), 10, 5);
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
   *  Auction Product Add to Cart Area.
   *
   * @package Ultimate WooCommerce Auction
   * @author Nitesh Singh
   * @since 1.0
   * @return void
   */
  public function woocommerce_uwa_auction_add_to_cart()
  {

    global $product;

    if (method_exists($product, 'get_type') && $product->get_type() == 'auction') {
      error_log(SAFW_TEMPLATES_ROOT_DIR);
      \wc_get_template('single-product.php', array(), SAFW_TEMPLATES_ROOT_DIR);
      // wc_get_template_html(
      //   'single-product\add-to-cart',
      //   array(
      //     'test' => "123"
      //   ),
      //   '',
      //   SAFW_TEMPLATES_ROOT_DIR
      // );
    }
  }

  /**
   * Auction Page template
   *
   * Add the auction template
   *
   * @package Ultimate WooCommerce Auction
   * @author Nitesh Singh
   * @since 1.0
   * @return void
   */
  public function woocommerce_uwa_auction_bid()
  {

    global $product;

    if (method_exists($product, 'get_type') && $product->get_type() == 'auction') {

      wc_get_template('single-product/add-to-cart/single-product.php', array(), '', SAFW_TEMPLATES_ROOT_DIR);
    }
  }

  public static function so_validate_add_cart_item($passed, $product_id, $quantity, $variation_id = '', $variations = '')
  {
    WC()->cart->empty_cart();
    return $passed;
  }

  public static function add_to_cart_action($url = false)
  {
    wp_safe_redirect(\wc_get_checkout_url());
    exit;
  }
}
