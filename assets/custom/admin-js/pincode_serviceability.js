$(function() {
    // validation : pincode_serviceability_form
    //return pincode_serviceability
    $("form[name='pincode_serviceability_form']").validate({
        rules: {
            your_pincode: {
                required: true,
                number: true,
                minlength: 6,
                maxlength: 6
            },
            check_pincode: {
                required: true,
                number: true,
                minlength: 6,
                maxlength: 6
            }
        },
        messages: {
            your_pincode: {
                required: "This value is required.",
                number: "Please Enter Only Number",
                minlength: "Kindly enter a valid pincode of 6 digits only",
                maxlength: "Kindly enter a valid pincode of 6 digits only"
            },
            check_pincode: {
                required: "This value is required.",
                number: "Please Enter Only Number",
                minlength: "Kindly enter a valid pincode of 6 digits only",
                maxlength: "Kindly enter a valid pincode of 6 digits only"
            }
        },
        submitHandler: function() {
            form.submit();
            $("#pincode_submit").attr("disabled", true);
        }
    });
});