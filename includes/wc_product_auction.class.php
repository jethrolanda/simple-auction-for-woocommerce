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

    /**
     * Over write Woocommerce get_price_html for Auction Product
     */
    public function get_price_html($price = '')
    {
      global $safw;
      $start_date = $this->get_auction_start_date();
      $end_date = $this->get_auction_end_date();
      $is_bidding_started = current_time('timestamp') >= strtotime($start_date);
      $is_bidding_ended = current_time('timestamp') >= strtotime($end_date);

      if ($is_bidding_started) {
        $future_date = new DateTime($end_date, wp_timezone());
      } else {
        $future_date = new DateTime($start_date, wp_timezone());
      }

      $now = new DateTime("now", wp_timezone());
      $interval = $now->diff($future_date);

      $time_left = $interval->format("%a") > 0 ? $interval->format("%a") . ' Days ' : '';
      $time_left .= $interval->format("%h") > 0 ? $interval->format("%h") . ' Hours ' : '';
      $time_left .= $interval->format("%i") > 0 ? $interval->format("%i") . ' Minutes ' : '';
      $time_left .= $interval->format("%s") > 0 ? $interval->format("%s") . ' Seconds' : '';

      if ($is_bidding_started) {
        $time_left = "Time Left: " . $time_left;
      } else {
        $time_left = "Starting Soon: " . $time_left;
      }

      // if ($safw->is_free_plugin()) return apply_filters('woocommerce_get_price_html', wc_price($this->get_price()), $this);
      // $id = $this->get_safw_product_id();

      // if ($this->is_woo_ua_closed() && $this->is_woo_ua_started()) {

      //   if ($this->get_woo_ua_auction_closed() == '3') {

      //     $price = __('<span class="woo-ua-sold-for sold_for">Sold for</span>: ', 'ultimate-woocommerce-auction') . wc_price($this->get_price());
      //   } elseif ($this->get_auction_current_bid()) {

      //     if ($this->is_woo_ua_reserve_met() == false) {

      //       // Translators: This string is used when the reserve price is not met.
      //       $reserve_not_met_text = __('Reserve price Not met!', 'ultimate-woocommerce-auction');
      //       $price = sprintf('<span class="woo-ua-winned-for reserve_not_met">%s</span>', esc_html($reserve_not_met_text));
      //     } else {
      //       // Translators: This string is used to indicate the winning bid in the auction.
      //       $winning_bid_text = __('Winning Bid', 'ultimate-woocommerce-auction');
      //       $price = sprintf('<span class="woo-ua-winned-for winning_bid">%s</span>: %s', esc_html($winning_bid_text), wc_price($this->get_auction_current_bid()));
      //     }
      //   } else {
      //     // Translators: This string is used to indicate that the auction has expired.
      //     $expired_text = __('Auction Expired', 'ultimate-woocommerce-auction');
      //     $price = sprintf('<span class="woo-ua-winned-for expired">%s</span>', esc_html($expired_text));
      //   }
      // } elseif (! $this->is_woo_ua_started()) {

      //   $price = '<span class="woo-ua-auction-price starting-bid" data-auction-id="' . $id . '" data-bid="' . $this->get_auction_current_bid() . '" data-status="">' . __('<span class="uwa-starting auction">Starting bid</span>: ', 'ultimate-woocommerce-auction') . wc_price($this->get_woo_ua_current_bid()) . '</span>';
      // } elseif (! $this->get_auction_current_bid()) {

      //   $price = '<span class="woo-ua-auction-price starting-bid" data-auction-id="' . $id . '" data-bid="' . $this->get_auction_current_bid() . '" data-status="running">' . __('<span class="woo-ua-current auction">Starting bid</span>: ', 'ultimate-woocommerce-auction') . wc_price($this->get_woo_ua_current_bid()) . '</span>';
      // } else {
      //   $price = '<span class="woo-ua-auction-price current-bid" data-auction-id="' . $id . '" data-bid="' . $this->get_auction_current_bid() . '" data-status="running">' . __('<span class="woo-ua-current auction">Current bid</span>: ', 'ultimate-woocommerce-auction') . wc_price($this->get_woo_ua_current_bid()) . '</span>';
      // }



      $context = array(
        'start_date' => $start_date,
        'end_date' => $end_date,
        'is_bidding_started' => $is_bidding_started,
        'is_bidding_ended' => $is_bidding_ended,
        'time_left' =>  $time_left,
      );

      if (is_shop()) {
        $price = $this->get_auction_current_bid();
        $price_html = '<span class="safw-auction-price">';
        $price_html .= wc_price($price);
        $price_html .= sprintf(__("<span><label>Start Date:</label> %s</span>", 'simple-auction-for-woocommerce'), $this->get_auction_start_date());
        $price_html .= sprintf(__("<span><label>End Date:</label> %s</span>", 'simple-auction-for-woocommerce'), $this->get_auction_end_date());
        $price_html .= '<div class="auction" data-wp-interactive="auction" data-wp-watch="callbacks.timer" ' . wp_interactivity_data_wp_context($context) . '>';
        if ($context['is_bidding_ended']) {
          $price_html .= '<div>Bidding Ended!</div>';
        } else {
          $price_html .= '<div data-wp-text="context.time_left">' . $time_left . '</div>';
        }

        $price_html .= '</div>';
        $price_html .= '</span>';
        return apply_filters('woocommerce_get_price_html',  $price_html, $this);
      }

      return apply_filters('woocommerce_get_price_html', wc_price($this->get_price()), $this);
    }

    /**
     * Get Product Auction Main Product Id
     */
    function get_safw_product_id()
    {

      global $sitepress;

      /* For WPML Support - start */
      if (function_exists('icl_object_id') && function_exists('pll_default_language')) {
        $id = icl_object_id($this->id, 'product', false, pll_default_language());
      } elseif (function_exists('icl_object_id') && is_object($sitepress) && method_exists(
        $sitepress,
        'get_default_language'
      )) {
        $id = icl_object_id(
          $this->id,
          'product',
          false,
          $sitepress->get_default_language()
        );
      } else {
        $id = $this->id;
      }
      /* For WPML Support - end */

      return $id;
    }

    // HELPER FUNCTIONS

    /**
     * Get Auction Type
     */
    public function get_auction_type($name = false)
    {

      $type = get_post_meta($this->get_safw_product_id(), '_auction_type', true);

      if ($name) {
        switch ($type) {
          case 'english':
            return 'English Auction';
          case 'dutch':
            return 'Dutch Auction';
        }
      }

      return $type;
    }

    /**
     * Get Item Condition
     */
    public function get_auction_item_condition()
    {

      $condition = get_post_meta($this->get_safw_product_id(), '_auction_condition', true);

      switch ($condition) {
        case "new":
          return "New";
          break;
        case "old":
          return "Old";
          break;
        default:
          return "New";
      }
    }

    /**
     * Get Auction Product Current Bid
     */
    public function get_auction_current_bid()
    {

      $starting_price = get_post_meta($this->get_safw_product_id(), '_price', true);

      return $starting_price;
    }

    /**
     * Get Auction Product Bid Increment
     */
    public function get_auction_bid_increment()
    {

      $increment = get_post_meta($this->get_safw_product_id(), '_auction_increment', true);

      return $increment;
    }

    /**
     * Get Auction Start Date
     */
    public function get_auction_start_date()
    {

      $starting_price = get_post_meta($this->get_safw_product_id(), '_auction_start_date', true);

      return $starting_price;
    }

    /**
     * Get Auction End Date
     */
    public function get_auction_end_date()
    {

      $starting_price = get_post_meta($this->get_safw_product_id(), '_auction_end_date', true);

      return $starting_price;
    }

    /**
     * Get Auction End Date
     */
    public function get_all_offers()
    {

      $offers = get_post_meta($this->get_safw_product_id(), '_auction_offers', true);

      $offers_data = array();

      if (!empty($offers)) {
        foreach ($offers as $key => $offer) {
          $user = get_userdata($offer['uid']);
          $offers_data[] = array(
            'id' => $key,
            'name' => $user->display_name,
            'price' => $offer['price'],
            'uid' => $offer['uid']
          );
        }
      }

      return $offers_data;
    }
  }
}
