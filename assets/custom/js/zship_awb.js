$(document).ready(function () {
    var hiddenURL = $('#hiddenURL').val();

    $('#zship_logistic, #order_type').on('change', function (e) {
        var zship_logistic = $("#zship_logistic").val();
        var order_type = $("#order_type").val();
        if(zship_logistic != '' && order_type != ''){
            $.ajax({
                type: "post",
                url: hiddenURL + "zship_awb/get_total_awb",
                data: {
                    zship_logistic : zship_logistic, order_type:order_type,
                },
                success: function (response) {  
                    $("#totalAwb").html(response);
                }
            });
        } else{
            $('#totalAwb').html('00');
        }
    });

    //user wallet Balance form validation
    $("#generate_awb").validate({
        rules: {
            zship_logistic: {
                required: true,
            },
            order_type: {
                required: true,
            }
        },
        messages: {
            zship_logistic: {
                required: "Please select Logistic.",
            },
            wallet_action: {
                required: "Please select Type.",
            }
        },
        submitHandler: function(form) {
            form.submit();
            $("#awb_btn").attr("disabled", true);
        }
    });
});