<?php
function woocommerce_custom_booking_product_fields() {
    $custom_booking_data['_resident_adults_price'] = get_post_meta(get_the_ID(), '_resident_adults_price', true);
    $custom_booking_data['_resident_kids_price'] = get_post_meta(get_the_ID(), '_resident_kids_price', true);
    $custom_booking_data['_foreigner_adults_price'] = get_post_meta(get_the_ID(), '_foreigner_adults_price', true);
    $custom_booking_data['_foreigner_kids_price'] = get_post_meta(get_the_ID(), '_foreigner_kids_price', true);
    $custom_booking_data['_checkbox'] = get_post_meta(get_the_ID(), '_checkbox', true);
    $custom_booking_data['_transport_price'] = get_post_meta(get_the_ID(), '_transport_price', true);
    $custom_booking_data['_date_selector'] = get_post_meta(get_the_ID(), '_date_selector', true);
?>
<div class="accordion custom-bookings-accordion" id="accordionExample">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <button class="btn btn-link" type="button">
                    1.- <?php _e('Residentes', 'woocommerce-custom-bookings'); ?> <span></span>
                </button>
            </h2>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <h5><?php _e('Seleccione la cantidad de Pasajeros', 'woocommerce-custom-bookings'); ?></h5>
                <table class="variations custom-variations">
                    <tr>
                        <td><?php _e('Adultos', 'woocommerce-custom-bookings'); ?></td>
                        <td><input type="number" class="special-input"></td>
                    </tr>
                    <tr>
                        <td><?php _e('Niños', 'woocommerce-custom-bookings'); ?></td>
                        <td><input type="number" class="special-input"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <button class="btn btn-link collapsed" type="button">
                    2.- <?php _e('Extranjeros', 'woocommerce-custom-bookings'); ?> <span></span>
                </button>
            </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <h5><?php _e('Seleccione la cantidad de Pasajeros', 'woocommerce-custom-bookings'); ?></h5>
                <table class="variations custom-variations">
                    <tr>
                        <td><?php _e('Adultos', 'woocommerce-custom-bookings'); ?></td>
                        <td><input type="number" class="special-input"></td>
                    </tr>
                    <tr>
                        <td><?php _e('Niños', 'woocommerce-custom-bookings'); ?></td>
                        <td><input type="number" class="special-input"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php if ($custom_booking_data['_checkbox'] == 'yes') { ?>
    <div class="card">
        <div class="card-header" id="headingThree">
            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <button class="btn btn-link collapsed" type="button">
                    3.- <?php _e('Transporte', 'woocommerce-custom-bookings'); ?> <span></span>
                </button>
            </h2>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
            <div class="card-body">
                <h5><?php _e('Seleccione si desea el servicio de transporte', 'woocommerce-custom-bookings'); ?></h5>
                <table class="variations custom-variations">
                    <tr>
                        <td colspan="2"><input id="special-checkbox" type="checkbox" /> <label for="special-checkbox"><?php _e('Servicio de Transporte', 'woocommerce-custom-bookings'); ?> <span>(+ $ <?php echo $custom_booking_data['_transport_price']; ?> de recargo).</span></label></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="card">
        <div class="card-header" id="headingFour">
            <h2 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <button class="btn btn-link collapsed" type="button">
                    4.- <?php _e('Fechas Disponibles', 'woocommerce-custom-bookings'); ?> <span></span>
                </button>
            </h2>
        </div>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
            <div class="card-body">
                <h5><?php _e('Seleccione la fecha que se ajuste a sus necesidades', 'woocommerce-custom-bookings'); ?></h5>
                <?php if ($custom_booking_data['_date_selector'] == '') { ?>
                <?php $date_array = explode(',', $custom_booking_data['_date_selector']); ?>
                <select name="" id="">
                    <?php foreach ($date_array as $item) { ?>
                    <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                    <?php } ?>
                </select>
                <?php } else { ?>
                <input type="text"
                       data-range="true"
                       data-multiple-dates-separator=" - "
                       data-language="es"
                       class="datepicker-here datepicker-special" />
                       <span class="datepicker-quantity"></span>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php
}

add_action('woocommerce_before_add_to_cart_button', 'woocommerce_custom_booking_product_fields', 10, 0);
