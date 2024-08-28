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
error_log(print_r(strtotime($start_date), true));
error_log(print_r(strtotime($end_date), true));
?>
<form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
  <!-- Display the countdown timer in an element -->
  <p id="demo"></p>
  <p id="auction_price"></p>
  <input id="auction_start_date" type="hidden" value="<?php echo $start_date; ?>" />
  <input id="auction_end_date" type="hidden" value="<?php echo $end_date; ?>" />
  <input id="auction_starting_price" type="hidden" value="<?php echo $starting_price; ?>" />
  <input id="auction_ending_price" type="hidden" value="<?php echo $ending_price; ?>" />
  <input id="auction_date_now" type="hidden" value="<?php echo date('Y-m-d H:i:s') ?>" />

  <p>
    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>">Buy Now</button>

    <a href="#" class="button">Make Offer</a>
  </p>


  <p>Highest Offer</p>
  <p>View all Offers</p>
</form>