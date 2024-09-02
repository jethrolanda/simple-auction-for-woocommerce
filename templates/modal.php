<!-- The Modal -->
<div id="myModal" class="auction modal">

  <!-- Modal content -->
  <div class="modal-content">
    <?php wp_nonce_field('modal_place_offer', 'place_offer'); ?>
    <span class="close">&times;</span>
    <p>Offer Price:</p>
    <input type="number" class="input-text qty bid text left">
    <button class="single_add_to_cart_button button alt wp-element-button place-offer"><span class="dashicons dashicons-tag"></span> Place Offer</button>
  </div>

</div>