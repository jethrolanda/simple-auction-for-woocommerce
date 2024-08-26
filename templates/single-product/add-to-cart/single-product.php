<?php

/**
 * Auction product add to cart
 */
/* Exit if accessed directly */
if (! defined('ABSPATH')) {
  exit;
}

global $product;

?>
<form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
  <p>
    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>">Buy Now</button>

    <a href="#" class="button">Make Offer</a>
  </p>


  <p>Highest Offer</p>
  <p>View all Offers</p>
</form>