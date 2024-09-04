<?php

namespace SAFW\Plugin;

/**
 * Plugins custom settings page that adheres to wp standard
 * see: https://developer.wordpress.org/plugins/settings/custom-settings-page/
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

/**
 * AJAX Class.
 */
class AJAX
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
    add_action("wp_ajax_safw_place_offer", array($this, 'safw_place_offer'));
    add_action("wp_ajax_nopriv_safw_place_offer", array($this, 'safw_place_offer'));
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

  public function safw_place_offer()
  {
    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    /**
     * Verify nonce
     */
    if (isset($_REQUEST['nonce']) && !wp_verify_nonce($_REQUEST['nonce'], 'modal_place_offer')) {
      wp_die();
    }

    try {
      if (!isset($_REQUEST['offer']) || !isset($_REQUEST['uid']) || !isset($_REQUEST['pid'])) return;

      $uid = $_REQUEST['uid'];
      $pid = $_REQUEST['pid'];
      $offer = $_REQUEST['offer'];

      $offers = get_post_meta($pid, "_auction_offers", true);

      if (empty($offers)) {
        $offers = array();
      }

      array_push($offers, array(
        'uid' => $uid,
        'price' => $offer
      ));

      update_post_meta($pid, '_auction_offers', $offers);
      error_log(print_r($offers, true));

      $user = get_userdata($uid);
      wp_send_json(array(
        'status' => 'success',
        'data' => array(
          'name' => $user->display_name,
          'price' => $offer
        ),
        'offers' => $offers
      ));
    } catch (\Exception $e) {

      wp_send_json(array(
        'status' => 'error',
        'message' => $e->getMessage()
      ));
    }
  }
}
