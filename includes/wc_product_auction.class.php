<?php
if (!defined('ABSPATH')) {
  exit;
}
// Exit if accessed directly
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
    public function __construct($product = 0)
    {
      // $this->product_type = 'auction';
      // $this->virtual      = 'yes';
      // $this->supports[]   = 'ajax_add_to_cart';

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
  }
}
