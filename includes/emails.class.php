<?php

namespace SAFW\Plugin;

/**
 * Emails class
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

class Emails
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
  public function __construct() {}

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
   * Email sender.
   *
   * @since 1.0.0
   */
  public function send_email($params)
  {
    extract($params);
    wp_mail($to, $subject, $body, $headers);
  }

  /**
   * Send an email if user submits an offer.
   * Send to user and admin.
   *
   * @since 1.0.0
   */
  public function offer_submitted($send_to)
  {
    $this->send_email(array(
      'to'      => $send_to,
      'subject' => 'The subject',
      'body'    => 'The email body content',
      'headers' => array('Content-Type: text/html; charset=UTF-8'),
    ));
  }

  /**
   * Submit an email if previous highest bidder has been countered.
   * Send to previous highest bidder and admin.
   *
   * @since 1.0.0
   */
  public function counter_offer_submitted($send_to)
  {
    $this->send_email(array(
      'to'      => $send_to,
      'subject' => 'Countered offer!',
      'body'    => 'The email body content',
      'headers' => array('Content-Type: text/html; charset=UTF-8'),
    ));
  }

  /**
   * Submit an email if user won the auction. Add link to add product to cart and checkout.
   * Send to auction winner.
   *
   * @since 1.0.0
   */
  public function auction_won($send_to)
  {
    $this->send_email(array(
      'to'      => $send_to,
      'subject' => 'You won the auction!',
      'body'    => 'The email body content',
      'headers' => array('Content-Type: text/html; charset=UTF-8'),
    ));
  }
}
