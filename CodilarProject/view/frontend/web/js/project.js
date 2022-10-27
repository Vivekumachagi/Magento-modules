require([
    'jquery',
    'mage/calendar'
], function($){
    $('#datetimepicker').datetimepicker({
        dateFormat: 'mm/dd/yy',
        timeFormat: 'HH:mm:ss',
        changeMonth: true,
        changeYear: true,
        showsTime: true
    });
});




