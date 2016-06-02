

jQuery(function() {
    if(typeof(DATE_INPUT) !== 'undefined'){
        jQuery( DATE_INPUT ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    }
});

