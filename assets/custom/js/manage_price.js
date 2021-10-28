$(document).ready(function() {
    var hiddenURL = $('#hiddenURL').val();

    $('#user_id').on('change', function(e) {
        $("#logistic_id").empty();
        $("#logistic_price_table").hide();
        var optionSelected = $("option:selected", this);
        var user_id = this.value;

        $.ajax({
            type: "post",
            url: hiddenURL + "price/get_assigned_logistic",
            data: {
                user_id: user_id,
            },
            success: function(response) {
                $("#logistic_id").html(response);
            }
        });

    });



});