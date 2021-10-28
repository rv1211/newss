$(function() {

    var hiddenurl = $('#hiddenURL').val();

    $(document).delegate('.rule_edit', 'click', function() {
        var rule_id = $(this).data('id');
        var rule_name = $(this).data('name');
        var rule_from = $(this).data('from');
        var rule_to = $(this).data("to");


        $('#rule_id').val(rule_id);
        $('#rule_name').val(rule_name);
        $('#rule_from').val(rule_from);
        $('#rule_to').val(rule_to);
    });

    /**
     * Manage Shipping Price
     */
    $(document).delegate('.shipping_price_edit', 'click', function() {
        var ship_price_id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: hiddenurl + '/edit-shipping-price',
            data: { ship_price_id: ship_price_id },
            dataType: 'HTML',
            success: function(response) {
                var result = $.parseJSON(response);
                $('#manage_price_id').val(result.id);
                $('#logisticDiv').html(result.logisticDrop);
                $('#ruleDiv').html(result.ruleDrop);
                $('#shipDiv').html(result.shipDrop);
                $('#withinzone').val(result.within_zone);
                $('#withincity').val(result.within_city);
                $('#withinstate').val(result.within_state);
                $('#metro').val(result.metro);
                $('#metro2').val(result.metro_2);
                $('#restofindia').val(result.rest_of_india);
                $('#restofindia2').val(result.rest_of_india_2);
                $('#specialzone').val(result.special_zone);
                $('#rule_index').val(result.rule_index);
                if (result.is_cod_charge_return == '1') {
                    $('#cod_return').prop('checked', true);
                } else{
                    $('#cod_return').prop('checked', false);
                }
                $('.select2').select2();
                $('html, body').animate({
                    scrollTop: $(".page-title").offset().top
                }, 2000);
            }
        });
    });

});