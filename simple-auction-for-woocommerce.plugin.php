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
  public $auction;
  public $settings;
  public $ajax;

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

    $this->scripts = SAFW\Plugin\Scripts::instance();
    $this->auction = SAFW\Plugin\Auction::instance();
    $this->settings = SAFW\Plugin\Settings::instance();
    $this->ajax = SAFW\Plugin\AJAX::instance();
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

  public function is_free_plugin()
  {
    return apply_filters('safw_is_free_plugin', true);
  }
}
