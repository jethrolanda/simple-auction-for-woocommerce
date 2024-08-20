<?php

namespace SAFW\Plugin;


if (! class_exists('WC_Product_Auction')) {


  /**
   * Custom Product class.
   */
  class WC_Product_Auction extends \WC_Product
  {

    /**
     * Constructor of this class.
     *
     * @param object $product product.
     */
    public function __construct($product = array())
    {
      // $this->product_type = 'auction';
      // $this->virtual      = 'yes';
      // $this->supports[]   = 'ajax_add_to_cart';

      add_filter('product_type_selector', array($this, 'auction_custom_product_type'));

      add_action('woocommerce_product_options_general_product_data', array($this, 'bbloomer_custom_product_type_show_price'));

      parent::__construct($product);
    }


    /**
     * Return the product type.
     *
     * @return string
     */
    public function get_type()
    {
      return 'auction';
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

    function bbloomer_custom_product_type_show_price()
    {
      global $product_object;
      if ($product_object && 'auction' === $product_object->get_type()) {
        wc_enqueue_js("
            $('.product_data_tabs .general_tab').addClass('show_if_custom').show();
            $('.pricing').addClass('show_if_custom').show();
         ");
      }
    }
  }
}
