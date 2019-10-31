<?php
/* --------------------------------------------------------------
    CUSTOM TAB OPTIONS
-------------------------------------------------------------- */

function woocommerce_custom_bookings_bookings_tab( $default_tabs ) {
    $default_tabs['bookings_tab'] = array(
        'label'   =>  __( 'Bookings', 'woocommerce-custom-bookings' ),
        'target'  =>  'bookings_tab_data',
        'priority' => 100,
        'class'		=> array( 'show_if_simple', 'show_if_variable'  ),
    );
    return $default_tabs;
}

add_filter( 'woocommerce_product_data_tabs', 'woocommerce_custom_bookings_bookings_tab', 10, 1 );

/* --------------------------------------------------------------
    CUSTOM TAB DATA
-------------------------------------------------------------- */

function woocommerce_custom_bookings_tab_data() {
    global $woocommerce, $post;

    echo '<div id="bookings_tab_data" class="panel woocommerce_options_panel hidden">';
    echo '<div class="options_group">';
?>
<h2><?php _e( 'Activar Producto', 'woocommerce-custom-bookings' ); ?></h2>
<?php
    // Checkbox
    woocommerce_wp_checkbox(
        array(
            'id'            => '_activate_booking',
            'wrapper_class' => 'show_activate_booking',
            'label'         => __('Producto Booking', 'woocommerce' ),
            'description'   => __( 'Activar si este producto es tipo tour', 'woocommerce' )
        )
    );
?>
<hr>
<h2><?php _e( 'Residente', 'woocommerce-custom-bookings' ); ?></h2>
<?php
    // _resident_adults_price
    woocommerce_wp_text_input(
        array(
            'id'          => '_resident_adults_price',
            'label'     => __( 'Precio por Adulto', 'woocommerce-custom-bookings' ) . ' (' . get_woocommerce_currency_symbol() . ')',
            'placeholder' => '0',
            'desc_tip'    => true,
            'description' => __( 'Agregue aquí el precio por adulto residente.', 'woocommerce-custom-bookings' )
        )
    );

    // _resident_kids_price
    woocommerce_wp_text_input(
        array(
            'id'          => '_resident_kids_price',
            'label'     => __( 'Precio por Niño', 'woocommerce-custom-bookings' ) . ' (' . get_woocommerce_currency_symbol() . ')',
            'placeholder' => '0',
            'desc_tip'    => true,
            'description' => __( 'Agregue aquí el precio por niño residente.', 'woocommerce-custom-bookings' )
        )
    );
?>
<hr>
<h2><?php _e( 'Extranjero', 'woocommerce-custom-bookings' ); ?></h2>
<?php
    // _foreigner_adults_price
    woocommerce_wp_text_input(
        array(
            'id'          => '_foreigner_adults_price',
            'label'     => __( 'Precio por Adulto', 'woocommerce-custom-bookings' ) . ' (' . get_woocommerce_currency_symbol() . ')',
            'placeholder' => '0',
            'desc_tip'    => true,
            'description' => __( 'Agregue aquí el precio por adulto extranjero.', 'woocommerce-custom-bookings' )
        )
    );

    // _foreigner_kids_price
    woocommerce_wp_text_input(
        array(
            'id'          => '_foreigner_kids_price',
            'label'     => __( 'Precio por Niño', 'woocommerce-custom-bookings' ) . ' (' . get_woocommerce_currency_symbol() . ')',
            'placeholder' => '0',
            'desc_tip'    => true,
            'description' => __( 'Agregue aquí el precio por niño extranjero.', 'woocommerce-custom-bookings' )
        )
    );
?>
<hr>
<h2><?php _e( 'Transporte', 'woocommerce-custom-bookings' ); ?></h2>
<?php
    // Checkbox
    woocommerce_wp_checkbox(
        array(
            'id'            => '_checkbox',
            'wrapper_class' => 'show_if_transport',
            'label'         => __('Activar Transporte', 'woocommerce' ),
            'description'   => __( 'Activar si este producto tendra servicio de transporte', 'woocommerce' )
        )
    );
    // _foreigner_kids_price
    woocommerce_wp_text_input(
        array(
            'id'          => '_transport_price',
            'label'     => __( 'Precio de transporte', 'woocommerce-custom-bookings' ) . ' (' . get_woocommerce_currency_symbol() . ')',
            'placeholder' => '0',
            'desc_tip'    => true,
            'description' => __( 'Agregue aquí el precio del transporte.', 'woocommerce-custom-bookings' )
        )
    );
?>
<hr>
<h2><?php _e( 'Fechas del Tour', 'woocommerce-custom-bookings' ); ?></h2>
<p class="form-field custom_field_type">
    <label for="custom_field_type"><?php _e('Selección de Fechas'); ?></label>
    <span class="wrap">
        <?php $custom_field_type = get_post_meta( $post->ID, '_date_selector', true ); ?>
        <input type="text" class="short" name="_date_selector" id="_date_selector" value="<?php echo $custom_field_type; ?>"/>
    </span>
    <span class="description"><input id="datepicker_id" class="short no-body" type="text" /></span>
</p>

<?php
    echo '</div>';
    echo '</div>';
}

add_action( 'woocommerce_product_data_panels', 'woocommerce_custom_bookings_tab_data' );

/* --------------------------------------------------------------
    CUSTOM FIELDS SAVE
-------------------------------------------------------------- */

function woocommerce_custom_bookings_fields_save( $post_id ){
    // Checkbox
    $woocommerce_checkbox = isset( $_POST['_activate_booking'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_activate_booking', $woocommerce_checkbox );
    // Text Field
    $resident_adults_price = $_POST['_resident_adults_price'];
    update_post_meta( $post_id, '_resident_adults_price', esc_attr( $resident_adults_price ) );
    // Number Field
    $resident_kids_price = $_POST['_resident_kids_price'];
    update_post_meta( $post_id, '_resident_kids_price', esc_attr( $resident_kids_price ) );
    // Textarea
    $foreigner_adults_price = $_POST['_foreigner_adults_price'];
    update_post_meta( $post_id, '_foreigner_adults_price', esc_attr( $foreigner_adults_price ) );;
    // Textarea
    $foreigner_kids_price = $_POST['_foreigner_kids_price'];
    update_post_meta( $post_id, '_foreigner_kids_price', esc_attr( $foreigner_kids_price ) );
    // Checkbox
    $woocommerce_checkbox = isset( $_POST['_checkbox'] ) ? 'yes' : 'no';
    update_post_meta( $post_id, '_checkbox', $woocommerce_checkbox );
    // Hidden Field
    $transport_price = $_POST['_transport_price'];
    update_post_meta( $post_id, '_transport_price', esc_attr( $transport_price ) );
    // Hidden Field
    $date_selector = $_POST['_date_selector'];
    update_post_meta( $post_id, '_date_selector', esc_attr( $date_selector ) );
}

add_action( 'woocommerce_process_product_meta', 'woocommerce_custom_bookings_fields_save' );
