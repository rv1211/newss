$(document).ready(function () {
  var hiddenUrl = $('#hiddenUrl').val();

  $("#import_file").on('click', function () {
    this.value = null;
  });

  $(document).delegate("#import_file", "change", function () {
    $(".se-pre-con").fadeIn("slow");
    var pickup_address = $('#pickup_address').val();
    var cod_priority = $('input[type="radio"][name="cod_priority"]:checked').val();
    $("#importfile").attr("disabled", true);
    var file = $(this).prop('files')[0];
    var formData = new FormData();
    formData.append('import_file', file);
    formData.append('pickup_address', pickup_address);
    formData.append('cod_priority', cod_priority);
    if (pickup_address=="") {
      $(".se-pre-con").fadeOut("slow");
      $('#pickup_address').parent().parent().parent().find('span.error').html('');
      $('#pickup_address').parent().find('span.error').html('Please select Pickup address');            
      return false;        
    }else if ($('input[type="radio"][name="cod_priority"]:checked').length == 0){
      $(".se-pre-con").fadeOut("slow");
      $('#pickup_address').parent().parent().parent().find('span.error').html('');
      $('#cod_priority_error').html('Please select any one option.');            
      return false;        
    }else{
      $.ajax({
        url: hiddenUrl+"order/exceldatadisplay",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        success: function (json_ec) {
          $(".se-pre-con").fadeOut("slow");
          $('#datafile').show();
          $("#datafile").html(json_ec);
        }
      });
      $('#pickup_address').parent().parent().parent().find('span.error').html('');
      $('#cod_priority_error').html('');
    }
  });
  $( document ).delegate('#check_all_bulk_order', 'click', function(){
      var a = $(".check_order").prop('checked', $(this).prop('checked'));
      var all_pro = $("#check_all_bulk_order").prop('checked');
      if(all_pro == true){
          $("input.check_order:checked").addClass("checked");
      }
      if(all_pro == false){
          $("input.check_order").removeClass("checked");
      }
      var countALL = $("input.check_order:checked").length;
  });
  $( document ).delegate('.check_order', 'change', function(e){
      e.stopImmediatePropagation();
      e.preventDefault(); 
      var all_pro = $("#check_all_bulk_order").prop('checked');
      if(all_pro == true){
          $("#check_all_bulk_order").prop('checked',false);
          $("#check_all_bulk_order").removeClass("checked");
      }
  });


  $(document).delegate("#get_data_for_shopify_excel", "click", function () {
    $(".se-pre-con").fadeIn("slow");
    var form = $('#add_shopify_bulk_order')[0];
    var formData = new FormData(form);
    var validator = $('#add_shopify_bulk_order').validate({
      rules: {
        shopify_pickup_address: {
          required: true,
        },
        ship_length: {
          required: true,
        },
        ship_width: {
          required: true,
        },
        ship_height: {
          required: true,
        },
        phy_weight: {
          required: true,
        },
        import_shopify_file: {
          required: true,
        },
      },
      messages: { 
        shopify_pickup_address: {
          required: "Please select pickup address.",
        },
        ship_length: {
          required: "Please enter ship length.",
        },
        ship_width: {
          required: "Please enter ship width.",
        },
        ship_height: {
          required: "Please enter ship height.",
        },
        phy_weight: {
          required: "Please enter physical weight.",
        },
        import_shopify_file: {
          required: "Please select file.",
        },
      },
    });
    if($("#add_shopify_bulk_order").valid()){
      $.ajax({
        url: hiddenUrl+"order/excel_shopify_data_display",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        success: function (json_ec) {
          $(".se-pre-con").fadeOut("slow");
          $('#datafile1').show();
          $("#datafile1").html(json_ec);
        }
      });
    } else{
      $(".se-pre-con").fadeOut("slow");
      validator.focusInvalid();
      return false;
    }
  });
  $( document ).delegate('#check_all_shopify_bulk_order', 'click', function(){
      var a = $(".check_shopify_order").prop('checked', $(this).prop('checked'));
      var all_pro = $("#check_all_shopify_bulk_order").prop('checked');
      if(all_pro == true){
          $("input.check_shopify_order:checked").addClass("checked");
      }
      if(all_pro == false){
          $("input.check_shopify_order").removeClass("checked");
      }
      var countALL = $("input.check_shopify_order:checked").length;
  });
  $( document ).delegate('.check_shopify_order', 'change', function(e){
      e.stopImmediatePropagation();
      e.preventDefault(); 
      var all_pro = $("#check_all_shopify_bulk_order").prop('checked');
      if(all_pro == true){
          $("#check_all_shopify_bulk_order").prop('checked',false);
          $("#check_all_shopify_bulk_order").removeClass("checked");
      }
  });
});  
