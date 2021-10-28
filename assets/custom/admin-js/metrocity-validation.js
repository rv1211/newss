$(function() {

    var hiddenurl = $('#hiddenURL').val();

    $(document).delegate('.edit', 'click', function() {
        var metrocity_id = $(this).data('id');
        var metrocity_name = $(this).data('name');
        $('#metrocity_id').val(metrocity_id);
        $('#metrocity_name').val(metrocity_name);
        $('html, body').animate({
            scrollTop: '0'
        }, 2000);
    });

    // Start - create Metrocity form 
    /**
     *  validation : Metrocity
     */
    $("form[name='metrocity_form']").validate({
        rules: {
            metrocity_name: {
                required: true,
            },
        },
        messages: {
            metrocity_name: {
                required: "This Field is required",
            },
        },
        submitHandler: function(form) {
            form.submit();
            $("#metrocity_submit").attr("disabled", true);
        }
    });


});