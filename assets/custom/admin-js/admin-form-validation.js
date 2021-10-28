$(function () {
    var hiddenurl = $('#hiddenURL').val();

    $('#Customer_Mobile_no').keypress(function (key) {
        if (key.charCode < 48 || key.charCode > 57)
            return false;

    });

    /**
     * Profile
     */
    $("form[name='profile_form']").validate({
        rules: {
            fullname: {
                required: true,
            },
            phone: {
                required: true,
                minlength: 10,
                maxlength: 12,
                number: true
            },
            password: {
                minlength: 8,
                maxlength: 16
            },
            website: {
                url: true
            }
        },
        messages: {
            fullname: {
                required: 'Please Enter a Name',
            },
            phone: {
                required: "Please Enter Phone Number",
                minlength: "Your Phone Number must be at least 10 characters long",
                maxlength: "Your password must be less than 12 characters long",
                number: "Please Enter only number"
            },
            password: {
                minlength: "Your password must be at least 10 characters long",
                maxlength: "Your password must be less than 16 characters long"
            },
            website: {
                url: "valid url!"
            }
        },
        submitHandler: function (form) {
            form.submit();
            $("#profile_btn").attr("disabled", true);
        }
    });


    /**
     *  Registration Form
     */
    //    var profile_email = hiddenurl+"front_login/check_duplicate_email/";
    $("form[name='manage_pickup_address']").validate({
        rules: {
            warehouse_name: 'required',
            contact_person_name: 'required',
            contact_email: {
                required: true,
                email: true,
            },

            address_line_1: {
                required: true,
            },
            pincode: {
                required: true,
                minlength: 6,
                maxlength: 6,
                number: true,
            },
            contact_no: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            website: {
                url: true,
            },
            state: 'required',
            city: 'required',
        },
        messages: {
            warehouse_name: {
                required: "Please Enter Warehouse Name",
            },

            contact_person_name: {
                required: "Please Enter Contact Person Name",
            },
            contact_email: {
                required: "Please Enter Contact Email",
                email: "Please Enter Valid Email"
            },
            address_line_1: {
                required: "Please Enter Address",
            },
            pincode: {
                required: "Please Enter Pincode",
                minlength: "Please enter 6 digit",
                maxlength: "Please enter 6 digit",
            },
            contact_no: {
                required: "Please Enter Contact number",
                minlength: "Plase enter 10 digit",
                maxlength: "Plase enter 10 digit",
            },
            website: {
                url: "Please Enter valid Website URL",
            },
            // website: "Please Enter Website",
            state: "Please Enter state",
            city: "Please Enter city"
        },
        submitHandler: function (form) {
            form.submit();
            $("#pickup_address_btn").attr("disabled", true);
        }
    });

    //user wallet Balance form validation
    $("#wallet_update_for_user").validate({
        rules: {
            user_id: {
                required: true,
            },
            wallet_action: {
                required: true,
            },
            wallet_amount: {
                required: true,
                number: true,
                minvalue: 1
            },
            wallet_remarks: {
                required: true
            }
        },
        messages: {
            user_id: {
                required: "Please select User.",
            },
            wallet_action: {
                required: "Please select action.",
            },
            wallet_amount: {
                required: "Please enter amount.",
                number: "Please enter number only.",
            },
            wallet_remarks: {
                required: "Please enter remarks."
            }
        },
        submitHandler: function (form) {
            $(".se-pre-con").fadeIn("slow");
            $('#wallet_update_for_user_button').prop('disabled', true);
            form.submit();
        },
        invalidHandler: function (form) {
            $(".se-pre-con").hide();
        }
    });

    //user edit form js Ruchita
    $('.user-edit-form').validate({
        rules: {
            "fullname": {
                required: true,
            },
            "user_type": {
                required: true,
            },
            "phone": {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true,
            },
            "email": {
                required: true,
            },
            messages: {
                fullname: {
                    required: "Enter Name.",
                },
                user_type: {
                    required: "Select User Type.",
                },
                phone: {
                    required: "Enter a phone number.",
                    minlength: "Enter valid phone number",
                    maxlength: "Enter valid phone number",
                    digits: "Enter only numbers.",
                },
                email: {
                    required: "Enter email.",
                }
            },
            submitHandler: function (form) {
                $(".se-pre-con").fadeIn("slow");
                $('#user-update-btn').prop('disabled', true);
                form.submit();
            },
            invalidHandler: function (form) {
                $(".se-pre-con").hide();
            }
        },
    });

    //user add form validation
    $('.user-add-form').validate({
        rules: {
            "fullname": {
                required: true,
            },
            "user_type": {
                required: true,
            },
            "phone": {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true,
            },
            "email": {
                required: true,
            },
            messages: {
                fullname: {
                    required: "Enter Name.",
                },
                user_type: {
                    required: "Select User Type.",
                },
                phone: {
                    required: "Enter a phone number.",
                    minlength: "Enter valid phone number",
                    maxlength: "Enter valid phone number",
                    digits: "Enter only numbers.",
                },
                email: {
                    required: "Enter email.",
                }
            },
            submitHandler: function (form) {
                $(".se-pre-con").fadeIn("slow");
                $('#user-add-btn').prop('disabled', true);
                form.submit();
            },
            invalidHandler: function (form) {
                $(".se-pre-con").hide();
            }
        },
    });


    // #delete_btn
    $(document).delegate('#delete_btn', 'click', function () {
        if (!confirm("Are you want to sure Delete")) {
            return false;
        }
    });

    // #delete_btn_bulk
    $(document).delegate('#delete_btn_bulk', 'click', function () {
        if (!confirm("Are you want to sure Delete")) {
            return false;
        }
    });


    $("#ckbCheckAll").on('click', function () {
        var a = $(".getChecked").prop('checked', $(this).prop('checked'));
        var all_pro = $("#ckbCheckAll").prop('checked');
        if (all_pro == true) {
            $("input.getChecked:checked").parent().addClass("checked");
        }
        if (all_pro == false) {
            $("input.getChecked").parent().removeClass("checked");
        }
        var countALL = $("input.getChecked:checked").length;
    });

    $(document).delegate(".getChecked", "change", function (e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        var all_pro = $("#ckbCheckAll").prop('checked');
        if (all_pro == true) {
            $("#ckbCheckAll").prop('checked', false);
            $("#ckbCheckAll").parent().removeClass("checked");
        }
    });


    var values = [];
    $('#pre_airway_order_bulk').change(function () {
        {
            $('#pre_airway_order_bulk :checked').each(function () {
                if ($(this).val() && $(this).val() != '') {
                    values.push($(this).val());
                }
            });
        }

    });

    $("#subm").click(function () {

        if (values.length == 0) {
            alert('please select at least one checkbox');
            return false;
        }
        $.ajax({
            url: hiddenURL + 'order_number_pre_bulk_order',
            type: 'POST',
            data: { values: values },
            datatype: 'json',
            success: function (data) {
                $('#response').html(data);
            }
        });
        return false;
    })

});



