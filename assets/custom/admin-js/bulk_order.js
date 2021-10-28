$(function () {

    var hiddenurl = $('#hiddenURL').val();

    $("#delete_nultiple_bulk_order_all").click(function (e) {
        $.ajax({
            type: "post",
            url: hiddenurl + "/delete-all-error-order",
            dataType: "JSON",
            success: function (response) {
                if (response.status == "1") {
                    $("#result_message").fadeIn("slow").html(response.msg);
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
    });
});