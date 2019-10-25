jQuery(document).on('ready', function (e) {
    'use strict';
    var prevText = '';
    jQuery('#datepicker_id').datepicker({
        showOn: "button",
        dateFormat: 'dd/mm/yy',
        onSelect: function (dateText) {
            if (jQuery('#_date_selector').val() == '') {
                jQuery('#_date_selector').val(dateText)
            } else {
                prevText = jQuery('#_date_selector').val();
                jQuery('#_date_selector').val(prevText + ', ' + dateText);
            }
        }
    });
});
