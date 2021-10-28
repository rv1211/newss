/**
 * Js By Unnati start
 */
$(function(){
  var hiddenurl = $('#hiddenUrl').val();

    $('.legitRipple1').click(function(){
        $(".se-pre-con").fadeIn("slow");
        var datatarget = $(this).data('target');
        var is_reverse = $(this).data('isreverse');
        var status = "";
        if (datatarget == '#intransit_tab') {
            $(".se-pre-con").fadeOut("slow");
            $('#intransit_tab').css('display','block'); 
            $('#manifested_tab,#receivedatdestination_tab,#dispatched_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab,#print_shipment_manifest_div').css('display','none');
            status = 'In Transit';
        }            
        if (datatarget == '#manifested_tab') {
            $(".se-pre-con").fadeOut("slow");
            $('#manifested_tab').css('display','block'); 
            $('#print_shipment_manifest_div').css('display','initial'); 
            $('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab').css('display','none');
            status = 'Manifested';
        }             
        if (datatarget == '#receivedatdestination_tab') {
            $(".se-pre-con").fadeOut("slow");
            $('#receivedatdestination_tab').css('display','block'); 
            $('#intransit_tab,#manifested_tab,#dispatched_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab,#print_shipment_manifest_div').css('display','none');
            status = 'Pending';
        }             
        if (datatarget == '#dispatched_tab') {
            $(".se-pre-con").fadeOut("slow");
            $('#dispatched_tab').css('display','block'); 
            $('#intransit_tab,#receivedatdestination_tab,#manifested_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab,#print_shipment_manifest_div').css('display','none');
            status = 'Dispatched';
        }             
        if (datatarget == '#delivered_tab') {
            $(".se-pre-con").fadeOut("slow");
            $('#delivered_tab').css('display','block'); 
            $('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#cancellorder_tab,#not_picked_tab,#print_shipment_manifest_div').css('display','none');
            status = 'Delivered';
        }             
        if (datatarget == '#cancellorder_tab') {
            $(".se-pre-con").fadeOut("slow");
            $('#cancellorder_tab').css('display','block'); 
            $('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#delivered_tab,#not_picked_tab,#print_shipment_manifest_div').css('display','none');
            status = 'Cancelled';
        }                         
        if (datatarget == '#not_picked_tab') {
            $(".se-pre-con").fadeOut("slow");
            $('#not_picked_tab').css('display','block'); 
            $('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#delivered_tab,#cancellorder_tab,#print_shipment_manifest_div').css('display','none');
            status = 'Not Picked';
        }                         
        if (datatarget == '#returned_tab') {
            $(".se-pre-con").fadeOut("slow");
            $('#returned_tab').css('display','block'); 
            $('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab,#print_shipment_manifest_div').css('display','none');
            status = 'Returned';
        } 
        $.ajax({
          url : hiddenurl+'order/fetch_view_order_list',
          type: 'post',
          data: {is_reverse:is_reverse,status:status},
          success: function(response){ 
            $('.se-pre-con').fadeOut('slow');
            // $(datatarget+'_tbody').html(response);
            $('#tab_contents').html(response);
          }
        });
    });

  $( document ).delegate('.order-details', 'click', function(){
    var orderdetailurl = hiddenurl+'order/order_detail_modal';

    $('.se-pre-con').fadeIn('slow');
    $('.modal-body').html(" ");
    var order_id = $(this).attr('id');
    var button_type = $(this).attr('attr-btntype');
    var tab_style = '';
    var tabtype = $(this).attr('attr-tabtype');
    if (button_type == 'order_detail') {tab_style = 'display:block';}

    // AJAX request
    $.ajax({
      url: orderdetailurl,
      type: 'post',
      data: {order_id: order_id,button_type:button_type,tab_style:tab_style,tabtype:tabtype},
      success: function(response){ 
        $('.se-pre-con').fadeOut('slow');
        // Add response in Modal body
        $('.modal-body').html(response);
      }
    });        
  });


  $('.re-order-create').on('click',function(){
    $(".se-pre-con").fadeIn("slow");
    var order_id = $(this).attr('id');
    var shipping_charge = $(this).data('amount');
    var customer_name = $(this).data('customername');
    var customer_address1 = $(this).data('customeraddress1');
    var state = $(this).data('state');
    var pincode = $(this).data('pincode');
    var customer_mobile = $(this).data('customermobile');
    var city = $(this).data('city');
    var customer_email = $(this).data('customeremail');

    $.ajax({
            url     : hiddenurl+'order/re_order_check',
            type: "post",
            data: {order_id:order_id,shipping_charge:shipping_charge},
            dataType: 'json',
            success: function(response){

              if (response.allow_credit==1) {
                if (response.success != "" && response.order_id !="") {
                  $(".se-pre-con").fadeOut("slow");
                  $("#create_order_button").prop('disabled',true);
                  $("#result_message").fadeIn("slow").html(response.success);
                  setTimeout(function() {
                    $("#result_message").fadeOut("slow");
                    location.reload();
                    // window.location.href = hiddenurl+'view-order';
                  }, 7000);                 
              }
              else if(response.error != ""){
                $(".se-pre-con").fadeOut("slow");
                $('#exampleModal').modal('hide');
                $("#result_error_message").fadeIn("slow").html(response.error);
                setTimeout(function() {
                  $("#result_error_message").fadeOut("slow");
                  // window.location.href = hiddenurl+'view-order';
                }, 7000); 
              }
            }else{
              $(".se-pre-con").fadeOut("slow");
              $('#exampleModal').modal('toggle');
              $('.modal-body').html('<div class="modal_buttons"><button type="button" class="btn btn-primary pay_with_wallet" id="pay_with_wallet" value="pay_with_wallet"> Pay with Wallet </button><br><br><button type="button" class="btn btn-success pay_with_razorpay" value="pay_with_razorpay" id="pay_with_razorpay"> Pay with Razorpay </button><input type="hidden" name="order_id" class="modal_order_id" id="modal_order_id" value="'+order_id+'"><input type="hidden" name="modal_order_amount" class="modal_order_amount" id="modal_order_amount" value="'+shipping_charge+'"></div>');
            }
          }
        });
    /*$(".se-pre-con").fadeOut("slow");
    $('#exampleModal').modal('toggle');
    $('.modal-body').html('<div class="modal_buttons"><button type="button" class="btn btn-primary pay_with_wallet" id="pay_with_wallet" value="pay_with_wallet"> Pay with Wallet </button><br><br><button type="button" class="btn btn-success pay_with_razorpay" value="pay_with_razorpay" id="pay_with_razorpay"> Pay with Razorpay </button><input type="hidden" name="order_id" class="modal_order_id" id="modal_order_id" value="'+order_id+'"><input type="hidden" name="modal_order_amount" class="modal_order_amount" id="modal_order_amount" value="'+shipping_charge+'"></div>');*/
  });
  var walleturl = hiddenurl+'order/payment_insert';
  $("#exampleModal").on("click", "#pay_with_wallet", function() {
    $(".se-pre-con").fadeIn("slow");
    var order_id = $('#modal_order_id').val();
    var button_name = "PAY WITH WALLET";
    $.ajax({
      url     : walleturl,
      type: "post",
      data: {order_id:order_id, button_name:button_name},
      success: function(response){
        $(".se-pre-con").fadeOut("slow");
        var message = $.parseJSON(response);
        $.each( message, function( index, value ){
          if(index == 'success'){key1= value;}
          else if(index == 'error'){key2 = value;}
          else if(index == 'status'){key3 = value;}
        });
        if (key1 != '') {
          $("#create_order_button").prop('disabled',true);
          $("#pay_with_razorpay").prop('disabled',true);
          $("#pay_with_wallet").prop('disabled',true);
          $('#exampleModal').modal('hide');
          $("#result_message").fadeIn("slow").html(key1);
          setTimeout(function() {
            $("#result_message").fadeOut("slow");
              window.location.href = hiddenurl+'view-order';
          }, 7000);
        }
        else if(key2 != '') {
            $('#exampleModal').modal('hide');
          $("#result_error_message").fadeIn("slow").html(key2);
          setTimeout(function() {
            $("#result_error_message").fadeOut("slow");
            //location.reload();
          }, 7000);
        }
      }
    });
  });

  var razorpayurl = hiddenurl+'order/payment_insert';
  $("#exampleModal").on("click", "#pay_with_razorpay", function(e) {
    // $(".se-pre-con").fadeIn("slow");
    var order_id = $('#modal_order_id').val();
    var totalAmount1 = $('#modal_order_amount').val();
    var totalAmount = totalAmount1.replace(",", "");
    var button_name = "PAY WITH RAZORPAY";
    var options = {
      "key": "<?php echo RAZORPAY_KEY; ?>",
      "amount": (totalAmount*100),
      "name": "ShipSecure",
      "description": "Order Payment",
      "image": "https://shipsecurelogistics.com/assets/images/logo.png",
      "handler": function (response){
        $(".se-pre-con").fadeIn("slow");
        $.ajax({
          url: razorpayurl,
          type: 'post',
          dataType: 'json',
          data: {
            razorpay_payment_id: response.razorpay_payment_id, razorpay_order_id: response.razorpay_order_id, razorpay_signature: response.razorpay_signature, totalAmount : totalAmount, order_id:order_id, button_name:button_name
          },
          success: function (data) {
            $(".se-pre-con").fadeIn("slow");
            var message = JSON.parse(JSON.stringify(data));
            $.each( message, function( index, value ){
              if(index == 'success'){key1= value;}
              else if(index == 'error'){key2 = value;}
              else if(index == 'status'){key3 = value;}
            });
            if (key1 != '') {
            $(".se-pre-con").fadeOut("slow");
            $('#exampleModal').modal('hide');
              $("#result_message").fadeIn("slow").html(key1);
              setTimeout(function() {
                $("#result_message").fadeOut("slow");
                $("#create_order_button").prop('disabled',true);
                $("#pay_with_razorpay").prop('disabled',true);
                $("#pay_with_wallet").prop('disabled',true);
                window.location.href = hiddenurl+'view-order';
              }, 7000);
            }
            else{
            $(".se-pre-con").fadeOut("slow");
            $('#exampleModal').modal('hide');
              $("#result_error_message").fadeIn("slow").html(key2);
              setTimeout(function() {
                $("#result_error_message").fadeOut("slow");
                //location.reload();
              }, 7000);
            }
          }
        });
      },
      "theme": {
        "color": "#528FF0"
      }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
    e.preventDefault();
  });
});

$(document).ready(function () {
    var hiddenurl = $('#hiddenUrl').val();
    var vieworder_tbl1 = $('#vieworder_tbl1').DataTable({
        "language": {
            "infoFiltered": ""
        },
        "dom": '<"top"lipf<"clear">>rt<"bottom"ip<"clear">>',
        "lengthMenu": [[10, 25, 50, 75, 100, 150], [10, 25, 50, 75, 100, 150]],
        "scrollX": 200,
        "serverSide": true,
        "ajax": {
            "url": hiddenurl+'orderlist/getManifestedAjex',
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 9, 10 ,11],
                "visible": false,
                "searchable": false
            }
        ],
        "ordering": false,
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                if (column.index() == 0 || column.index() == 9 || column.index() == 10) {
                    return;
                }
                if (column.index() == 1 || column.index() == 2 || column.index() == 3  || column.index() == 6 || column.index() == 8) {
                    input = $('<input type="text" />').appendTo($(column.header())).on('keyup change', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value)
                            .draw();
                        }
                    });
                    return;
                }
                var select = $('<select><option value=""></option></select>').appendTo($("#filters1").find("th").eq(column.index())).on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val());
                    column.search(val ? '^' + val + '$' : '', true, false)
                    .draw();
                });
                column.data().unique().sort().each(function (d, j) {
                    if(d != '')
                        select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });
    $( document ).delegate('#all_manifested_order', 'click', function(){
        var a = $(".single_manifested_order").prop('checked', $(this).prop('checked'));
        var all_pro = $("#all_manifested_order").prop('checked');
        if(all_pro == true){
            $("input.single_manifested_order:checked").addClass("checked");
        }
        if(all_pro == false){
            $("input.single_manifested_order").removeClass("checked");
        }
        var countALL = $("input.single_manifested_order:checked").length;
    });
    $( document ).delegate('.single_manifested_order', 'change', function(e){
        e.stopImmediatePropagation();
        e.preventDefault(); 
        var all_pro = $("#all_manifested_order").prop('checked');
        if(all_pro == true){
            $("#all_manifested_order").prop('checked',false);
            $("#all_manifested_order").removeClass("checked");
        }
    });


    var vieworder_tbl2 = $('#vieworder_tbl2').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": hiddenurl+'orderlist/getIntransitAjex',
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 9, 8,10 ],
                "visible": false,
                "searchable": false
            }
        ],
        "ordering": false,
        initComplete: function () {

            this.api().columns().every(function () {
                var column = this;
                 if (column.index() == 0 || column.index() == 8 || column.index() == 9) {
                    return;
                 }
                if (column.index() == 1 || column.index() == 2 || column.index() == 3 || column.index() == 6 ) {
                    input = $('<input type="text" />').appendTo($(column.header())).on('keyup change', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value)
                                .draw();
                        }
                    });
                    return;
                }

                var select = $('<select><option value=""></option></select>')
                    .appendTo($("#filters2").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                column.data().unique().sort().each(function (d, j) {
                    if(d != '')
                        select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });
    $( document ).delegate('#all_intransit_order', 'click', function(){
        var a = $(".single_intransit_order").prop('checked', $(this).prop('checked'));
        var all_pro = $("#all_intransit_order").prop('checked');
        if(all_pro == true){
            $("input.single_intransit_order:checked").addClass("checked");
        }
        if(all_pro == false){
            $("input.single_intransit_order").removeClass("checked");
        }
        var countALL = $("input.single_intransit_order:checked").length;
    });
    $( document ).delegate('.single_intransit_order', 'change', function(e){
        e.stopImmediatePropagation();
        e.preventDefault(); 
        var all_pro = $("#all_intransit_order").prop('checked');
        if(all_pro == true){
            $("#all_intransit_order").prop('checked',false);
            $("#all_intransit_order").removeClass("checked");
        }
    });


    var vieworder_tbl3 = $('#vieworder_tbl3').DataTable({
        "ajax": {
            "url": hiddenurl+'orderlist/getPendingAjex',
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 8,9],
                "visible": false,
                "searchable": false
            }
        ],
        "ordering": false,
        initComplete: function () {

            this.api().columns().every(function () {
                var column = this;
                 if (column.index() == 0 || column.index() == 8 || column.index() == 9) {
                    return;
                 }
                if (column.index() == 1 || column.index() == 2 || column.index() == 3 || column.index() == 6 ) {
                    input = $('<input type="text" />').appendTo($(column.header())).on('keyup change', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value)
                                .draw();
                        }
                    });
                    return;
                }

                var select = $('<select><option value=""></option></select>')
                    .appendTo($("#filters3").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                column.data().unique().sort().each(function (d, j) {
                    if(d != '')
                        select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });
    $( document ).delegate('#all_receivedatdestination_order', 'click', function(){
        var a = $(".single_receivedatdestination_order").prop('checked', $(this).prop('checked'));
        var all_pro = $("#all_receivedatdestination_order").prop('checked');
        if(all_pro == true){
            $("input.single_receivedatdestination_order:checked").addClass("checked");
        }
        if(all_pro == false){
            $("input.single_receivedatdestination_order").removeClass("checked");
        }
        var countALL = $("input.single_receivedatdestination_order:checked").length;
    });
    $( document ).delegate('.single_receivedatdestination_order', 'change', function(e){
        e.stopImmediatePropagation();
        e.preventDefault(); 
        var all_pro = $("#all_receivedatdestination_order").prop('checked');
        if(all_pro == true){
            $("#all_receivedatdestination_order").prop('checked',false);
            $("#all_receivedatdestination_order").removeClass("checked");
        }
    });


    var vieworder_tbl4 = $('#vieworder_tbl4').DataTable({
        "ajax": {
            "url": hiddenurl+'orderlist/getDispatchedAjex',
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 8 ,9],
                "visible": false,
                "searchable": false
            }
        ],
        "ordering": false,
        initComplete: function () {

            this.api().columns().every(function () {
                var column = this;
                 if (column.index() == 0 || column.index() == 8 || column.index() == 9) {
                    return;
                 }
                if (column.index() == 1 || column.index() == 2 || column.index() == 3 || column.index() == 6 ) {
                    input = $('<input type="text" />').appendTo($(column.header())).on('keyup change', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value)
                                .draw();
                        }
                    });
                    return;
                }

                var select = $('<select><option value=""></option></select>')
                    .appendTo($("#filters4").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                column.data().unique().sort().each(function (d, j) {
                    if(d != '')
                        select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });
    $( document ).delegate('#all_diapatched_order', 'click', function(){
        var a = $(".single_diapatched_order").prop('checked', $(this).prop('checked'));
        var all_pro = $("#all_diapatched_order").prop('checked');
        if(all_pro == true){
            $("input.single_diapatched_order:checked").addClass("checked");
        }
        if(all_pro == false){
            $("input.single_diapatched_order").removeClass("checked");
        }
        var countALL = $("input.single_diapatched_order:checked").length;
    });
    $( document ).delegate('.single_diapatched_order', 'change', function(e){
        e.stopImmediatePropagation();
        e.preventDefault(); 
        var all_pro = $("#all_diapatched_order").prop('checked');
        if(all_pro == true){
            $("#all_diapatched_order").prop('checked',false);
            $("#all_diapatched_order").removeClass("checked");
        }
    });


    var vieworder_tbl5 = $('#vieworder_tbl5').DataTable({
        "ajax": {
            "url": hiddenurl+'orderlist/getDeliveredAjex',
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 8,9 ],
                "visible": false,
                "searchable": false
            }
        ],
        "ordering": false,
        initComplete: function () {

            this.api().columns().every(function () {
                var column = this;
                 if (column.index() == 0 || column.index() == 8 || column.index() == 9) {
                    return;
                 }
                if (column.index() == 1 || column.index() == 2 || column.index() == 3 || column.index() == 6 ) {
                    input = $('<input type="text" />').appendTo($(column.header())).on('keyup change', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value)
                                .draw();
                        }
                    });
                    return;
                }

                var select = $('<select><option value=""></option></select>')
                    .appendTo($("#filters5").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                column.data().unique().sort().each(function (d, j) {
                    if(d != '')
                        select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });
    $( document ).delegate('#all_delivered_order', 'click', function(){
        var a = $(".single_delivered_order").prop('checked', $(this).prop('checked'));
        var all_pro = $("#all_delivered_order").prop('checked');
        if(all_pro == true){
            $("input.single_delivered_order:checked").addClass("checked");
        }
        if(all_pro == false){
            $("input.single_delivered_order").removeClass("checked");
        }
        var countALL = $("input.single_delivered_order:checked").length;
    });
    $( document ).delegate('.single_delivered_order', 'change', function(e){
        e.stopImmediatePropagation();
        e.preventDefault(); 
        var all_pro = $("#all_delivered_order").prop('checked');
        if(all_pro == true){
            $("#all_delivered_order").prop('checked',false);
            $("#all_delivered_order").removeClass("checked");
        }
    });

    var vieworder_tbl6 = $('#vieworder_tbl6').DataTable({
        "ajax": {
            "url": hiddenurl+'orderlist/getCancelledAjex',
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 9 ],
                "visible": false,
                "searchable": false
            }
        ],
        "ordering": false,
        initComplete: function () {

            this.api().columns().every(function () {
                var column = this;
                 if (column.index() == 0 || column.index() == 9 || column.index() == 10) {
                     return;
                 }
                if (column.index() == 1 || column.index() == 2 || column.index() == 3  || column.index() == 6  || column.index() == 8) {
                    input = $('<input type="text" />').appendTo($(column.header())).on('keyup change', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value)
                                .draw();
                        }
                    });
                    return;
                }

                var select = $('<select><option value=""></option></select>')
                    .appendTo($("#filters6").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                column.data().unique().sort().each(function (d, j) {
                    if(d != '')
                        select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });
    $( document ).delegate('#all_cancellorder_order', 'click', function(){
        var a = $(".single_cancellorder_order").prop('checked', $(this).prop('checked'));
        var all_pro = $("#all_cancellorder_order").prop('checked');
        if(all_pro == true){
            $("input.single_cancellorder_order:checked").addClass("checked");
        }
        if(all_pro == false){
            $("input.single_cancellorder_order").removeClass("checked");
        }
        var countALL = $("input.single_cancellorder_order:checked").length;
    });
    $( document ).delegate('.single_cancellorder_order', 'change', function(e){
        e.stopImmediatePropagation();
        e.preventDefault(); 
        var all_pro = $("#all_cancellorder_order").prop('checked');
        if(all_pro == true){
            $("#all_cancellorder_order").prop('checked',false);
            $("#all_cancellorder_order").removeClass("checked");
        }
    });

    
    var vieworder_tbl7 = $('#vieworder_tbl7').DataTable({
        "ajax": {
            "url": hiddenurl+'orderlist/getNotPickedAjex',
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 8 ],
                "visible": false,
                "searchable": false
            }
        ],
        "ordering": false,
        initComplete: function () {

            this.api().columns().every(function () {
                var column = this;
                 if (column.index() == 0 || column.index() == 8 || column.index() == 9) {
                    return;
                 }
                if (column.index() == 1 || column.index() == 2 || column.index() == 3 || column.index() == 6 ) {
                    input = $('<input type="text" />').appendTo($(column.header())).on('keyup change', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value)
                                .draw();
                        }
                    });
                    return;
                }

                var select = $('<select><option value=""></option></select>')
                    .appendTo($("#filters7").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                column.data().unique().sort().each(function (d, j) {
                    if(d != '')
                        select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });
    $( document ).delegate('#all_notpicked_order', 'click', function(){
        var a = $(".single_notpicked_order").prop('checked', $(this).prop('checked'));
        var all_pro = $("#all_notpicked_order").prop('checked');
        if(all_pro == true){
            $("input.single_notpicked_order:checked").addClass("checked");
        }
        if(all_pro == false){
            $("input.single_notpicked_order").removeClass("checked");
        }
        var countALL = $("input.single_notpicked_order:checked").length;
    });
    $( document ).delegate('.single_notpicked_order', 'change', function(e){
        e.stopImmediatePropagation();
        e.preventDefault(); 
        var all_pro = $("#all_notpicked_order").prop('checked');
        if(all_pro == true){
            $("#all_notpicked_order").prop('checked',false);
            $("#all_notpicked_order").removeClass("checked");
        }
    });

    
    var vieworder_tbl8 = $('#vieworder_tbl8').DataTable({
        "ajax": {
            "url": hiddenurl+'orderlist/getReturnedAjex',
            "type": "POST"
        },
        "columnDefs": [
            {
                "targets": [ 8],
                "visible": false,
                "searchable": false
            }
        ],
        "ordering": false,
        initComplete: function () {

            this.api().columns().every(function () {
                var column = this;
                 if (column.index() == 0 || column.index() == 8 || column.index() == 9) {
                    return;
                 }
                if (column.index() == 1 || column.index() == 2 || column.index() == 3 || column.index() == 6 ) {
                    input = $('<input type="text" />').appendTo($(column.header())).on('keyup change', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value)
                                .draw();
                        }
                    });
                    return;
                }

                var select = $('<select><option value=""></option></select>')
                    .appendTo($("#filters8").find("th").eq(column.index()))
                    .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val());                                     

                    column.search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
                
                column.data().unique().sort().each(function (d, j) {
                    if(d != '')
                        select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });
    $( document ).delegate('#all_returned_order', 'click', function(){
        var a = $(".single_returned_order").prop('checked', $(this).prop('checked'));
        var all_pro = $("#all_returned_order").prop('checked');
        if(all_pro == true){
            $("input.single_returned_order:checked").addClass("checked");
        }
        if(all_pro == false){
            $("input.single_returned_order").removeClass("checked");
        }
        var countALL = $("input.single_returned_order:checked").length;
    });
    $( document ).delegate('.single_returned_order', 'change', function(e){
        e.stopImmediatePropagation();
        e.preventDefault(); 
        var all_pro = $("#all_returned_order").prop('checked');
        if(all_pro == true){
            $("#all_returned_order").prop('checked',false);
            $("#all_returned_order").removeClass("checked");
        }
    });

    

    $( document ).delegate('.print_multiple_packing_slip', 'click', function(){
        $(".se-pre-con").fadeIn("slow");
        var page_type = $(this).data('page_type');
        var active = $("#my_order_details_tab").children(".active").attr("id");
        var check_array = [];
        if (active == 'manifested') {
            var rowcollection = vieworder_tbl1.$(".single_manifested_order:checked", {"page": "all"});
        } else if (active == 'intransit') {
            var rowcollection = vieworder_tbl2.$(".single_intransit_order:checked", {"page": "all"});
        } else if (active == 'receivedatdestination') {
            var rowcollection = vieworder_tbl3.$(".single_receivedatdestination_order:checked", {"page": "all"});
        } else if (active == 'diapatched') {
            var rowcollection = vieworder_tbl4.$(".single_diapatched_order:checked", {"page": "all"});
        } else if (active == 'delivered') {
            var rowcollection = vieworder_tbl5.$(".single_delivered_order:checked", {"page": "all"});
        } else if (active == 'cancellorder') {
            var rowcollection = vieworder_tbl6.$(".single_cancellorder_order:checked", {"page": "all"});
        } else if (active == 'notpicked') {
            var rowcollection = vieworder_tbl7.$(".single_notpicked_order:checked", {"page": "all"});
        } else if (active == 'returned') {
            var rowcollection = vieworder_tbl8.$(".single_returned_order:checked", {"page": "all"});
        } /*else if (active == 'notfound') {
            var rowcollection = vieworder_tbl9.$(".single_notfound_order:checked", {"page": "all"});
        } */
        rowcollection.each(function(index,elem){
            check_array.push($(elem).val());
        });
        var url = hiddenurl+'order/multiple_print';

        if(check_array.length > 0){
            $.ajax({
                type    : 'POST',
                url     : url,
                data    :{check_array:check_array,page_type:page_type},
                success: function(response){
                    $(".se-pre-con").fadeOut("slow");
                    window.open(hiddenurl+'multiple_print/'+response, '_blank');
                }
            });
        }
        else{
            $(".se-pre-con").fadeOut("slow");
            alert("Please Select Order..");
        }
    });



    
    $( document ).delegate('#print_shipment_manifest', 'click', function(){
        $(".se-pre-con").fadeIn("slow");
        var active = $("#my_order_details_tab").children(".active").attr("id");
        var check_array = [];
        if (active == 'manifested') {
            var rowcollection = vieworder_tbl1.$(".single_manifested_order:checked", {"page": "all"});
        } else if (active == 'intransit') {
            var rowcollection = vieworder_tbl2.$(".single_intransit_order:checked", {"page": "all"});
        } else if (active == 'receivedatdestination') {
            var rowcollection = vieworder_tbl3.$(".single_receivedatdestination_order:checked", {"page": "all"});
        } else if (active == 'diapatched') {
            var rowcollection = vieworder_tbl4.$(".single_diapatched_order:checked", {"page": "all"});
        } else if (active == 'delivered') {
            var rowcollection = vieworder_tbl5.$(".single_delivered_order:checked", {"page": "all"});
        } else if (active == 'cancellorder') {
            var rowcollection = vieworder_tbl6.$(".single_cancellorder_order:checked", {"page": "all"});
        } else if (active == 'notpicked') {
            var rowcollection = vieworder_tbl7.$(".single_notpicked_order:checked", {"page": "all"});
        } 
        rowcollection.each(function(index,elem){
            check_array.push($(elem).val());
        });
        var url = hiddenurl+'order/multiple_manifest';

        if(check_array.length > 0){
            $.ajax({
                type    : 'POST',
                url     : url,
                data    :{check_array:check_array},
                success: function(response){
                    $(".se-pre-con").fadeOut("slow");
                    window.open(hiddenurl+'multiple_manifest/'+response, '_blank');
                }
            });
        }
        else{
            $(".se-pre-con").fadeOut("slow");
            alert("Please Select Order..");
        }
    });
});
/**
 * Js by Unnati ends
 */