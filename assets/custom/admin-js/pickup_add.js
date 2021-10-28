$(function() {
    var hiddenurl = $('#hiddenURL').val();

    $(document).delegate('.selectable-all-pickup', 'click', function() {
        if ($(this).prop("checked") == true) {
            $('.selectable-item-pickup').prop('checked', true);
        } else {
            $('.selectable-item-pickup').prop('checked', false);
        }
    });
    $(document).delegate('#export_pickup', 'click', function() {
        $("#loader").show();
        var check_array = [];
        if ($('.table-pickup').length > 0) {
            $.each($("input[name='checkbox_item_pickup']:checked"), function() {
                check_array.push($(this).data('id'));
            });
        }

        if (check_array.length > 0) {
            $.ajax({
                type: 'POST',
                url: hiddenurl + "Pickup_address/export_data",
                data: { check_array: check_array },
                success: function(response) {
                    var decoded_string = atob(response);
                    window.location = decoded_string;
                    if (decoded_string) {
                        $("#loader").hide();
                        $("#result_message").fadeIn("slow").html(".xls File Generated Successfully");
                        setTimeout(function() {
                            $("#result_message").fadeOut("slow");
                        }, 2000);
                        $('.getChecked').prop('checked', false);
                        $('#checked_item').prop('checked', false);
                    } else {
                        $("#loader").hide();
                        $("#result_error_message").fadeIn("slow").html('Somthing Went to Wrong');
                        setTimeout(function() {
                            $("#result_error_message").fadeOut("slow");
                        }, 2000);
                    }
                }
            });
        } else {
            $("#loader").hide();
            return confirm('Please select Record');
        }
    });
});