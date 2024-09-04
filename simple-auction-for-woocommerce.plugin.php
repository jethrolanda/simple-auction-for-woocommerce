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
  public $emails;

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
    $this->emails = SAFW\Plugin\Emails::instance();
  }

  /**
   * Singleton Pattern.
   *
   * @since 1.0.0
   */
  public static function instance()
  {

    if (!self::$_instance instanceof self) {
      self::$_instance = new self;
    }

    return self::$_instance;
  }

  /**
   * Check if only free version is active
   *
   * @since 1.0.0
   */
  public function is_free_plugin()
  {
    return apply_filters('safw_is_free_plugin', true);
  }
}
