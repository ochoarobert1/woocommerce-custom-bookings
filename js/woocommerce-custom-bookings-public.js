jQuery(document).on('ready', function (e) {

    jQuery('.datepicker-special').datepicker({
        onSelect(formattedDate, date, inst) {
            var date_array = formattedDate;
            if (date_array.indexOf('-') > -1) {
                var res = formattedDate.split(" - ");
                var fecha1 = res[0].split('/');
                var fecha2 = res[1].split('/');
                console.log(fecha1[0]);
                console.log(fecha2[0]);
                var date_text = ((fecha2[0] - fecha1[0]) + 1);
                jQuery('.datepicker-quantity').html('Ha seleccionado ' + date_text + ' días');
            }
        }
    });
});
