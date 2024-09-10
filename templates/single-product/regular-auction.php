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

$starting_price = get_post_meta($id, '_price', true);
$ending_price = get_post_meta($id, '_auction_ending_price', true);

require_once SAFW_PLUGIN_DIR . 'templates/modal.php';

$offers = $product->get_all_offers();
$product_info = array('offers' => $offers);
?>

<form class="cart" data-product-attr="<?php echo htmlspecialchars(json_encode($product_info), ENT_QUOTES, 'UTF-8'); ?>" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>

  <!-- Display the countdown timer in an element -->
  <p>Condition: <?php echo $product->get_auction_item_condition(); ?></p>
  <?php
  // Auction Started
  if (current_time('timestamp') >= strtotime($start_date)) {
    echo '<div>';
    echo '<p>Time left: <span id="bid_ends"></span> ' . esc_html(wp_timezone_string()) . '</p>';
    $newDate = date("M d, Y H:i", strtotime($end_date)) . ' ' . esc_html(wp_timezone_string());
    echo '<p>Auction ends: ' . $newDate . '</p>';
    echo '</div>';
  } else {
    echo '<div>Starting Soon! <p id="bid_start"></p></div>';
  }
  ?>

  <input id="auction_start_date" type="hidden" value="<?php echo $start_date; ?>" />
  <input id="auction_end_date" type="hidden" value="<?php echo $end_date; ?>" />
  <input id="auction_starting_price" type="hidden" value="<?php echo $starting_price; ?>" />
  <input id="auction_ending_price" type="hidden" value="<?php echo $ending_price; ?>" />
  <input id="auction_date_now" type="hidden" value="<?php echo date('Y-m-d H:i:s') ?>" />

  <p>
    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>">Buy Now</button>
  </p>
  <p><a href="#" id="myBtn">Make Offer</a></p>

  <p><small>Highest Offer</small></p>
  <p><small>All Offers</small></p>

</form>

<?php
// Global State
wp_interactivity_state('clickme', array(
  'someValue' => 'asd'
));

$offers_data = array();
foreach ($offers as $key => $offer) {
  $user = get_userdata($offer['uid']);
  // error_log(print_r($user, true));
  $offers_data[] = array(
    'id' => $key,
    'name' => $user->display_name,
    'price' => $offer['price']
  );
}
// Local State/Context
$context = array('isOpen' => false, 'offers' => $offers_data);
// wp_interactivity_data_wp_context() = data-wp-context directive
?>
<div
  class="clickme"
  data-wp-interactive="clickme"
  data-wp-watch="callbacks.logIsOpen"
  <?php echo wp_interactivity_data_wp_context($context); ?>>
  <!-- Make Offer -->
  <button
    data-wp-on--click="actions.toggle"
    data-wp-bind--aria-expanded="context.isOpen"
    aria-controls="p-1">
    Toggle
  </button>

  <!-- Active Offers -->
  <table class="bid-offers" cellspacing="0">
    <tr>
      <th>Name</th>
      <th>Bid</th>
      <th>Time
      <th>
    </tr>
    <?php

    foreach ($context['offers'] as $offer) {
      error_log(print_r($offer, true));
    ?>
      <tr <?php echo wp_interactivity_data_wp_context($offer); ?>>
        <td data-wp-text="context.name"></td>
        <td data-wp-text="context.price"></td>
        <td data-wp-text="context.name"></td>
      </tr>
    <?php
    }
    ?>
  </table>

  </ul>
  <button
    data-wp-on--click="actions.toggle"
    data-wp-bind--aria-expanded="context.isOpen"
    aria-controls="p-1">
    Toggle
  </button>

  <p id="p-1" data-wp-bind--hidden="!context.isOpen">
    This element is now visible!
  </p>
</div>