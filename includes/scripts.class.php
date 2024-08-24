<?php

namespace SAFW\Plugin;

/**
 * Scripts class
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

class Scripts
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

        // Product Add to cart
        // add_action('woocommerce_auction_add_to_cart', array($this, 'woocommerce_uwa_auction_add_to_cart'), 30);
        // Bidding Area On single product page
        add_action('woocommerce_auction_add_to_cart', array($this, 'woocommerce_uwa_auction_bid'));
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
        error_log($product->get_type());
        if (method_exists($product, 'get_type') && $product->get_type() == 'auction') {

            \wc_get_template('single-product.php', array(), SAFW_TEMPLATES_ROOT_DIR);
        }
    }
}
