<?php
function woocommerce_custom_bookings_before_price_html(  $price, $product ) {
    $product_id = get_queried_object_id();
    $booking_type =  get_post_meta($product_id, '_activate_booking', true);
    if ($booking_type == 'yes') {
        // Text
        $text_regular_price = __("Desde: ");
        $text_final_price = __("");

        if ( $product->is_on_sale() ) {
            $has_sale_text = array(
                '<del>' => '<strong>' . $text_regular_price . '</strong> <del>',
                '<ins>' => $text_final_price.'<ins>'
            );
            $return_string = str_replace(
                array_keys( $has_sale_text ),
                array_values( $has_sale_text ),
                $price
            );

            return $return_string;
        }
        return $text_regular_price . $price;
    } else {
        return $price;
    }
}
add_filter( 'woocommerce_get_price_html', 'woocommerce_custom_bookings_before_price_html', 10, 2);

/* --------------------------------------------------------------
    REMOVE QUANTITY FIELD IN SINGLE PRODUCT
-------------------------------------------------------------- */

function woocommerce_custom_bookings_remove_all_quantity_fields( $return, $product ) {
    $product_id = get_queried_object_id();
    $booking_type =  get_post_meta($product_id, '_activate_booking', true);
    if ($booking_type == 'yes') {
        return true;
    }
}

add_filter( 'woocommerce_is_sold_individually','woocommerce_custom_bookings_remove_all_quantity_fields', 10, 2 );

/* --------------------------------------------------------------
    ADD CUSTOM ELEMENT FOR ADDITIONAL PRICES
-------------------------------------------------------------- */

function woocommerce_custom_bookings_change_product_price_display( $price ) {
    $price .= '<div class="price-additional"></div>';
    return $price;
}

add_filter( 'woocommerce_get_price_html', 'woocommerce_custom_bookings_change_product_price_display' );

/* --------------------------------------------------------------
    ADD CUSTOM PANEL FOR BOOKING PRODUCT TYPE
-------------------------------------------------------------- */

