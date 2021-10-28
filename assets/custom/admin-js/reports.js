$(document).ready(function() {
    var hiddenURL = $('#hiddenURL').val();

    // $(document).delegate('#booking_report', 'click', function() {

    //     var fromdate = $('#from_date').val();
    //     var todate = $('#to_date').val();
    //     if (fromdate != "" && todate != "") {
    //         $.ajax({
    //             type: "POST",
    //             url: hiddenURL + "daily-booking-report",
    //             data: { fromdate: fromdate, todate: todate },
    //             success: function(response) {

    //             }
    //         });
    //     }
    // });


    $(document).ready(function() {
        $('.booking_table').DataTable({
            "lengthMenu": [
                [10, 50, 75, 100, 150],
                [10, 50, 75, 100, 150]
            ],
            "paging": true
        });

    });

});