//ajax simple bulk order
$("#Bulk_ckbCheckAll").on('click', function () {
    var a = $(".getChecked").prop('checked', $(this).prop('checked'));
    var all_pro = $("#Bulk_ckbCheckAll").prop('checked');
    if (all_pro == true) {
        $("input.getChecked:checked").parent().addClass("checked");
    }
    if (all_pro == false) {
        $("input.getChecked").parent().removeClass("checked");
    }
    var countALL = $("input.getChecked:checked").length;
});

$(document).delegate(".getChecked", "change", function (e) {
    e.stopImmediatePropagation();
    e.preventDefault();
    var all_pro = $("#Bulk_ckbCheckAll").prop('checked');
    if (all_pro == true) {
        $("#Bulk_ckbCheckAll").prop('checked', false);
        $("#Bulk_ckbCheckAll").parent().removeClass("checked");
    }
});


var values = [];
$('#bulk_order_table,#pre_airway_order_bulk').change(function () {
    values = []; {
        $('#bulk_order_table :checked,#pre_airway_order_bulk :checked').each(function () {
            if ($(this).val() && $(this).val() != '' && $.inArray($(this).val(), values) == -1) {
                values.push($(this).val());
            }
        });
    }

});

$("#subm_bulk_simple,#pre_awb_bulk_subm").click(function () {
    if (values.length == 0) {
        alert('please select at least one checkbox');
        return false;
    }
    $.ajax({
        url: hiddenURL + 'simple_order_number_bulk_order',
        type: 'POST',
        data: { values: values },
        dataType: 'JSON',
        success: function (data) {
            // console.log(data);
            // return false;
            if (data.status == 1) {
                $("#result_message").fadeIn("slow").html("Order is in process");
                setTimeout(function () {
                    $("#result_message").fadeOut("slow");
                    location.reload();
                }, 3000);

            } else if (data.status == 2) {
                $("#result_error_message").fadeIn("slow").html("you have already " + data.count + "   bulk orders in pending,Please wait untill it's done");
                setTimeout(function () {
                    $("#result_error_message").fadeOut("slow");
                    location.reload();
                }, 6000);
            } else if (data.status == 3) {
                $("#result_error_message").fadeIn("slow").html("You have not set logistic priority.");
                setTimeout(function () {
                    $("#result_error_message").fadeOut("slow");
                    location.reload();
                }, 6000);
            }
            else {
                $("#result_error_message").fadeIn("slow").html("You have not sufficient wallet balance to process all order please select few less and try again");
                setTimeout(function () {
                    $("#result_error_message").fadeOut("slow");
                    location.reload();
                }, 6000);
            }
            // $('#response').html(data);
        }
    });
    // return false;
});