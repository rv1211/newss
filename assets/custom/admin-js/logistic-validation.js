$(function() {

    // var hiddenurl = $('#hiddenURL').val();

    $(document).delegate('.logistic_edit', 'click', function() {
        var logistic_id = $(this).data('id');
        var logisticname = $(this).data('name');
        var codprice = $(this).data('cod');
        var codpercentage = $(this).data('cod_pr');
        var apiName = $(this).data('api');
        var iszship = $(this).data('zship');


        $('#logistic_id').val(logistic_id);
        $('#logisticname').val(logisticname);
        $('#codprice').val(codprice);
        $('#codpercentage').val(codpercentage);
        $('#api_name').val(apiName);
        if (iszship == '0') {
            $('#iszship').prop('checked', true);
        } else {
            $('#iszship').prop('checked', false);
        }

        $('html, body').animate({
            scrollTop: $("#logistic_id").offset().top
        }, 2000);

    });

});