function woocommerce_custom_booking_product_fields() {
    $custom_booking_data['_resident_adults_price'] = get_post_meta(get_the_ID(), '_resident_adults_price', true);
    $custom_booking_data['_resident_kids_price'] = get_post_meta(get_the_ID(), '_resident_kids_price', true);
    $custom_booking_data['_foreigner_adults_price'] = get_post_meta(get_the_ID(), '_foreigner_adults_price', true);
    $custom_booking_data['_foreigner_kids_price'] = get_post_meta(get_the_ID(), '_foreigner_kids_price', true);
    $custom_booking_data['_checkbox'] = get_post_meta(get_the_ID(), '_checkbox', true);
    $custom_booking_data['_transport_price'] = get_post_meta(get_the_ID(), '_transport_price', true);
    $custom_booking_data['_date_selector'] = get_post_meta(get_the_ID(), '_date_selector', true);

    $custom_booking_data['_activate_booking'] = get_post_meta(get_the_ID(), '_activate_booking', true);

    $i = 1;
?>
<?php if ($custom_booking_data['_activate_booking'] == 'yes') { ?>
<input type="hidden" name="product_id" value="<?php echo get_the_ID(); ?>" />
<div class="accordion custom-bookings-accordion" id="bookingAccordion">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <?php echo $i; ?>.- <?php _e('Residentes', 'woocommerce-custom-bookings'); ?> <span></span>
            </h2>
        </div>
        <?php $i++; ?>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#bookingAccordion">
            <div class="card-body">
                <h5><?php _e('Seleccione la cantidad de Pasajeros', 'woocommerce-custom-bookings'); ?></h5>
                <table class="variations custom-variations">
                    <tr>
                        <td><?php _e('Adultos', 'woocommerce-custom-bookings'); ?></td>
                        <td>
                            <input type="number" name="_resident_adults" class="special-input" value="0" min="0" />
                            <small><?php _e('Precio por adulto:', 'woocommerce-custom-bookings'); ?> <?php echo get_woocommerce_currency_symbol(); ?><?php echo $custom_booking_data['_resident_adults_price']; ?></small>
                        </td>
                    </tr>
                    <tr>
                        <td><?php _e('Niños', 'woocommerce-custom-bookings'); ?></td>
                        <td>
                            <input type="number" name="_resident_kids" class="special-input" value="0" min="0">
                            <small><?php _e('Precio por niño:', 'woocommerce-custom-bookings'); ?> <?php echo get_woocommerce_currency_symbol(); ?><?php echo $custom_booking_data['_resident_kids_price']; ?></small>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTwo">
            <h2 class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <?php echo $i; ?>.- <?php _e('Extranjeros', 'woocommerce-custom-bookings'); ?> <span></span>
            </h2>
        </div>
        <?php $i++; ?>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#bookingAccordion">
            <div class="card-body">
                <h5><?php _e('Seleccione la cantidad de Pasajeros', 'woocommerce-custom-bookings'); ?></h5>
                <table class="variations custom-variations">
                    <tr>
                        <td><?php _e('Adultos', 'woocommerce-custom-bookings'); ?></td>
                        <td>
                            <input type="number" name="_foreigner_adults" class="special-input" value="0" min="0" />
                            <small><?php _e('Precio por adulto:', 'woocommerce-custom-bookings'); ?> <?php echo get_woocommerce_currency_symbol(); ?><?php echo $custom_booking_data['_foreigner_adults_price']; ?></small>
                        </td>
                    </tr>
                    <tr>
                        <td><?php _e('Niños', 'woocommerce-custom-bookings'); ?></td>
                        <td>
                            <input type="number" name="_foreigner_kids" class="special-input" value="0" min="0">
                            <small><?php _e('Precio por niño:', 'woocommerce-custom-bookings'); ?> <?php echo get_woocommerce_currency_symbol(); ?><?php echo $custom_booking_data['_foreigner_kids_price']; ?></small>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php if ($custom_booking_data['_checkbox'] == 'yes') { ?>
    <div class="card">
        <div class="card-header" id="headingThree">
            <h2 class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <?php echo $i; ?>.- <?php _e('Transporte', 'woocommerce-custom-bookings'); ?> <span></span>
            </h2>
        </div>
        <?php $i++; ?>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#bookingAccordion">
            <div class="card-body">
                <h5><?php _e('Seleccione si desea el servicio de transporte', 'woocommerce-custom-bookings'); ?></h5>
                <table class="variations custom-variations">
                    <tr>
                        <td colspan="2"><input id="special-checkbox" name="_transport_checkbox" type="checkbox" /> <label for="special-checkbox"><?php _e('Servicio de Transporte', 'woocommerce-custom-bookings'); ?> <span>(+ <?php echo get_woocommerce_currency_symbol(); ?> <?php echo $custom_booking_data['_transport_price']; ?> de recargo).</span></label></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="card">
        <div class="card-header" id="headingFour">
            <h2 class="collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <?php echo $i; ?>.- <?php _e('Fechas Disponibles', 'woocommerce-custom-bookings'); ?> <span></span>
            </h2>
        </div>
        <?php $i++; ?>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#bookingAccordion">
            <div class="card-body">
                <h5><?php _e('Seleccione la fecha que se ajuste a sus necesidades', 'woocommerce-custom-bookings'); ?></h5>
                <?php if ($custom_booking_data['_date_selector'] != '') { ?>
                <?php $date_array = explode(',', $custom_booking_data['_date_selector']); ?>
                <select name="_date_selection">
                    <?php foreach ($date_array as $item) { ?>
                    <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                    <?php } ?>
                </select>
                <?php } else { ?>
                <input type="text" class="datepicker-special" name="_date_selection" data-language='es' autocomplete="off" />
                <span class="datepicker-quantity"></span>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php
                                                              }
}

add_action('woocommerce_before_add_to_cart_button', 'woocommerce_custom_booking_product_fields', 10, 0);

/* --------------------------------------------------------------
    ADD CUSTOM PRICES IN AJAX ELEMENT
-------------------------------------------------------------- */

function woocommerce_custom_bookings_change_price_handler() {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_reporting( E_ALL );
        ini_set( 'display_errors', 1 );
    }
    parse_str($_POST['data'], $data);

    $_product = wc_get_product( $data['product_id'] );
    $new_price = $_product->get_price();

    $booking_type =  get_post_meta($data['product_id'], '_activate_booking', true);
    if ($booking_type == 'yes') {
        $new_price = 0;
        $custom_booking_data['_resident_adults_price'] = get_post_meta($data['product_id'], '_resident_adults_price', true);
        $custom_booking_data['_resident_kids_price'] = get_post_meta($data['product_id'], '_resident_kids_price', true);
        $custom_booking_data['_foreigner_adults_price'] = get_post_meta($data['product_id'], '_foreigner_adults_price', true);
        $custom_booking_data['_foreigner_kids_price'] = get_post_meta($data['product_id'], '_foreigner_kids_price', true);
        $custom_booking_data['_transport_price'] = get_post_meta($data['product_id'], '_transport_price', true);

        if ($data['_resident_adults'] > 0) {
            $new_price = $new_price + ($custom_booking_data['_resident_adults_price'] * $data['_resident_adults']);
        }

        if ($data['_resident_kids'] > 0) {
            $new_price = $new_price + ($custom_booking_data['_resident_kids_price'] * $data['_resident_kids']);
        }

        if ($data['_foreigner_adults'] > 0) {
            $new_price = $new_price + ($custom_booking_data['_foreigner_adults_price'] * $data['_foreigner_adults']);
        }

        if ($data['_foreigner_kids'] > 0) {
            $new_price = $new_price + ($custom_booking_data['_foreigner_kids_price'] * $data['_foreigner_kids']);
        }

        if (isset($data['_transport_checkbox'])) {
            if ($data['_transport_checkbox'] == 'on') {
                $new_price = $new_price + $custom_booking_data['_transport_price'];
            }
        }

        echo 'Subtotal: ' . get_woocommerce_currency_symbol() . $new_price;
    }

    wp_die();
}

add_action('wp_ajax_woocommerce_custom_bookings_change_price', 'woocommerce_custom_bookings_change_price_handler');
add_action('wp_ajax_nopriv_woocommerce_custom_bookings_change_price', 'woocommerce_custom_bookings_change_price_handler');

/* --------------------------------------------------------------
    ADD BODY CLASS ON PRODUCT SPECIAL
-------------------------------------------------------------- */

add_filter( 'body_class', 'woocommerce_custom_bookings_body_classes' );
function woocommerce_custom_bookings_body_classes( $classes ) {
    if(is_product()){
        global $post;
        $booking_type =  get_post_meta($post->ID, '_activate_booking', true);
        if ($booking_type == 'yes') {
            $classes[] = 'product-booking-single';
        }
        return $classes;
    }
}
