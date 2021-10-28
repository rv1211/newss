/**
 * Js By Unnati start
 */

var hiddenurl = $('#hiddenUrl').val();
$(document).ready(function () {
	$("#reload").click(function () {
		var url = hiddenurl + 'Home/refresh_captcha';
		$.ajax({
			url: url,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function (response) {
				$("#captchaimage").html(response.captchaimage);
				$("#captcha_word").val(response.captcha_word);
			}
		});

	});
});
$(function () {

	$(document).delegate('#order_type', 'change', function () {
		var ordertype = $('#order_type').children(':selected').val();
		if (ordertype == 'cod') {
			$('#cod_amount_div').show();
		} else {
			$('#cod_amount_div').hide();
		}
	});

	//calculation for volume weight
	$('#ship_length,#ship_width,#ship_height').on('change', function () {
		var ship_length = $('#ship_length').val();
		var ship_width = $('#ship_width').val();
		var ship_height = $('#ship_height').val();
		var total = ((ship_length * ship_width * ship_height) / 5000);
		$('#calculate_vol_weight').val(total);
	});

	var fetchOrdertype = hiddenurl + 'Home/fetchordertype';
	$(document).delegate('#pincode', 'change', function () {
		var pincode = $('#pincode').val();
		$(".se-pre-con").fadeIn("slow");
		$.ajax({
			url: fetchOrdertype,
			type: "post",
			data: {
				pincode: pincode
			},
			success: function (data) {
				var message = $.parseJSON(data);
				$.each(message, function (index, value) {
					if (index == 'resultdata') {
						key1 = value;
					} else if (index == 'city') {
						key2 = value;
					} else if (index == 'state') {
						key3 = value;
					}
				});
				$(".se-pre-con").fadeOut("slow");
				if (key1 == 'codandprepaid') {
					$('#order_type').append('<option selected="" value="">Select Order Type</option><option value="cod">COD</option><option value="prepaid">Prepaid</option>');
					$('#city').val(key2);
					$('#state').val(key3);
				} else if (key1 == 'prepaid') {
					$('#order_type').append('<option selected="" value="">Select Order Type</option><option value="prepaid">Prepaid</option>');
					$('#city').val(key2);
					$('#state').val(key3);
				} else if (key1 == 'cod') {
					$('#order_type').append('<option selected="" value="">Select Order Type</option><option value="cod">COD</option>');
					$('#city').val(key2);
					$('#state').val(key3);
				} else if (key1 == 'nodata') {
					$("#result_error_message").fadeIn("slow").html('Delivery does not serve in this pincode.');
					setTimeout(function () {
						$("#result_error_message").fadeOut("slow");
					}, 7000);
					$('#order_type').append('');
					$('#city').val(key2);
					$('#state').val(key3);
				}
			}
		});
	});
	$(document).delegate('#pickuppincode', 'change', function () {
		var pincode = $('#pickuppincode').val();
		$(".se-pre-con").fadeIn("slow");
		$.ajax({
			url: fetchOrdertype,
			type: "post",
			data: {
				pincode: pincode
			},
			success: function (data) {
				var message = $.parseJSON(data);
				$.each(message, function (index, value) {
					if (index == 'city') {
						key1 = value;
					} else if (index == 'state') {
						key2 = value;
					}
				});
				$(".se-pre-con").fadeOut("slow");
				$('#pickupcity').val(key1);
				$('#pickupstate').val(key2);
			}
		});
	});

	var addShippingPrice = hiddenurl + 'home/add_shipping_charge';
	$('#get_price_old').on('click', function () {
		var pincode = $('#pincode').val();
		var state = $('#state').val();
		var city = $('#city').val();
		var customer_address1 = $('#customer_address1').val();
		var customer_address2 = $('#customer_address2').val();
		var pickuppincode = $('#pickuppincode').val();
		var pickupstate = $('#pickupstate').val();
		var pickupcity = $('#pickupcity').val();
		var pickupcustomer_address1 = $('#pickupcustomer_address1').val();
		var pickupcustomer_address2 = $('#pickupcustomer_address2').val();
		var phy_weight = $('#phy_weight').val();
		var type_of_shipment = $('#type_of_shipment').val();
		var pickup_address = $('#pickup_address').val();
		var order_type = $('#order_type').val();
		var cod_amount = $('#cod_amount').val();


		if (pickuppincode == "") {
			$('#pickuppincode').parent().parent().parent().find('span.error').html('');
			$('#pickuppincode').parent().find('span.error').html('Enter Pincode');
			return false;
		}
		if (pickupstate == "") {
			$('#pickupstate').parent().parent().parent().find('span.error').html('');
			$('#pickupstate').parent().find('span.error').html('Enter State');
			return false;
		}
		if (pickupcity == "") {
			$('#pickupcity').parent().parent().parent().find('span.error').html('');
			$('#pickupcity').parent().find('span.error').html('Enter City');
			return false;
		}
		if (pickupcustomer_address1 == "") {
			$('#pickupcustomer_address1').parent().parent().parent().find('span.error').html('');
			$('#pickupcustomer_address1').parent().find('span.error').html('Enter Address1');
			return false;
		}
		if (pincode == "") {
			$('#pincode').parent().parent().parent().find('span.error').html('');
			$('#pincode').parent().find('span.error').html('Enter Pincode');
			return false;
		}
		if (state == "") {
			$('#state').parent().parent().parent().find('span.error').html('');
			$('#state').parent().find('span.error').html('Enter State');
			return false;
		}
		if (city == "") {
			$('#city').parent().parent().parent().find('span.error').html('');
			$('#city').parent().find('span.error').html('Enter City');
			return false;
		}
		if (customer_address1 == "") {
			$('#customer_address1').parent().parent().parent().find('span.error').html('');
			$('#customer_address1').parent().find('span.error').html('Enter Address1');
			return false;
		}
		if (phy_weight == "") {
			$('#phy_weight').parent().parent().parent().find('span.error').html('');
			$('#phy_weight').parent().find('span.error').html('Enter physical Weight');
			return false;
		}
		if (type_of_shipment == "") {
			$('#type_of_shipment').parent().parent().parent().find('span.error').html('');
			$('#type_of_shipment').parent().find('span.error').html('Please select atleast one');
			return false;
		}
		if (order_type == "") {
			$('#order_type').parent().parent().parent().find('span.error').html('');
			$('#order_type').parent().find('span.error').html('Please select atleast one');
			return false;
		}
		if (order_type == "cod") {
			if (cod_amount == "0") {
				$('#cod_amount').parent().parent().parent().find('span.error').html('');
				$('#cod_amount').parent().find('span.error').html('Enter COD Charge');
				return false;
			}
		}

		if (phy_weight != '' && type_of_shipment != '' && pincode != '' && state != '' && city != '' && customer_address1 != '' && pickuppincode != '' && pickupstate != '' && pickupcity != '' && pickupcustomer_address1 != '') {

			$(".se-pre-con").fadeIn("slow");
			$.ajax({
				url: addShippingPrice,
				type: "post",
				data: {
					pickuppincode: pickuppincode,
					pickupstate: pickupstate,
					pickupcity: pickupcity,
					pickupcustomer_address1: pickupcustomer_address1,
					pickupcustomer_address2: pickupcustomer_address2,
					pincode: pincode,
					state: state,
					city: city,
					customer_address1: customer_address1,
					customer_address2: customer_address2,
					phy_weight: phy_weight,
					type_of_shipment: type_of_shipment,
					order_type: order_type,
					cod_amount: cod_amount
				},
				success: function (data) {
					$(".se-pre-con").fadeOut("slow");
					var message = $.parseJSON(data);
					$.each(message, function (index, value) {
						if (index == 'result') {
							key1 = value;
						} else if (index == 'error') {
							key2 = value;
						} else if (index == 'gst_charge') {
							key3 = value;
						} else if (index == 'total_charge') {
							key4 = value;
						}
					});
					if (key2 == 'error') {
						//console.log(key2);
						$("#result_error_message").fadeIn("slow").html('Distance not found.');
						setTimeout(function () {
							$("#result_error_message").fadeOut("slow");
							//location.reload();
						}, 1000);
						$('.shipp_rate').html('Rs.' + key1);
						$('.total_gst').html('Rs.' + key3);
						$('.total_rate').html('Rs.' + key4);
						$('#shipping_charge').val(key4);
						$('#order-submit').prop('disabled', true);
					} else {
						$('.shipp_rate').html('Rs.' + key1);
						$('.total_gst').html('Rs.' + key3);
						$('.total_rate').html('Rs.' + key4);
						$('#shipping_charge').val(key4);
						$('#order-submit').prop('disabled', false);
					}
				}
			});
		}
	});


	$("#get_price").on("click", function () {
		$(".se-pre-con").fadeIn("slow");
		var pickup_pincode = $('#pickup_pincode').val();
		var receive_pincode = $('#receive_pincode').val();
		var physical_weight = $('#physical_weight').val();
		var priceurl = hiddenurl + 'Home/price_get';
		if (pickup_pincode == "") {
			$('#pickup_pincode').parent().parent().parent().find('span.error').html('');
			$('#pickup_pincode').parent().find('span.error').html('Enter Pickup Pincode');
			$(".se-pre-con").fadeOut("slow");
			return false;
		} else if (receive_pincode == "") {
			$('#receive_pincode').parent().parent().parent().find('span.error').html('');
			$('#receive_pincode').parent().find('span.error').html('Enter Receive Pincode');
			$(".se-pre-con").fadeOut("slow");
			return false;
		} else if (physical_weight == "") {
			$('#physical_weight').parent().parent().parent().find('span.error').html('');
			$('#physical_weight').parent().find('span.error').html('Enter Physical Weight');
			$(".se-pre-con").fadeOut("slow");
			return false;
		}
		if (pickup_pincode != "" && receive_pincode != "" && physical_weight != "") {
			$.ajax({
				url: priceurl,
				type: "post",
				data: {
					pickup_pincode: pickup_pincode,
					receive_pincode: receive_pincode,
					physical_weight: physical_weight
				},
				dataType: 'json',
				success: function (response) {
					$(".se-pre-con").fadeOut("slow");
					if (response.error === "") {
						// $("#price_show").show();
						// $('#table_data').html(response.result);
						console.log(response);
						$('#getpriceModal').modal('show');
						$('.modal-body').html(response.result);
						// $('#total_gst').html(response.gst_charge);
						// $('#total_summary').html(response.total_charge);
					} else {
						// $("#price_show").hide();
						$("#result_error_message").fadeIn("slow").html(response.error);
						setTimeout(function () {
							$("#result_error_message").fadeOut("slow");
						}, 4000);
					}
				}
			});
		}
	});


	/*$("#create_order_test").on("click", function(){
	    var id = 1;
	    var orderurl1 = hiddenurl+'admin/add_demo';
	    $.ajax({
	        url     : orderurl1,
	        type: "post",
	        data: {id:id},
	        dataType  : 'HTML',
	        processData: false,
	        contentType: false,
	        success: function(response){
	          //console.log('response');
	            $('.modal-content').html(response);
	        }
	    });
	});*/

	$('#create_order_test').click(function () {

		var userid = 1;
		var orderurl1 = hiddenurl + 'admin/add_demo';

		// AJAX request
		$.ajax({
			url: orderurl1,
			type: 'post',
			data: {
				userid: userid
			},
			success: function (response) {
				// Add response in Modal body
				$('.modal-body').html(response);

				// Display Modal
				$('#empModal').modal('show');
				//$("#empModal").dialog("open");
			}
		});
	});


	$('.legitRipple').click(function () {
		$(".se-pre-con").fadeIn("slow");
		var datatarget = $(this).data('target');
		if (datatarget == '#intransit_tab') {
			$(".se-pre-con").fadeOut("slow");
			$('#intransit_tab').css('display', 'block');
			$('#manifested_tab,#receivedatdestination_tab,#dispatched_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab').css('display', 'none');
		}
		if (datatarget == '#manifested_tab') {
			$(".se-pre-con").fadeOut("slow");
			$('#manifested_tab').css('display', 'block');
			$('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab').css('display', 'none');
		}
		if (datatarget == '#receivedatdestination_tab') {
			$(".se-pre-con").fadeOut("slow");
			$('#receivedatdestination_tab').css('display', 'block');
			$('#intransit_tab,#manifested_tab,#dispatched_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab').css('display', 'none');
		}
		if (datatarget == '#dispatched_tab') {
			$(".se-pre-con").fadeOut("slow");
			$('#dispatched_tab').css('display', 'block');
			$('#intransit_tab,#receivedatdestination_tab,#manifested_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab').css('display', 'none');
		}
		if (datatarget == '#delivered_tab') {
			$(".se-pre-con").fadeOut("slow");
			$('#delivered_tab').css('display', 'block');
			$('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#cancellorder_tab,#not_picked_tab').css('display', 'none');
		}
		if (datatarget == '#cancellorder_tab') {
			$(".se-pre-con").fadeOut("slow");
			$('#cancellorder_tab').css('display', 'block');
			$('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#delivered_tab,#not_picked_tab').css('display', 'none');
		}
		if (datatarget == '#not_picked_tab') {
			$(".se-pre-con").fadeOut("slow");
			$('#not_picked_tab').css('display', 'block');
			$('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#delivered_tab,#cancellorder_tab').css('display', 'none');
		}
	});

	$('.select_amount').click(function () {
		var amount = $(this).attr('amount');
		$('#input_amount').val(amount);
	});

	var fetchReportdata = hiddenurl + 'admin/fetchreportdata';
	$('#report_duration').on('change', function () {
		$(".se-pre-con").fadeIn("slow");
		var days = $('#report_duration').val();
		$.ajax({
			url: fetchReportdata,
			type: "post",
			data: {
				days: days
			},
			success: function (data) {

				var message = $.parseJSON(data);
				$.each(message, function (index, value) {
					if (index == 'manifested_count') {
						key1 = value;
					} else if (index == 'intransit_count') {
						key2 = value;
					} else if (index == 'delivered_count') {
						key3 = value;
					}
				});

				//console.log(data);
				$(".se-pre-con").fadeOut("slow");
				$('#total_manifested').html(key1);
				$('#total_intransit').html(key2);
				$('#total_delivered').html(key3);
			}
		});
	});

	$('.order-details').click(function () {
		var order_id = $(this).attr('id');
		var button_type = $(this).attr('attr-btntype');
		var tab_style = '';
		var tabtype = $(this).attr('attr-tabtype');
		if (button_type == 'order_detail') {
			tab_style = 'display:block';
		}
		var orderdetailurl = hiddenurl + 'admin/order_detail_modal';

		// AJAX request
		$.ajax({
			url: orderdetailurl,
			type: 'post',
			data: {
				order_id: order_id,
				button_type: button_type,
				tab_style: tab_style,
				tabtype: tabtype
			},
			success: function (response) {
				// Add response in Modal body
				$('.modal-body').html(response);

				// Display Modal
				//$('#empModal').modal('show'); 
				//$("#empModal").dialog("open");
			}
		});

	});





	/*var addKycform = hiddenurl+'admin/insert_kyc_form';
	$('#submit_kyc1223').on('click', function(){
	    var form = $('#kyc_details_form')[0];
	    //console.log($('#kyc_details_form')[0]);
	    var profiletype = $('#profile_type').children(':selected').val();
	    var companytype = $('#company_type').children(':selected').val();
	    var user_name = $('#user_name').val();
	    var company_name = $('#company_name').val();
	    var textPanNo = $('#textPanNo').val();
	    var gst_no = $('#gst_no').val();
	    var document1 = $('#document1').children(':selected').val();
	    var file_name1 = $('#file_name1').val();
	    var document2 = $('#document2').children(':selected').val();
	    var file_name2 = $('#file_name2').val();
	    var file_name3 = $('#file_name3').val();
	    $.ajax({
	        url: addKycform,
	        type: "post",
	        data: new FormData(form),
	        processData: false,
	        contentType: false,
	        //data: {profiletype:profiletype, companytype:companytype, user_name:user_name, company_name:company_name, textPanNo:textPanNo, gst_no:gst_no, document1:document1, file_name1:file_name1, document2:document2, file_name2:file_name2, file_name3:file_name3},
	        success: function (data) {

	          //$(".se-pre-con").fadeOut("slow");
	          if(data == 'success'){
	            $('#step1_div').hide();
	            $('#step2_div').show();
	            $('#result_message').html('Our Sales Team will Contact you Shortly.').show();
	            // setTimeout(function() {
	            //   $("#result_message").fadeOut("slow");
	            //   location.reload(true);
	            // }, 2000);
	          }else{
	              $('#result_error').html('Something went wrong, try again later').show();
	              // setTimeout(function() {
	              //   $("#result_error").fadeOut("slow");
	              //   location.reload(true);
	              // }, 2000);
	          }
	        }
	      });

	});*/


});





/**
 * Js by Unnati ends
 */




















//file upload start
