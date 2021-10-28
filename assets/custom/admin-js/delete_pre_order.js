$(function() {
    var hiddenurl = $('#hiddenURL').val();
    /**
     * Simple Datatable
     */
    $('#delete_pre_order_table').DataTable({
        "lengthMenu": [
            [10, 50, 75, 100, 150],
            [10, 50, 75, 100, 150]
        ],
        "paging": true,
        "order": [
            [1, "asc"]
        ],
    });
    $(document).delegate('.select-all-delete-pre-order', 'click', function() {
        if ($(this).prop("checked") == true) {
            $('.select-single-delete-pre-order').prop('checked', true);
            $("#export_delete_pre_orders").removeAttr("disabled");
            $("#delete_pre_orders").removeAttr("disabled");
        } else {
            $('.select-single-delete-pre-order').prop('checked', false);
            $("#export_delete_pre_orders").attr("disabled", true);
            $("#delete_pre_orders").attr("disabled", true);
        }
    });

    $(document).delegate(".select-single-delete-pre-order", "change", function(e) {

        e.stopImmediatePropagation();
        e.preventDefault();
        var all_pro = $(".select-all-delete-pre-order").prop('checked');
        if (all_pro == true) {  
            $(".select-all-delete-pre-order").prop('checked', false);  
        }
        var check_array = [];
        if ($('#delete_pre_order_table').length > 0) {
            $.each($("input[name='checkbox_delete_pre_order']:checked"), function() {
                check_array.push($(this).data('id'));
            });
        }
        if (check_array.length > 0) {
            $("#export_delete_pre_orders").removeAttr("disabled");
            $("#delete_pre_orders").removeAttr("disabled");
        } else {
            $("#export_delete_pre_orders").attr("disabled", true);
            $("#delete_pre_orders").attr("disabled", true);
        }
    });

    $(document).delegate('#delete_pre_orders', 'click', function() {

        var forward_array = [];
        var error_array = [];
        if ($('#delete_pre_order_table').length > 0) {
            $.each($("input[name='checkbox_delete_pre_order']:checked"), function() {
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
                    url: hiddenurl + "Delete_pre_order/delete_check_order",
                    data: {
                        forward_array: forward_array,
                        error_array: error_array
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response == "success") {
                            $("#result_message").fadeIn("slow").html("Delete Order Successfully");
                            setTimeout(function() {
                                $("#result_message").fadeOut("slow");
                            }, 2000);
                            location.reload();
                        } else {
                            $("#result_error_message").fadeIn("slow").html('Somthing Went to Wrong');
                            setTimeout(function() {
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

    $(document).delegate('#export_delete_pre_orders', 'click', function() {
        var check_array = [];
        if ($('#delete_pre_order_table').length > 0) {
            $.each($("input[name='checkbox_delete_pre_order']:checked"), function() {
                check_array.push($(this).data('id'));
            });
        }

        if (check_array.length > 0) {
            $.ajax({
                type: 'POST',
                url: hiddenurl + "Delete_pre_order/export_data",
                data: { check_array: check_array },
                success: function(response) {
                    var decoded_string = atob(response);
                    window.location = decoded_string;
                    if (decoded_string) {
                        $("#result_message").fadeIn("slow").html(".xls File Generated Successfully");
                        setTimeout(function() {
                            $("#result_message").fadeOut("slow");
                        }, 2000);
                        $('.getChecked').prop('checked', false);
                        $('#checked_item').prop('checked', false);
                    } else {
                        $("#result_error_message").fadeIn("slow").html('Somthing Went to Wrong');
                        setTimeout(function() {
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