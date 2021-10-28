$(document).ready(function() {
    var hiddenURL = $('#hiddenURL').val();

    $('#from_date,#to_date').on(change, function() {
        console.log($('#from_date').val());
        console.log($('#to_date').val());
    });

});