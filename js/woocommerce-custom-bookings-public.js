jQuery(document).on('ready', function (e) {
    jQuery('.datepicker-special').datepicker({
        multipleDates: 3,
        multipleDatesSeparator: ', ',
        position: 'top left'
    });

    jQuery('#bookingAccordion input').on('change', function () {
        jQuery.ajax({
            type: 'POST',
            url: admin_url.ajax_url,
            data: {
                action: 'woocommerce_custom_bookings_change_price',
                data: jQuery('.cart').serialize()
            },
            beforeSend: function () {
                //                jQuery('.custom-contact-form-item-wrapper').html('<div class="loader col-12"><div class="lds-dual-ring"><div></div><div></div><div></div><div></div></div></div>');
            },
            success: function (response) {
                jQuery('.price-additional').html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });


});
