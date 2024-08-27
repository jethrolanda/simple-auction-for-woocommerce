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

    add_action('woocommerce_loaded', array($this, 'wc_custom_produt'));
    add_filter('product_type_selector', array($this, 'auction_custom_product_type'));
    add_action('woocommerce_product_data_panels', array($this, 'wkwc_add_product_data_tab_content'));

    add_filter('woocommerce_product_data_tabs', array($this, 'uwa_custom_product_tabs'));
    add_action('woocommerce_product_data_panels', array($this, 'uwa_options_product_tab_content'));

    // Save Auction Product Data
    add_action(
      'woocommerce_process_product_meta_auction',
      array(
        $this,
        'uwa_save_auction_option_field',
      )
    );

    add_action(
      'woocommerce_process_product_meta',
      array(
        $this,
        'uwa_process_product_option_field',
      )
    );
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
    require_once SAFW_PLUGIN_DIR . 'includes/wc_product_auction.class.php';
  }

  /**
   * Custom product type.
   *
   * @param array $types Product types.
   *
   * @return void
   */
  public function auction_custom_product_type($types)
  {
    $types['auction'] = esc_html__('Auction product', 'simple-auction-for-woocommerce');

    return $types;
  }

  /**
   * Add product data tab content.
   *
   * @return void
   */
  public function wkwc_add_product_data_tab_content()
  {
    global $product_object;
?>
    <div id="wkwc_cusotm_product_data_html" class="panel woocommerce_options_panel">
      <div class="options_group">
        <?php
        woocommerce_wp_text_input(
          array(
            'id'          => '_wkwc_name',
            'label'       => esc_html__('Name', 'wkcp'),
            'value'       => $product_object->get_meta('_wkwc_name', true),
            'default'     => '',
            'placeholder' => esc_html__('Enter your name', 'wkcp'),
          )
        );
        ?>
      </div>
    </div>
  <?php
  }

  /**
   * Add a custom product tab.
   *
   * @package Ultimate WooCommerce Auction
   * @author Nitesh Singh
   * @since 1.0
   */
  public function uwa_custom_product_tabs($product_data_tabs)
  {
    $auction_tab = array(
      'auction_tab' => array(
        'label'  => __('Auction', 'simple-auction-for-woocommerce'),
        'target' => 'auction_options',
        'class'  => array('show_if_auction', 'hide_if_grouped', 'hide_if_external', 'hide_if_variable', 'hide_if_simple'),
      ),
    );

    // unset($product_data_tabs['inventory']);
    // error_log(print_r($auction_tab + $product_data_tabs, true));
    return $auction_tab + $product_data_tabs;
  }

  /**
   * Contents of the Auction  Product options product tab.
   *
   * @package Ultimate WooCommerce Auction
   * @author Nitesh Singh
   * @since 1.0
   */
  public function uwa_options_product_tab_content()
  {
    global $post;
    $product = \wc_get_product($post->ID);
  ?>
    <div id='auction_options' class='panel woocommerce_options_panel'>
      <div class='options_group'>
        <?php
        wp_nonce_field('save_auction_fields', 'auction_fields');
        \woocommerce_wp_select(
          array(
            'id'          => 'auction[type]',
            'class'       => 'auction_type',
            'label'       => __('Auction Type', 'simple-auction-for-woocommerce'),
            'options'     => apply_filters('ultimate_woocommerce_auction_product_condition', array(
              'incresing_price'   => __('Increasing Price', 'simple-auction-for-woocommerce'),
              'decreasing_price'  => __('Decreasing Price', 'simple-auction-for-woocommerce'),
            )),
            'desc_tip'    => true,
            'description' => __('Set the price where the price of the product will start from.', 'simple-auction-for-woocommerce'),
            'value'       => get_post_meta($post->ID, '_auction_type', true)
          )
        );
        \woocommerce_wp_text_input(
          array(
            'id'                => 'auction[price]',
            'class'             => 'auction_price',
            'label'             => __('Starting Price', 'simple-auction-for-woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')',
            'desc_tip'          => 'true',
            'description'       => __('Set the price where the price of the product will start from.', 'simple-auction-for-woocommerce'),
            'data_type'         => 'price',
            'custom_attributes' => array(
              'step' => 'any',
              'min'  => '0',
            ),
            'value' => get_post_meta($post->ID, '_price', true)
          )
        );
        \woocommerce_wp_text_input(
          array(
            'id'                => 'auction[ending_price]',
            'class'             => 'auction_ending_price',
            'label'             => __('Ending Price', 'simple-auction-for-woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')',
            'desc_tip'          => 'true',
            'description'       => __('Set the price where the price of the product will start from.', 'simple-auction-for-woocommerce'),
            'data_type'         => 'price',
            'custom_attributes' => array(
              'step' => 'any',
              'min'  => '0',
            ),
            'value' => get_post_meta($post->ID, '_auction_lowest_price', true)
          )
        );
        \woocommerce_wp_text_input(
          array(
            'id'                => 'auction[increment]',
            'class'             => 'auction_increment',
            'label'             => __('Increment', 'simple-auction-for-woocommerce'),
            'desc_tip'          => 'true',
            'description'       => __('Set the price where the price of the product will start from.', 'simple-auction-for-woocommerce'),
            'data_type'         => 'price',
            'type' => 'number',
            'custom_attributes' => array(
              'step' => 'any',
              'min'  => '0',
            ),
            'value' => get_post_meta($post->ID, '_auction_increment', true)
          )
        );

        $date_now = wp_date('Y-m-d H:i:s', strtotime('+1 day', time()), wp_timezone());
        $start_date = get_post_meta($post->ID, '_auction_start_date', true);
        $end_date = get_post_meta($post->ID, '_auction_end_date', true);
        \woocommerce_wp_text_input(
          array(
            'id'          => 'auction[start_date]',
            'class'       => 'auction_start_date',
            'label'       => __('Start Date', 'simple-auction-for-woocommerce'),
            'desc_tip'    => 'true',
            'description' => __('Set the price where the price of the product will start from.', 'simple-auction-for-woocommerce'),
            'data_type'   => 'date',
            'type'        => 'text',
            'value'       => $start_date !== "" ? $start_date : $date_now
          )
        );

        \woocommerce_wp_text_input(
          array(
            'id'          => 'auction[end_date]',
            'class'       => 'auction_end_date',
            'label'       => __('End Date', 'simple-auction-for-woocommerce'),
            'desc_tip'    => 'true',
            'description' => __('Set the price where the price of the product will start from.', 'simple-auction-for-woocommerce'),
            'data_type'   => 'date',
            'type'        => 'text',
            'value'       => $end_date !== "" ? $end_date : $date_now
          )
        );
        ?>
      </div>
    </div>
<?php
  }

  /**
   * Save Auction Product Data.
   *
   * @package Ultimate WooCommerce Auction
   * @author Nitesh Singh
   * @since 1.0
   */
  function uwa_save_auction_option_field($post_id)
  {
    if (wp_verify_nonce($_REQUEST['auction_fields'], 'save_auction_fields')) {
      $data = $_POST['auction'];
      if (isset($data) && !empty($data)) {
        foreach ($data as $key => $value) {
          if ($key === 'price') {
            update_post_meta($post_id, $key, $value);
          } else {
            update_post_meta($post_id, '_auction_' . $key, $value);
          }
        }
      }
    }
  }


  /**
   * Process/save other Product Data.
   *
   * @package Ultimate WooCommerce Auction
   * @author Nitesh Singh
   * @since 1.0
   */
  public function uwa_process_product_option_field($post_id)
  {
    if (wp_verify_nonce($_REQUEST['auction_fields'], 'save_auction_fields')) {
      error_log(print_r('uwa_process_product_option_field', true));
      error_log(print_r($post_id, true));
    }
  }
}
