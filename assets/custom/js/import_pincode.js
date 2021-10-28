$(function() {
    var hiddenurl = $('#hiddenURL').val();

    $(document).on('change', '#logistic_type', function(event) {
        event.preventDefault();
        if ($(this).val() == "") {
            $('.import_link').hide();
            $('#import_note').hide();
        } else {
            $('.import_link').hide();
            $('#import_note').hide();
            if ($(this).val() == 1) {
                $('#shadowfax_import').show();
                $('#import_note').show();
            } else if ($(this).val() == 2 || $(this).val() == 3) {
                $('#xpressbees_import').show();
                $('#import_note').show();
            } else {
                $('#common_import').show();
                $('#import_note').show();
            }
        }
    });


});