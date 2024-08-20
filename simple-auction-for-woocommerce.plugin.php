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
    add_filter('product_type_selector', array($this, 'auction_custom_product_type'));
    add_action('woocommerce_product_data_panels', array($this, 'wkwc_add_product_data_tab_content'));
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
}
