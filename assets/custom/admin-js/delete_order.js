$(function () {
    var hiddenurl = $('#hiddenURL').val();
    /**
     * Simple Datatable
     */
    $('#delete_order_table').DataTable({
        "columnDefs": [
            { orderable: false, targets: 0 }
        ],
        "lengthMenu": [
            [10, 50, 75, 100, -1],
            [10, 50, 75, 100, "All"]
        ],
        "paging": true,
        "order": [
            [1, "asc"]
        ],
    });
    $(document).delegate('.select-all-delete-order', 'click', function () {
        if ($(this).prop("checked") == true) {
            $('.select-single-delete-order').prop('checked', true);
            $("#export_delete_orders").removeAttr("disabled");
            $("#delete_orders").removeAttr("disabled");
        } else {
            $('.select-single-delete-order').prop('checked', false);
            $("#export_delete_orders").attr("disabled", true);
            $("#delete_orders").attr("disabled", true);
        }
    });

    $(document).delegate(".select-single-delete-order", "change", function (e) {

        e.stopImmediatePropagation();
        e.preventDefault();
        var all_pro = $(".select-all-delete-order").prop('checked');
        if (all_pro == true) {
            $(".select-all-delete-order").prop('checked', false);
        }
        var check_array = [];
        if ($('#delete_order_table').length > 0) {
            $.each($("input[name='checkbox_delete_order']:checked"), function () {
                check_array.push($(this).data('id'));
            });
        }
        if (check_array.length > 0) {
            $("#export_delete_orders").removeAttr("disabled");
            $("#delete_orders").removeAttr("disabled");
        } else {
            $("#export_delete_orders").attr("disabled", true);
            $("#delete_orders").attr("disabled", true);
        }
    });

    $(document).delegate('#delete_orders', 'click', function () {

        var forward_array = [];
        var error_array = [];
        if ($('#delete_order_table').length > 0) {
            $.each($("input[name='checkbox_delete_order']:checked"), function () {
                var type = ($(this).data('type'));
                if (type == "0") {
                    forward_array.push($(this).data('id'));
                }
                if (type == "1") {
                    error_array.push($(this).data('id'));
                }
            });
        }
        if (confirm('Are you sure you want to delete record')) {
            if ((forward_array.length > 0) || (error_array.length > 0)) {
                $.ajax({
                    type: 'POST',
                    url: hiddenurl + "Delete_order/delete_check_order",
                    data: {
                        forward_array: forward_array,
                        error_array: error_array
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response == "success") {
                            $("#result_message").fadeIn("slow").html("Delete Order Successfully");
                            setTimeout(function () {
                                $("#result_message").fadeOut("slow");
                            }, 2000);
                            location.reload();
                        } else {
                            $("#result_error_message").fadeIn("slow").html('Somthing Went to Wrong');
                            setTimeout(function () {
                                $("#result_error_message").fadeOut("slow");
                            }, 2000);
                            location.reload();
                        }
                    }
                });
            } else {
                return confirm('Please select Record');
            }
        }
    });


    $(document).delegate('#refund_all_orders', 'click', function () {
        $.ajax({
            type: "post",
            url: hiddenurl + "/refund_all_orders",
            dataType: "JSON",
            success: function (response) {
                alert("sdf");
                $("#result_message").fadeIn("slow").html("Refund Generated Successfully");
                setTimeout(function () {
                    $("#result_message").fadeOut("slow");
                }, 2000);
            }
        });
    });






    $(document).delegate('#export_delete_orders', 'click', function () {
        var check_array = [];
        if ($('#delete_order_table').length > 0) {
            $.each($("input[name='checkbox_delete_order']:checked"), function () {
                check_array.push($(this).data('id'));
            });
        }

        if (check_array.length > 0) {
            $.ajax({
                type: 'POST',
                url: hiddenurl + "Delete_order/export_data",
                data: { check_array: check_array },
                success: function (response) {
                    var decoded_string = atob(response);
                    window.location = decoded_string;
                    if (decoded_string) {
                        $("#result_message").fadeIn("slow").html(".xls File Generated Successfully");
                        setTimeout(function () {
                            $("#result_message").fadeOut("slow");
                        }, 2000);
                        $('.getChecked').prop('checked', false);
                        $('#checked_item').prop('checked', false);
                    } else {
                        $("#result_error_message").fadeIn("slow").html('Somthing Went to Wrong');
                        setTimeout(function () {
                            $("#result_error_message").fadeOut("slow");
                        }, 2000);
                    }
                }
            });
        } else {
            return confirm('Please select Record');
        }
    });
});