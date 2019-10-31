<?php
/* --------------------------------------------------------------
    ADMIN CUSTOM SCRIPTS
-------------------------------------------------------------- */

function woocommerce_custom_bookings_cart_item_quantity( $product_quantity, $cart_item_key, $cart_item ){
    if( is_cart() ){
        $booking_type =  get_post_meta($cart_item['product_id'], '_activate_booking', true);
        if ($booking_type == 'yes') {
            $product_quantity = sprintf( '%2$s <input type="hidden" name="cart[%1$s][qty]" value="%2$s" />', $cart_item_key, $cart_item['quantity'] );
        }
    }
    return $product_quantity;
}

add_filter( 'woocommerce_cart_item_quantity', 'woocommerce_custom_bookings_cart_item_quantity',10,  3 );

/* --------------------------------------------------------------
ADD CUSTOM DATA TO ITEM CART
-------------------------------------------------------------- */

function woocommerce_custom_bookings_add_cart_item( $cart_item_meta, $product_id ) {
    global $woocommerce;

    if (isset($_POST['_resident_adults'])) {
        if ($_POST['_resident_adults'] > 0) {
            $cart_item_meta['_resident_adults'] = $_POST['_resident_adults'];
        }
    }
    if (isset($_POST['_resident_kids'])) {
        if ($_POST['_resident_kids'] > 0) {
            $cart_item_meta['_resident_kids'] = $_POST['_resident_kids'];
        }
    }
    if (isset($_POST['_foreigner_adults'])) {
        if ($_POST['_foreigner_adults'] > 0) {
            $cart_item_meta['_foreigner_adults'] = $_POST['_foreigner_adults'];
        }
    }
    if (isset($_POST['_foreigner_kids'])) {
        if ($_POST['_foreigner_kids'] > 0) {
            $cart_item_meta['_foreigner_kids'] = $_POST['_foreigner_kids'];
        }
    }
    if (isset($_POST['_transport_checkbox'])) {
        $cart_item_meta['_transport_checkbox'] = $_POST['_transport_checkbox'];
    }
    if (isset($_POST['_date_selection'])) {
        $cart_item_meta['_date_selection'] = $_POST['_date_selection'];
    }
    return $cart_item_meta;
}

add_filter( 'woocommerce_add_cart_item_data', 'woocommerce_custom_bookings_add_cart_item',10,  2 );

/* --------------------------------------------------------------
ADD CUSTOM DATA TO ITEM CART
-------------------------------------------------------------- */

function woocommerce_custom_bookings_add_info_to_cart( $cart_data, $cart_item )
{
    $custom_items = array();

    if( !empty( $cart_data ) )
        $custom_items = $cart_data;

    if( isset( $cart_item["_resident_adults"] ) ) {
        $custom_items[] = array(
            'name' => __( 'Adultos Residentes', 'woocommerce-custom-booking' ),
            'value' => $cart_item["_resident_adults"],
            'display' => $cart_item["_resident_adults"]
        );
    }

    if( isset( $cart_item["_resident_kids"] ) ) {
        $custom_items[] = array(
            'name' => __( 'Niños Residentes', 'woocommerce-custom-booking' ),
            'value' => $cart_item["_resident_kids"],
            'display' => $cart_item["_resident_kids"]
        );
    }

    if( isset( $cart_item["_foreigner_adults"] ) ) {
        $custom_items[] = array(
            'name' => __( 'Adultos Extranjeros', 'woocommerce-custom-booking' ),
            'value' => $cart_item["_foreigner_adults"],
            'display' => $cart_item["_foreigner_adults"]
        );
    }

    if( isset( $cart_item["_foreigner_kids"] ) ) {
        $custom_items[] = array(
            'name' => __( 'Niños Extranjeros', 'woocommerce-custom-booking' ),
            'value' => $cart_item["_foreigner_kids"],
            'display' => $cart_item["_foreigner_kids"]
        );
    }

    if( isset( $cart_item["_date_selection"] ) ) {
        $custom_items[] = array(
            'name' => __( 'Selección de Días', 'woocommerce-custom-booking' ),
            'value' => $cart_item["_date_selection"],
            'display' => $cart_item["_date_selection"]
        );
    }

    if( isset( $cart_item["_transport_checkbox"] ) ) {
        $custom_items[] = array(
            'name' => __( 'Servicio de Transporte', 'woocommerce-custom-booking' ),
            'value' => $cart_item["_transport_checkbox"],
            'display' => __( 'Incluido', 'woocommerce-custom-booking' )
        );
    }
    return $custom_items;
}

add_filter( 'woocommerce_get_item_data', 'woocommerce_custom_bookings_add_info_to_cart',10,  2 );

/* --------------------------------------------------------------
CALCULATE PRICE BY CART ITEM
-------------------------------------------------------------- */

