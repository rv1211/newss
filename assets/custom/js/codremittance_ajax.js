var hiddenURL = $("#hiddenURL").val();
$(function () {

    if ($('#cod_remittance_customer_id').val() != "" && $('#cod_remittance_from_date').val() != "" && $('#cod_remittance_to_date').val() != "") {
        $('#cod_remittance_list_table').DataTable({
            "language": {
                "infoFiltered": ""
            },
            "lengthMenu": [
                [10, 25, 50, 75, 100, 150, -1],
                [10, 25, 50, 75, 100, 150, 'All']
            ],
            "iDisplayLength": 50,
            "order": [
                [1, "desc"]
            ],
            "serverSide": true,
            "ajax": {
                "url": hiddenURL + 'cod-remittance-ajax-get-list',
                'type': 'POST',
                'data': { "customer_id": $('#cod_remittance_customer_id').val(), "from_date": $('#cod_remittance_from_date').val(), "to_date": $('#cod_remittance_to_date').val() },
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }],
        });
    }

    $(document).delegate('#check_all_cod_remittance_order', 'click', function () {
        var a = $(".check_single_cod_remittance_order").prop('checked', $(this).prop('checked'));
        var all_odr = $("#check_all_cod_remittance_order").prop('checked');
        if (all_odr == true) {
            $("input.check_single_cod_remittance_order:checked").addClass("checked");
        }
        if (all_odr == false) {
            $("input.check_single_cod_remittance_order").removeClass("checked");
        }
        var countALL = $("input.check_single_cod_remittance_order:checked").length;
        gettotalcodremittanceamount();
    });
    $(document).delegate('.check_single_cod_remittance_order', 'change', function (e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        var all_odr = $("#check_all_cod_remittance_order").prop('checked');
        if (all_odr == true) {
            $("#check_all_cod_remittance_order").prop('checked', false);
            $("#check_all_cod_remittance_order").removeClass("checked");
        }
        gettotalcodremittanceamount();
    });


    function gettotalcodremittanceamount() {
        var Total = parseFloat(0.0);
        $('.check_single_cod_remittance_order').each(function () {
            if ($(this).is(':checked')) {
                var itemToalsum = parseFloat($(this).data("codamount"));
                Total += itemToalsum;
            }
        });
        $('#cod_remittance_total_amount').html((Total).toFixed(2));
    }
    $(document).delegate('#cod_remittance_save_button', 'click', function () {
        $("#loader").fadeIn("slow");
        var order_id_array = [];
        var rowcollection = $(".check_single_cod_remittance_order:checked");
        rowcollection.each(function (index, elem) {
            order_id_array.push($(elem).val());
        });
        var order_id = order_id_array.join(',');
        if (order_id.length > 0) {

            $.ajax({
                type: 'POST',
                url: hiddenURL + 'add-cod-remittance',
                data: { order_id: order_id, "customer_id": $("#cod_remittance_customer_id").val(), "from_date": $("#cod_remittance_from_date").val(), "to_date": $("#cod_remittance_to_date").val(), "cod_remittance_note": $("input[name=cod_remittance_note]").val(), "cod_remittance_amount": $("#cod_remittance_total_amount").text() },
                dataType: "json",
                success: function (response) {
                    if (response.msg == "success") {
                        $("#cod_remittance_detail_id").val(response.cod_remittance_detail_id);
                        $("input[name=export]").show();

                        $("#result_message").fadeIn("slow").html("COD Remittance save successfully.");
                        location.reload();

                        setTimeout(function () {
                            $("#result_message").fadeOut("slow");
                            //window.location.href(hiddenURL + "cod-remittance-list");
                        }, 7000);

                    } else {

                        $("#result_error_message").fadeIn("slow").html("Something wents to wrong.");
                        location.reload();
                        setTimeout(function () {
                            $("#result_error_message").fadeOut("slow");
                            //window.location.href(hiddenURL + "cod-remittance-list");
                        }, 7000);

                    }
                }
            });
        } else {
            $("#loader").fadeOut("slow");
            alert("Please Select Order..");
        }
        $("#loader").fadeOut("slow");
    });


    $("#all_cod_remittance_list_table").DataTable({
        "language": {
            "infoFiltered": "",
        },
        "lengthMenu": [
            [10, 25, 50, 75, 100, 150, -1],
            [10, 25, 50, 75, 100, 150, 'All']
        ],
        "iDisplayLength": 50,
        "scrollX": 200,
        "order": [
            [0, "desc"]
        ],
        "serverSide": true,
        "ajax": {
            "url": hiddenURL + 'all-cod-remittance-ajax-get-list',
        },
        "columnDefs": [{
            "targets": [3],
            "orderable": false,
        }],

    });

    $(document).delegate('.cod_remittance_order_detail_info_button', 'click', function () {
        $.ajax({
            url: hiddenURL + 'cod-remittance-order-detail-info',
            type: 'POST',
            data: { 'cod_remittance_detail_id': $(this).val() },
            success: function (response) {
                $("#myModal").modal('show');
                $(".cod-modal-body").html(response);
            }
        });
    });

    $(document).delegate('#remitance_export_btn', 'click', function () {
        $("#loader").show();
        var check_array = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: hiddenURL + "Codremittance_new/export_data",
            data: { check_array: check_array },
            success: function (response) {
                var decoded_string = atob(response);
                window.location = decoded_string;
                if (decoded_string) {
                    $("#loader").hide();
                    $("#result_message").fadeIn("slow").html(".xls File Generated Successfully");
                    setTimeout(function () {
                        $("#result_message").fadeOut("slow");
                    }, 2000);
                    $('.getChecked').prop('checked', false);
                    $('#checked_item').prop('checked', false);
                } else {
                    $("#loader").hide();
                    $("#result_error_message").fadeIn("slow").html('Somthing Went to Wrong');
                    setTimeout(function () {
                        $("#result_error_message").fadeOut("slow");
                    }, 2000);
                }
            }
        });
    });

});