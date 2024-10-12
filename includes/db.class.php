<?php

namespace SAFW\Plugin;

/**
 * Emails class
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

class Db
{

  /**
   * The single instance of the class.
   *
   * @since 1.0
   */
  protected static $_instance = null;

  public $table_name = 'auctions';

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
   * Create a new custom db table
   *
   * @since 1.0.0
   */
  public function create_custom_db_table()
  {

    global $wpdb;
    $table_name = $wpdb->prefix . $this->table_name;

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        product_id mediumint(9) NOT NULL,
        user_id mediumint(9) NOT NULL,
        bid_price VARCHAR(100) NOT NULL,
        PRIMARY KEY  (id)
      ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Create table
    dbDelta($sql);
  }

  /**
   * Save data
   *
   * @since 1.0.0
   */
  public function save_entry($product_id, $user_id, $bid_price)
  {

    global $wpdb;
    $table_name = $wpdb->prefix . $this->table_name;

    $wpdb->insert(
      $table_name,
      array(
        'date' => current_datetime()->format('Y-m-d H:i:s'),
        'product_id' => $product_id,
        'user_id' => $user_id,
        'bid_price' => $bid_price,
      ),
      array(
        '%s',
        '%s',
        '%s',
        '%s',
      )
    );
  }

  /**
   * Get fuel savings data.
   * 
   * @since 1.0
   */
  public function get_product_bids($product_id)
  {

    global $wpdb;

    $table_name = $wpdb->prefix . $this->table_name;
    $data = $wpdb->get_results("SELECT * FROM $table_name WHERE product_id = " . $product_id);
    error_log(print_r($data, true));
    return $data;
  }

  /**
   * Get fuel savings data.
   * 
   * @since 1.0
   */
  public function get_user_bids($user_id)
  {

    global $wpdb;

    $table_name = $wpdb->prefix . $this->table_name;
    $data = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id = " . $user_id);
    error_log(print_r($data, true));
    return $data;
  }


  /**
   * Delete fuel savings data item.
   * 
   * @since 1.0
   */
  public function fscs_delete_fuel_savings_data_item()
  {

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    /**
     * Verify nonce
     */
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'settings_nonce')) {
      wp_die();
    }

    try {

      global $wpdb;

      $id = isset($_POST['id']) ? (int) $_POST['id'] : '';

      if ($id) {

        $table_name = $wpdb->prefix . 'fuel_savings_report';
        $result = $wpdb->delete($table_name, array('id' => $id));

        if ($result) {
          wp_send_json(array(
            'status' => 'success',
            'message' => 'The item is now deleted.',
            'id' => $id
          ));
        } else {
          wp_send_json(array(
            'status' => 'error',
            'message' => 'Unable to delete.'
          ));
        }
      } else {

        wp_send_json(array(
          'status' => 'error',
          'message' => 'Invalid item id.'
        ));
      }
    } catch (\Exception $e) {

      wp_send_json(array(
        'status' => 'error',
        'message' => $e->getMessage()
      ));
    }
  }
}
