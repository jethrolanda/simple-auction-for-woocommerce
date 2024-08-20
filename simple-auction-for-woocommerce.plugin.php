<?php
if (!defined('ABSPATH')) {
  exit;
}
// Exit if accessed directly


class Simple_Auction_For_WooCommerce
{

  /*
    |------------------------------------------------------------------------------------------------------------------
    | Class Members
    |------------------------------------------------------------------------------------------------------------------
     */
  private static $_instance;

  public $scripts;
  public $auction_product;
  // public $settings;
  // public $cron;

  const VERSION = '1.0';

  /*
  |------------------------------------------------------------------------------------------------------------------
  | Mesc Functions
  |------------------------------------------------------------------------------------------------------------------
  */

  /**
   * Class constructor.
   *
   * @since 1.0.0
   */
  public function __construct()
  {

    add_action('woocommerce_loaded', array($this, 'wc_custom_produt'));

    $this->scripts = \SAFW\Plugin\Scripts::instance();

    // $this->settings = \SAFW\Plugin\Settings::instance();

    // Register Activation Hook
    // register_activation_hook(SAFW_PLUGIN_DIR . 'simple-auction-for-woocommerce.php', array($this, 'activate'));

    // Register Deactivation Hook
    // register_deactivation_hook(SAFW_PLUGIN_DIR . 'simple-auction-for-woocommerce.php', array($this, 'deactivate'));
  }

  /**
   * Singleton Pattern.
   *
   * @since 1.0.0
   *
   * @return USA_Gas_Prices
   */
  public static function instance()
  {

    if (!self::$_instance instanceof self) {
      self::$_instance = new self;
    }

    return self::$_instance;
  }

  /**
   * Load custom product.
   */
  public function wc_custom_produt()
  {

    $this->auction_product = new \SAFW\Plugin\WC_Product_Auction();
  }

  /**
   * Trigger on activation
   *
   * @since 1.0.0
   */
  public function activate() {}

  /**
   * Trigger on deactivation
   *
   * @since 1.0.0
   */
  public function deactivate() {}
}
