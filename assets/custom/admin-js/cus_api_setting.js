$(function() {
    var hiddenurl = $('#hiddenURL').val();

    $(document).delegate('#customer_api_setting_customer_id', 'change', function() {
        $(".ajax-loader").fadeIn('slow');
        $("#customer_api_setting_info_pdf_button").hide();
        $.ajax({
            url: hiddenurl + 'Customer_api_setting/get_customer_api_info',
            type: 'POST',
            dataType: 'json',
            data: { sender_id: $(this).val() },
            success: function(response) {
                $('#customer_api_setting_api_key').html(response.api_key);
                $('input[name=api_key]').val(response.api_key);
                $('#customer_api_setting_api_user_id').html(response.api_user_id);
                $('input[name=api_user_id]').val(response.api_user_id);
                if (response.api_is_web_access == 1) {
                    $('#customer_api_setting_is_web_access').prop('checked', true);
                    $("#customer_api_setting_key_and_id_div").show();
                } else {
                    $('#customer_api_setting_is_web_access').prop('checked', false);
                    $("#customer_api_setting_key_and_id_div").hide();
                }
                $('#customer_api_setting_pickup_address_id').html(response.all_pickup_address);
                $(".ajax-loader").fadeOut('slow');
            }
        });
    });
    $(document).delegate('#customer_api_setting_is_web_access', 'click', function() {
        if ($("#customer_api_setting_is_web_access").prop('checked') == 1) {
            $("#customer_api_setting_key_and_id_div").show();
        } else {
            $("#customer_api_setting_info_pdf_button").hide();
            $("#customer_api_setting_key_and_id_div").hide();
        }
    });

    $(document).delegate('#customer_api_setting_info_save,#customer_api_setting_info_pdf_button', 'click', function() {
        $("#customer_api_setting_is_web_access").prop('checked');
        var form = $('#customer_api_setting_form')[0];
        $('#customer_api_setting_form').validate({
            rules: {
                customer_id: {
                    required: true,
                },
                api_pickup_address_id: {
                    required: true,
                },
            },
            focusInvalid: true,
            messages: {
                customer_id: {
                    required: "Please select Customer.",
                },
                api_pickup_address_id: {
                    required: "Please select pickup address.",
                },
            },
        });
        if ($("#customer_api_setting_form").valid()) {
            var action_perfom = $(this).attr('id');
            var formData = new FormData(form);
            formData.append('action_perfom', action_perfom);
            $(".ajax-loader").fadeOut("slow");
            $.ajax({
                url: hiddenurl + 'Customer_api_setting/update_customer_api_settings',
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (action_perfom == "customer_api_setting_info_save") {
                        if (response == 'success') {
                            $(".ajax-loader").fadeOut("slow");
                            if ($("#customer_api_setting_is_web_access").prop('checked') == 1) {
                                $("#customer_api_setting_info_pdf_button").show();
                            } else {
                                $("#customer_api_setting_info_pdf_button").hide();
                            }
                            $("#result_message").fadeIn("slow").html('Setting update successfully');
                            setTimeout(function() {
                                $("#result_message").fadeOut("slow");
                            }, 5000);
                        } else if (response.error != "") {
                            $(".ajax-loader").fadeOut("slow");
                            $("#customer_api_setting_info_pdf_button").hide();
                            $("#result_error_message").fadeIn("slow").html('Something wents to wrong');
                            setTimeout(function() {
                                $("#result_error_message").fadeOut("slow");
                            }, 5000);
                        }
                    }
                    if (action_perfom == "customer_api_setting_info_pdf_button") {
                        $(".se-pre-con").fadeOut("slow");
                        window.open(hiddenurl + 'uploads/customer_api_pdf/' + response, '_blank');
                    }
                }
            });
        } else {
            $(".ajax-loader").fadeOut("slow");
            return false;
        }
    });

});