function woocommerce_custom_bookings_cart_items_prices( $cart ) {

    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

    // Loop Through cart items

    foreach ( $cart->get_cart() as $cart_item ) {
        $product_id = $cart_item['product_id'];
        $price = $cart_item['data']->get_price();
        $booking_type =  get_post_meta($product_id, '_activate_booking', true);

        if ($booking_type == 'yes') {
            $acc_fees = 0;
            $price = 0;
            $custom_booking_data['_resident_adults_price'] = get_post_meta($product_id, '_resident_adults_price', true);
            $custom_booking_data['_resident_kids_price'] = get_post_meta($product_id, '_resident_kids_price', true);
            $custom_booking_data['_foreigner_adults_price'] = get_post_meta($product_id, '_foreigner_adults_price', true);
            $custom_booking_data['_foreigner_kids_price'] = get_post_meta($product_id, '_foreigner_kids_price', true);
            $custom_booking_data['_transport_price'] = get_post_meta($product_id, '_transport_price', true);

            if (isset($cart_item['_resident_adults'])) {
                $acc_fees = ($custom_booking_data['_resident_adults_price'] * $cart_item['_resident_adults']) + $acc_fees;
            }

            if (isset($cart_item['_resident_kids'])) {
                $acc_fees = ($custom_booking_data['_resident_kids_price'] * $cart_item['_resident_kids']) + $acc_fees;
            }


            if (isset($cart_item['_foreigner_adults'])) {
                $acc_fees = ($custom_booking_data['_foreigner_adults_price'] * $cart_item['_foreigner_adults']) + $acc_fees;
            }

            if (isset($cart_item['_foreigner_kids'])) {
                $acc_fees = ($custom_booking_data['_foreigner_kids_price'] * $cart_item['_foreigner_kids']) + $acc_fees;
            }

            if (isset($cart_item['_transport_checkbox'])) {
                $acc_fees = $custom_booking_data['_transport_price'] + $acc_fees;
            }

            // GET THE NEW PRICE (code to be replace by yours)
            $new_price = $price + $acc_fees;


            // Updated cart item price
            $cart_item['data']->set_price( $new_price );
        }
    }
}

add_filter( 'woocommerce_before_calculate_totals', 'woocommerce_custom_bookings_cart_items_prices',10,  1 );

/* --------------------------------------------------------------
    ADD CUSTOM LINES IN CART ADMIN
-------------------------------------------------------------- */

function woocommerce_custom_booking_checkout_create_order_line_item( $item, $cart_item_key, $values, $order ) {
    if( isset( $values['_resident_adults'] ) ) {
        $item->add_meta_data(
            __( 'Residentes Adultos', 'woocommerce-custom-booking' ),
            $values['_resident_adults'],
            true
        );
    }
    if( isset( $values['_resident_kids'] ) ) {
        $item->add_meta_data(
            __( 'Residentes Niños', 'woocommerce-custom-booking' ),
            $values['_resident_kids'],
            true
        );
    }
    if( isset( $values['_foreigner_adults'] ) ) {
        $item->add_meta_data(
            __( 'Extranjeros Adultos', 'woocommerce-custom-booking' ),
            $values['_foreigner_adults'],
            true
        );
    }
    if( isset( $values['_foreigner_kids'] ) ) {
        $item->add_meta_data(
            __( 'Extranjeros Niños', 'woocommerce-custom-booking' ),
            $values['_foreigner_kids'],
            true
        );
    }
    if( isset( $values['_transport_checkbox'] ) ) {
        $item->add_meta_data(
            __( 'Servicio de Transporte', 'woocommerce-custom-booking' ),
            __('Incluido', 'woocommerce-custom-bookings'),
            true
        );
    }
    if( isset( $values['_date_selection'] ) ) {
        $item->add_meta_data(
            __( 'Seleccion de Fecha', 'woocommerce-custom-booking' ),
            $values['_date_selection'],
            true
        );
    }
}

add_action( 'woocommerce_checkout_create_order_line_item', 'woocommerce_custom_booking_checkout_create_order_line_item',10,  4 );

/* --------------------------------------------------------------
    ADD CUSTOM LINES IN CART
-------------------------------------------------------------- */

function woocommerce_custom_booking_order_item_name( $product_name, $item ) {
    if( isset( $item['_resident_adults'] ) ) {
        $product_name .= sprintf(
            '<ul><li>%s: %s</li></ul>',
            __( 'Residentes Adultos', 'woocommerce-custom-booking' ),
            esc_html( $item['_resident_adults'] )
        );
    }
    if( isset( $item['_resident_kids'] ) ) {
        $product_name .= sprintf(
            '<ul><li>%s: %s</li></ul>',
            __( 'Residentes Niños', 'woocommerce-custom-booking' ),
            esc_html( $item['_resident_kids'] )
        );
    }
    if( isset( $item['_foreigner_adults'] ) ) {
        $product_name .= sprintf(
            '<ul><li>%s: %s</li></ul>',
            __( 'Extranjeros Adultos', 'woocommerce-custom-booking' ),
            esc_html( $item['_foreigner_adults'] )
        );
    }
    if( isset( $item['_foreigner_kids'] ) ) {
        $product_name .= sprintf(
            '<ul><li>%s: %s</li></ul>',
            __( 'Extranjeros Niños', 'woocommerce-custom-booking' ),
            esc_html( $item['_foreigner_kids'] )
        );
    }
    if( isset( $item['_date_selection'] ) ) {
        $product_name .= sprintf(
            '<ul><li>%s: %s</li></ul>',
            __( 'Seleccion de Fecha', 'woocommerce-custom-booking' ),
            esc_html( $item['_date_selection'] )
        );
    }
    return $product_name;
}

add_filter( 'woocommerce_order_item_name', 'woocommerce_custom_booking_order_item_name',10,  2 );
