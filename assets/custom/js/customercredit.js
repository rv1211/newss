var hiddenURL = $("#hiddenURL").val();
$(document).ready(function() {
    $(document).delegate("#customer_allow_credit_customer_id", 'change', function() {

        var customer_id = $(this).val();
        var allow_credit = $("#customer_allow_credit_customer_id option:selected").data('allowcredit');
        var allow_credit_limit = $("#customer_allow_credit_customer_id option:selected").data('allowcreditlimit');

        if (allow_credit == 1) {
            $("#customer_allow_credit_is_allow_credit").prop('checked', true);
            $("#customer_allow_credit_limit_div").show();
            $("input[name=allow_credit_limit]").val(allow_credit_limit);
        } else {
            $("#customer_allow_credit_is_allow_credit").prop('checked', false);
            $("#customer_allow_credit_limit_div").hide();
        }
    });
    $(document).delegate("#customer_allow_credit_is_allow_credit", 'click', function() {
        var allow_credit = $("#customer_allow_credit_is_allow_credit").prop('checked');
        if (allow_credit == 1) {
            $("#customer_allow_credit_is_allow_credit").prop('checked', true);
            $("#customer_allow_credit_limit_div").show();
        } else {
            $("#customer_allow_credit_is_allow_credit").prop('checked', false);
            $("#customer_allow_credit_limit_div").hide();
        }
    });
    $(document).delegate("#customer_allow_credit_info_save", 'click', function() {
        var form = $('#customer_allow_credit_form')[0];
        $('#customer_allow_credit_form').validate({
            rules: {
                customer_id: {
                    required: true,
                },

                allow_credit_limit: {
                    required: function(element) {
                        if ($("#customer_allow_credit_is_allow_credit").prop('checked') > 0) {
                            return true;
                        } else {
                            return false;
                        }
                    },
                    number: true,
                },
            },
            errorElement: 'span',
            focusInvalid: true,
            messages: {
                customer_id: {
                    required: "Please select customer.",
                },
            },
        });
        if ($("#customer_allow_credit_form").valid()) {
            $(".ajax-loader").fadeOut("slow");
            $.ajax({
                url: hiddenURL + 'customer-update-allow-credit',
                type: "post",
                data: new FormData(form),
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response == 'success') {
                        // $(".ajax-loader").fadeOut("slow");
                        $("#result_message").fadeIn("slow").html('Credit update successfully');
                        setTimeout(function() {
                            $("#result_message").fadeOut("slow");
                            location.reload();
                        }, 5000);
                    } else {
                        // $(".ajax-loader").fadeOut("slow");
                        $("#result_error_message").fadeIn("slow").html('Something wents to wrong');
                        setTimeout(function() {
                            $("#result_error_message").fadeOut("slow");
                        }, 5000);
                    }
                }
            });
        } else {
            $(".ajax-loader").fadeOut("slow");
            return false;
        }
    });


    //if ($('#credit_customer_id').val() != "" && $('#credit_used_from_date').val() != "" && $('#credit_used_to_date').val() != "") {
    $("#customer_usedcredit_list").DataTable({
        //"info": false,
        "serverSide": true,
        "pageLength": 100,
        "lengthMenu": [
            [100, 500, 1000, -1],
            [100, 500, 1000, "All"]
        ],
        "columnDefs": [{
            "targets": [1, 2, 3],
            "orderable": false,
            //"searchable": false,
        }],
        "ajax": {
            "url": hiddenURL + 'customer-used-credit-table',
            'type': 'POST',
            'data': { "customer_id": $('#credit_customer_id').val(), "from_date": $('#credit_used_from_date').val(), "to_date": $('#credit_used_to_date').val() },

        },
        "language": {
            "infoFiltered": "",
        },
    });


    $("#customer_credit_list").DataTable({
        //"info": false,
        "serverSide": true,
        "pageLength": 100,
        "lengthMenu": [
            [100, 500, 1000, -1],
            [100, 500, 1000, "All"]
        ],
        "ajax": {
            "url": hiddenURL + 'customer-credit-table',
            'type': 'POST',
        },
        "language": {
            "infoFiltered": "",
        },
        "columnDefs": [{
            "targets": [2],
            "searchable": false,
            "orderable": false,
        }],
    });

    //}
});