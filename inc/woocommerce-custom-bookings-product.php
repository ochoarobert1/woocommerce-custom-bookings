<?php 
function woocommerce_custom_booking_product_fields() {
?>
<div class="woocommerce-custom-single-input-wrapper">
    <label for="ads_duration">Commercial Duration: </label>
    <select name="ads_duration" id="ads_duration" class="form-control">
        <option value="15">15 Seconds</option>
        <option value="30" selected>30 Seconds</option>
        <option value="45">45 Seconds</option>
        <option value="60">1 Minute</option>
    </select>
</div>
<?php 

}

add_action('woocommerce_before_add_to_cart_button', 'woocommerce_custom_booking_product_fields');
