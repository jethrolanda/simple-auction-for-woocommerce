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
?>

<form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>

  <!-- Display the countdown timer in an element -->
  <p>Condition: <?php echo $product->get_auction_item_condition(); ?></p>
  <p>Timezone: <?php echo esc_html(wp_timezone_string()); ?></p>
  <?php
  // Auction Started
  if (current_time('timestamp') >= strtotime($start_date)) {
    echo '<div>';
    echo '<p>Time left: <span id="bid_ends"></span></p>';
    $newDate = date("M d, Y H:i", strtotime($end_date));
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
  <p><small>View all Offers</small></p>
  <table>
    <tr>
      <th>Name</th>
      <th>Price</th>
    </tr>
    <?php
    $offers = $product->get_all_offers();
    foreach ($offers as $offer) {
      echo '<tr>';
      $user = get_userdata($offer['uid']);
      // error_log(print_r($user, true));
      echo "<td>" . $user->display_name . "</td>";
      echo "<td>" . $offer['price'] . "</td>";
      echo '</tr>';
    }
    ?>
  </table>
</form>