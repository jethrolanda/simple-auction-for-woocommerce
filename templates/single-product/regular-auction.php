<?php

/**
 * Auction product add to cart
 */
/* Exit if accessed directly */
if (! defined('ABSPATH')) {
  exit;
}

global $product;

$id = $product->get_id();
$start_date = get_post_meta($id, '_auction_start_date', true);
$end_date = get_post_meta($id, '_auction_end_date', true);

$offers = $product->get_all_offers();

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


// Global State
wp_interactivity_state('auction', array(
  'ajax_url' => admin_url('admin-ajax.php'),
  'nonce' => wp_create_nonce('modal_place_offer'),
  'uid' => get_current_user_id(),
  'pid' => $product->get_id(),
));



$is_bidding_started = current_time('timestamp') >= strtotime($start_date);
$is_bidding_ended = current_time('timestamp') >= strtotime($end_date);

$now = new DateTime("now", wp_timezone());
$future_date = new DateTime($start_date, wp_timezone());

$interval = $now->diff($future_date);

echo $interval->format("%a Days %h Hours %i Minutes %s seconds");
error_log(print_r($now, true));
error_log(print_r($future_date, true));

// Local State/Context
$context = array(
  'isOpen' => false,
  'offers' => $offers_data,
  'offerPrice' => 0,
  'start_date' => $product->get_auction_start_date(),
  'end_date' => $product->get_auction_end_date(),
  'is_bidding_started' => $is_bidding_started,
  'is_bidding_ended' => $is_bidding_ended,
  'time_left' =>  $interval->format("%a Days %h Hours %i Minutes %s seconds"),
  'auction_price' => ''
);
// wp_interactivity_data_wp_context() = data-wp-context directive

echo "<p>Condition: " . $product->get_auction_item_condition() . "</p>";
echo "<p>Start Date: " . $start_date . "</p>";
echo "<p>End Date: " . $end_date . "</p>";
?>

<div
  class="auction"
  data-wp-interactive="auction"
  data-wp-watch="callbacks.timer"
  <?php echo wp_interactivity_data_wp_context($context); ?>>

  <!-- Countdown Timer -->
  <?php if ($context['is_bidding_ended']) { ?>
    <div>Bidding Ended!</div>
  <?php
  } else {
    echo '<div data-wp-text="context.time_left"></div>';
  } ?>


  <!-- Make Offer -->
  <div class="make-offer">
    <input class="input-text" type="number" id="offer-price" name="offer-price" min="1" data-wp-on--keyup="callbacks.setOfferPrice">
    <button
      class="woocommerce-Button button wp-element-button place-bid"
      data-wp-on--click="actions.submitOffer">
      <span class="dashicons dashicons-tag"></span> Place Bid
    </button>
  </div>

  <!-- Active Offers -->
  <ul class="list-offers">
    <li>
      <span>Name</span>
      <span>Price</span>
      <span>Date</span>
    </li>
    <template
      data-wp-each--offer="context.offers"
      data-wp-each-key="context.offer.id">
      <li>
        <span data-wp-text="context.offer.name"></span>
        <span data-wp-text="context.offer.price"></span>
        <span data-wp-text="context.offer.price"></span>
      </li>
    </template>
  </ul>
  <?php foreach ($offers_data as $offer) {  ?>
    <tr <?php echo wp_interactivity_data_wp_context($offer); ?>>
      <td data-wp-text="context.name"></td>
      <td data-wp-text="context.price"></td>
      <td data-wp-text="context.name"></td>
    </tr>
  <?php } ?>
  </ul>
</div>