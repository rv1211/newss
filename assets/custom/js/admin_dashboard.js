$(function () {

    var start = moment().startOf('month');
    var end = moment().endOf('month');
    var start_all = moment('2021-01-01');
    var end_all = moment();
    var start_dsc = moment().subtract(6, 'days');
    var end_dsc = moment();

    // on click 
    $(document).delegate(".daily_shipment_logistic", "change", function () {
        $("#loader").fadeIn("slow");
        $('#daily_shipment').hide();
        var logistic = $(".daily_shipment_logistic").val();
        var date = $('#daily_shipments_count span').text();

        $.ajax({
            type: 'POST',
            url: hiddenURL + 'Dashboard_new/daily_shipments_count',
            data: { logistic: logistic, from: '1', date: date },
            dataType: 'HTML',
            success: function (response) {
                $("#loader").fadeOut("slow");
                $('#daily_shipment').removeAttr("style");
                $('.daily_shipment_table_data').html(response);
                $(".daily_shipment_logistic").val(logistic);
            }
        });
    });

    $('#ofd_count').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'All': [moment('2021-01-01'), moment()],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, ofd_count);
    // $('#ofd_count span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    ofd_count(start, end);

    function ofd_count(start, end) {
        $("#loader").fadeIn("slow");
        $('#ofd_count span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var startDate = start.format('YYYY-MM-DD');
        var endDate = end.format('YYYY-MM-DD');
        $.ajax({
            type: 'POST',
            url: hiddenURL + 'Dashboard_new/ofd_count',
            data: { start: startDate, end: endDate },
            dataType: 'JSON',
            success: function (response) {
                $("#loader").fadeOut("slow");
                $('#total_ofd').text(response.total_ofd)
                $('#total_delivered').text(response.total_delivered)
                $('#total_rto').text(response.total_rto)
                $('#total_undelivered').text(response.total_undelivered)

            }
        });
    }

    $('#today_orders_count').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'All': [moment('2021-01-01'), moment()],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, today_orders_count);
    // $('#today_orders_count span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    today_orders_count(start, end);

    function today_orders_count(start, end) {
        $("#loader").fadeIn("slow");
        $('#today_orders_count span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var startDate = start.format('YYYY-MM-DD');
        var endDate = end.format('YYYY-MM-DD');
        $.ajax({
            type: 'POST',
            url: hiddenURL + 'Dashboard_new/today_orders_count',
            data: { start: startDate, end: endDate },
            dataType: 'JSON',
            success: function (response) {
                $("#loader").fadeOut("slow");
                $('#all_created_order_count').text(response.all_created_order_count)
                $('#all_order_count_result').text(response.all_order_count_result)
                $('#created_order_count_result').text(response.created_order_count_result)
                $('#intransit_count_result').text(response.intransit_count_result)
                $('#ofd_count_result').text(response.ofd_count_result)
                $('#ndr_count_result').text(response.ndr_count_result)
                $('#delivered_count_result').text(response.delivered_count_result)
                $('#rto_intransit_count_result').text(response.rto_intransit_count_result)
                $('#rto_delivered_count_result').text(response.rto_delivered_count_result)

            }
        });
    }
    $('#preawb_today_orders_count').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'All': [moment('2021-01-01'), moment()],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, preawb_today_orders_count);
    // $('#today_orders_count span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    preawb_today_orders_count(start, end);

    function preawb_today_orders_count(start, end) {
        $("#loader").fadeIn("slow");
        $('#preawb_today_orders_count span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var startDate = start.format('YYYY-MM-DD');
        var endDate = end.format('YYYY-MM-DD');
        $.ajax({
            type: 'POST',
            url: hiddenURL + 'Dashboard_new/preawb_today_orders_count',
            data: { start: startDate, end: endDate },
            dataType: 'JSON',
            success: function (response) {
                $("#loader").fadeOut("slow");
                $('#preawb_all_created_order_count').text(response.all_created_order_count)
                $('#preawb_all_order_count_result').text(response.all_order_count_result)
                $('#preawb_created_order_count_result').text(response.created_order_count_result)
                $('#preawb_intransit_count_result').text(response.intransit_count_result)
                $('#preawb_ofd_count_result').text(response.ofd_count_result)
                $('#preawb_ndr_count_result').text(response.ndr_count_result)
                $('#preawb_delivered_count_result').text(response.delivered_count_result)
                $('#preawb_rto_intransit_count_result').text(response.rto_intransit_count_result)
                $('#preawb_rto_delivered_count_result').text(response.rto_delivered_count_result)

            }
        });
    }


    $('#daily_shipments_count').daterangepicker({
        startDate: start_dsc,
        endDate: end_dsc,
        ranges: {
            'All': [moment('2021-01-01'), moment()],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, daily_shipments_count);

    // $('#daily_shipments_count span').html(start_dsc.format('MMMM D, YYYY') + ' - ' + end_dsc.format('MMMM D, YYYY'));
    daily_shipments_count(start_dsc, end_dsc);

    // function daily_shipments_count(start, end) {
    //     $("#loader").fadeIn("slow");
    //     $('#cod_remittance_count span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    //     var startDate = start.format('YYYY-MM-DD');
    //     var endDate = end.format('YYYY-MM-DD');
    //     $.ajax({
    //         type: 'POST',
    //         url: hiddenURL + 'Dashboard_new/cod_remittance_count',
    //         data: { start: startDate, end: endDate },
    //         dataType: 'JSON',
    //         success: function(response) {
    //             $("#loader").fadeOut("slow");
    //             $('#remitted_amount').text(response.remitted_amount)
    //             $('#unremitted_amount').text(response.unremitted_amount)
    //             $('#avg_shipping_cost').html(Number(response.avg_shipping_amnt).toFixed(2))
    //         }
    //     });
    // }

    function daily_shipments_count(start_dsc, end_dsc) {
        $("#loader").fadeIn("slow");
        $('#daily_shipments_count span').html(start_dsc.format('MMMM D, YYYY') + ' - ' + end_dsc.format('MMMM D, YYYY'));
        var startDate = start_dsc.format('YYYY-MM-DD');
        var endDate = end_dsc.format('YYYY-MM-DD');
        var logistic = $(".daily_shipment_logistic").val();

        $('#daily_shipment').hide();
        $.ajax({
            type: 'POST',
            url: hiddenURL + 'Dashboard_new/daily_shipments_count',
            data: { start: startDate, end: endDate, logistic: logistic, from: '0' },
            dataType: 'HTML',
            success: function (response) {

                $("#loader").fadeOut("slow");
                // $('#daily_shipment').removeAttr("style");
                $('.daily_shipment_table_data').html(response);
            }
        });
    }

    $('#carrier_performance_count').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'All': [moment('2021-01-01'), moment()],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, carrier_performance_count);
    // $('#carrier_performance_count span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    carrier_performance_count(start, end);

    function carrier_performance_count(start, end) {
        $("#loader").fadeIn("slow");
        $('#carrier_performance_count span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var startDate = start.format('YYYY-MM-DD');
        var endDate = end.format('YYYY-MM-DD');
        $('#carrier_perofrmance').hide();
        $.ajax({
            type: 'POST',
            url: hiddenURL + 'Dashboard_new/carrier_performance_count',
            data: { start: startDate, end: endDate },
            dataType: 'HTML',
            success: function (response) {

                $("#loader").fadeOut("slow");
                // $('#carrier_perofrmance').removeAttr("style");
                //$('.carrier_perofrmance_table_data').html(response);
                $('.carrier_performance_count_div').html(response);

            }
        });
    }


    $('#cod_remittance_count').daterangepicker({
        startDate: start_all,
        endDate: end_all,
        ranges: {
            'All': [moment('2021-01-01'), moment()],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cod_remittance_count);
    // $('#cod_remittance_count span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    cod_remittance_count(start_all, end_all);

    function cod_remittance_count(start_all, end_all) {
        $("#loader").fadeIn("slow");
        $('#cod_remittance_count span').html(start_all.format('MMMM D, YYYY') + ' - ' + end_all.format('MMMM D, YYYY'));
        var startDate = start_all.format('YYYY-MM-DD');
        var endDate = end_all.format('YYYY-MM-DD');
        $.ajax({
            type: 'POST',
            url: hiddenURL + 'Dashboard_new/cod_remittance_count',
            data: { start: startDate, end: endDate },
            dataType: 'JSON',
            success: function (response) {
                $("#loader").fadeOut("slow");
                $('#remitted_amount').text(response.remitted_amount)
                $('#unremitted_amount').text(response.unremitted_amount)
                $('#avg_shipping_cost').html(Number(response.avg_shipping_amnt).toFixed(2))
            }
        });
    }
});