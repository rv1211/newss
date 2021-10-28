/**
 * Js By Unnati start
 */
var hiddenurl = $('#hiddenUrl').val();
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 
      && (charCode < 48 || charCode > 57))
       return false;
    return true;
  }
  $(document).ready(function () {
    var view_unpaid_invoice_tbl = $('#view_unpaid_invoice_tbl').DataTable({
      "ordering": false,
      initComplete: function () {
        this.api().columns().every(function () {
          var column = this;
          if (column.index() == 0 || column.index() == 7) {
            return;
          }
          if (column.index() == 1 || column.index() == 2 || column.index() == 3 || column.index() == 4 || column.index() == 5 || column.index() == 6) {
            input = $('<input type="text" style="width:150px" />').appendTo($(column.header())).on('keyup change', function () {
              if (column.search() !== this.value) {
                column.search(this.value)
                .draw();
              }
            });
            return;
          }
        });
      }
    });
    $("#unpaid_invoice_user_id").change(function(){
      $(".se-pre-con").fadeIn("slow");
      var user_id = $(this).val();
      $.ajax({
        url     : hiddenurl+'admin/unpaid_invoice_list_data',
        type    : 'POST',
        data: {user_id:user_id},
        success: function(response){
          $(".se-pre-con").fadeOut("slow");
          $('#unpaid_invoice_list_tbody').html(response);
          $("#unpaid_invoice_list").show();
          $("#save_button_div").show();
        }
      });
    });
    $( document ).delegate('.invoice_amount', 'keyup', function(){
      var id = $(this).attr('id');
      var value = $(this).val();
      var remain = $(this).data('remain');
      if (value!=0) {
        if (value>remain) {
          $('#'+id).parent().find('span.error').html('You can not enter more than remain amount');
          $('#'+id).focus();  
          $('#check_invoice_'+id).prop('disabled',true);
          return false;
        }else{
          $('#'+id).parent().find('span.error').html(''); 
          $('#check_invoice_'+id).prop('disabled',false);
        }
      }if(value=='0'){
        $('#'+id).parent().find('span.error').html('You can not enter 0 amount');
        $('#'+id).focus();  
        $('#check_invoice_'+id).prop('disabled',true);        
      }
      sumOfgrid();
    });
    $( document ).delegate('#save_amount', 'click', function(){
      var form = $('#update_unpaid_invoice_amount')[0];
      var check_box = $(".check_invoice").serializeArray();
      var error = "";
      $('.check_invoice').each(function () {
        if ($(this).is(':checked')) {
          var id = $(this).val();
          var amount = $('#'+id).val();
          if (amount == "" || amount =='0') {
            error = "error";
            $('#'+id).parent().find('span.error').html('enter amount');
            $('#'+id).focus();
            return false;
          }
        }
      });
      if (error=="") {
        if(check_box.length > 0){
          $.ajax({
            url     : hiddenurl+'admin/update_unpaid_invoice_amount',
            type    : 'POST',
            data: new FormData(form),
            processData: false,
            contentType: false,
            success: function(response){
              $(".se-pre-con").fadeOut("slow");
              if (response=='success') {
                $("#save_amount").prop('disabled',true);
                $("#result_message").fadeIn("slow").html('Invoice update successfully');
                setTimeout(function() {
                  $("#result_message").fadeOut("slow");
                  location.reload();
                }, 3000); 
              }else{
                $("#result_error_message").fadeIn("slow").html('Something wents to wrong');
                setTimeout(function() {
                  $("#result_error_message").fadeOut("slow");
                }, 3000); 
              }
            }
          });
        }
        else{
          $(".se-pre-con").fadeOut("slow");
          alert("Please Select Invoice...");
          return false;
        }
      }else{
        return false;
      }

    });
    function sumOfgrid() {
      var Total = parseFloat(0.0);
      $('.invoice_amount').each(function () {
        if ($(this).val() != "") {
          var itemToalsum = parseFloat($(this).val());
          Total += itemToalsum;
        }
      });
      $('#total_enter_amount').html((Total).toFixed(2));
    }
  });
/**
 * Js by Unnati ends
 */