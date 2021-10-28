$(function() {
    var hiddenurl = $('#hiddenURL').val();

    $("form[name='assingawb']").validate({
        rules: {
            sender_name: {
                required: true,
            },
            logistic_type: {
                required: true,
            },

        },
        messages: {
            sender_name: {
                required: "Please select customer.",
            },
            logistic_type: {
                required: "Please select Logistic Type.",
            },


        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $(document).delegate('#sender_name', 'change', function() {

        var sender_id = $('#sender_name').val();
        if (sender_id) {
            $.ajax({
                type: "POST",
                url: hiddenurl + "Assign_awb/get_sender_id",
                data: { sender_id: sender_id },
                success: function(response) {
                    $('#logistic_type').html(response);
                }
            });
        } else {
            $('.sender_error').html('Select customer');
        }
    });

    $(document).delegate('#assign_awb_btn', 'click', function() {
        $("#loader").show();
        var sender_id = $('#sender_name').val();
        var logistic_type = $('#logistic_type').val();
        console.log(logistic_type)
        if (sender_id != "" && logistic_type != "") {
            $('#awb_panel').removeAttr("style");
            $.ajax({
                type: "POST",
                url: hiddenurl + "Assign_awb/get_awb_table",
                data: { sender_id: sender_id, logistic_type: logistic_type },
                success: function(response) {
                    if (response != "error") {
                        //console.log(response);
                        $('.awb_table').html(response);
                        $("#loader").hide();
                    } else {
                        $("#loader").hide();
                        $("#result_error_message").fadeIn("slow").html('There is no logistic assign to customer,First you have to assign logistic to the user');
                        setTimeout(function() {
                            $("#result_error_message").fadeOut("slow");
                        }, 2000);
                    }
                },

            });
        }

    });


    $(document).delegate('#export', 'click', function() {

        var logistic = $('#logistic_type').val();
        var sender_id = $('#sender_name').val();

        var check_array = [];
        if ($('.table').length > 0) {
            $.each($("input[name='checkbox_item']:checked"), function() {
                check_array.push($(this).val());
            });
        }

        if (check_array.length > 0) {
            $.ajax({
                type: 'POST',
                url: hiddenurl + "Assign_awb/export_data",
                data: { check_array: check_array, logistic: logistic, sender_id: sender_id },
                success: function(response) {
                    if (response) {
                        var decoded_string = atob(response);
                        window.location = decoded_string;
                        if (decoded_string) {
                            $("#result_message").fadeIn("slow").html(".xls File Generated Successfully");
                            setTimeout(function() {
                                $("#result_message").fadeOut("slow");
                            }, 2000);
                            $('#select_all').prop('checked', false);
                            $('#checked_item').prop('checked', false);

                        } else {
                            $("#result_error_message").fadeIn("slow").html('Somthing Went to Wrong');
                            setTimeout(function() {
                                $("#result_error_message").fadeOut("slow");
                            }, 2000);
                        }
                    }
                }
            });
        } else {
            return confirm('Please select Record');
        }
    });



    $(document).delegate('#sender_name_assig_label', 'change', function() {
        var id = $(this).val();
        $.ajax({
            type: "post",
            url: hiddenurl + "Manage_customer/check_assigned_label",
            data: {
                id: id
            },
            success: function(response) {


            }
        });
    });




});