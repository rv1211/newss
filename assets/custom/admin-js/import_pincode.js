$(function() {
    var hiddenurl = $('#hiddenURL').val();

    $(document).on('change', '#logistic_type', function(event) {
        event.preventDefault();
        $('#common_import').show();
        $('#import_note').show();
        // if ($(this).val() == "") {
        //     $('.import_link').hide();
        //     $('#import_note').hide();
        // } else {
        //     $('.import_link').hide();
        //     $('#import_note').hide();
        //     if ($(this).val() == 1) {
        //         $('#shadowfax_import').show();
        //         $('#import_note').show();
        //     } else if ($(this).val() == 2 || $(this).val() == 3) {
        //         $('#xpressbees_import').show();
        //         $('#import_note').show();
        //     } else {
        //         $('#common_import').show();
        //         $('#import_note').show();
        //     }
        // }
    });


    /*Pincode import form validation*/
    $("form[name='pincode_import_form']").validate({
        rules: {
            logistic: {
                required: true,
            },
            option: {
                required: true,
            },
            pincode_excel: {
                required: true,
            },
        },
        messages: {
            logistic: {
                required: "Please select Logistic type.",
            },
            option: {
                required: "Please select option.",
            },
            pincode_excel: {
                required: "Please select Excel File.",
            }

        },
        submitHandler: function(form) {
            $("#loader").show();
            form.submit();
            $("#import_btn").attr("disabled", true);
        },
        invalidHandler: function(form) {
            $("#loader").hide();
        }
    });




    /*Pre Bulk import form validation*/
    $("form[name='pre_bulk_order']").validate({
        rules: {
            pickup_address: {
                required: true,
            },
            pre_bulk_import_file: {
                required: true,
            },
            logistic: {
                required: true,
            },
        },
        messages: {
            pickup_address: {
                required: "Please select Pickup Address.",
            },
            pre_bulk_import_file: {
                required: "Please select Excel File.",
            },
            logistic: {
                required: "Please select Logistic.",
            }

        },
        submitHandler: function(form) {
            $("#loader").show();
            form.submit();
            $("#pre_bulk_btns").attr("disabled", true);
        },
        invalidHandler: function(form) {
            $("#loader").hide();
        }
    });


    /*Bulk import form validation*/
    $("form[name='bulk_order_form']").validate({
        rules: {
            pickup_address: {
                required: true,
            },
            import_file: {
                required: true,
            },
        },
        messages: {
            pickup_address: {
                required: "Please select Pickup Address.",
            },
            import_file: {
                required: "Please select Excel File.",
            }

        },
        submitHandler: function(form) {
            $("#loader").show();
            form.submit();
            $("#importfile_btn").attr("disabled", true);
        },
        invalidHandler: function(form) {
            $("#loader").hide();
        }
    });


    // import airway bill 
    $("form[name='create_bulk_order_form']").validate({
        rules: {
            logistic: {
                required: true,
            },
            type: {
                required: true,
            },
            for_what: {
                required: true,
            },
            airway_import_file: {
                required: true,
            },
        },
        messages: {
            logistic: {
                required: "Please select Pickup Address.",
            },
            type: {
                required: "Please select type",
            },
            for_what: {
                required: "Please select for what",
            },
            airway_import_file: {
                required: "Please select Excel File.",
            }

        },
        submitHandler: function(form) {
            $("#loader").show();
            form.submit();
            $("#airway").attr("disabled", true);
        },
        invalidHandler: function(form) {
            $("#loader").hide();
        }
    });

    //generate ecom pincode


});