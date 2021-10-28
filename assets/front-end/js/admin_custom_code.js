/**
 * Js By Unnati start
 */
$(function () {
	var hiddenurl = $('#hiddenUrl').val();
	var str1 = $(location).attr("href");
	var str2 = "create-order";

	$('#profile_type').on('change', function () {
		var profiletype = $('#profile_type').children(':selected').val();
		if (profiletype == 'company') {
			$('#company_type_div').show();
			$('#company_name_div').show();
			$('#gst_no').attr("required", true);
		} else {
			$('#company_type_div').hide();
			$('#company_name_div').hide();
			$('#gst_no').attr("required", false);
		}
	});

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
		// $(".se-pre-con").fadeIn("slow");
		var ship_length = $('#ship_length').val();
		var ship_width = $('#ship_width').val();
		var ship_height = $('#ship_height').val();
		var total = ((ship_length * ship_width * ship_height) / 5000);
		$('#calculate_vol_weight').val(total.toFixed(2));
		// $(".se-pre-con").fadeOut("slow");
	});

	$(document).delegate('#warehouse_pincode', 'change', function () {
		var fetchpincodeavailablity = hiddenurl + 'admin/fetchpincodeavailablity';
		var pincode = $('#warehouse_pincode').val();
		$(".se-pre-con").fadeIn("slow");
		$.ajax({
			url: fetchpincodeavailablity,
			type: "post",
			data: {
				pincode: pincode
			},
			dataType: "json",
			success: function (data) {
				$(".se-pre-con").fadeOut("slow");
				if (data.resultdata == 'nodata') {
					if (str1.indexOf(str2) != -1) {
						$("#result_error_message_popup").fadeIn("slow").html('Pickup does not serve in this pincode.');
						setTimeout(function () {
							$("#result_error_message_popup").fadeOut("slow");
						}, 5000);
					} else {
						$("#result_error_message").fadeIn("slow").html('Pickup does not serve in this pincode.');
						setTimeout(function () {
							$("#result_error_message").fadeOut("slow");
						}, 5000);
					}
					$('.add_pickup').prop('disabled', true);
					$('#edit_pickup').prop('disabled', true);
					$('#warehouse_city').val(data.city);
					$('#warehouse_state').val(data.state);
				} else {
					$('#warehouse_city').val(data.city);
					$('#warehouse_state').val(data.state);
					$('.add_pickup').prop('disabled', false);
					$('#edit_pickup').prop('disabled', false);
				}
			}
		});
	});
	$("#warehouse_pincode").filter(function () {
		var fetchpincodeavailablity = hiddenurl + 'admin/fetchpincodeavailablity';
		var pincode = $('#warehouse_pincode').val();
		if (pincode != "") {
			$(".se-pre-con").fadeIn("slow");
			$.ajax({
				url: fetchpincodeavailablity,
				type: "post",
				data: {
					pincode: pincode
				},
				dataType: "json",
				success: function (data) {
					$(".se-pre-con").fadeOut("slow");
					if (data.resultdata == 'nodata') {
						$("#result_error_message").fadeIn("slow").html('Pickup does not serve in this pincode.');
						setTimeout(function () {
							$("#result_error_message").fadeOut("slow");
						}, 5000);
						$('#edit_pickup').prop('disabled', true);
						$('#warehouse_city').val(data.city);
						$('#warehouse_state').val(data.state);
					} else {
						$('#warehouse_city').val(data.city);
						$('#warehouse_state').val(data.state);
						$('#edit_pickup').prop('disabled', false);
					}
				}
			});
		}
	});
	$(document).delegate("#add_pickup,#add_pickup_from_create_order", "click", function () {
		var add_url = hiddenurl + 'admin/insert_pickup_address';
		var addPickupaddress = hiddenurl + "admin/check_duplicate_name";
		var data_from = $(this).data('from');
		var form = $('#pickup_address_form')[0];
		$('#pickup_address_form').validate({
			rules: {
				warehouse_name: {
					required: true,
					remote: {
						url: addPickupaddress,
						type: "post"
					}
				},
				warehouse_contact_person: {
					required: true
				},
				warehouse_contact_no: {
					required: true,
					number: true,
					maxlength: 10
				},
				warehouse_email: {
					required: true,
					email: true
				},
				warehouse_address_1: {
					required: true
				},
				warehouse_pincode: {
					required: true,
					number: true
				},
				state: {
					required: true
				},
				city: {
					required: true
				}
			},
			errorElement: 'span',
			focusInvalid: true,
			ignore: ".ignore",
			messages: {
				warehouse_name: {
					required: "Please Enter a Name.",
					remote: "Warehouse Name Already exists"
				},
				warehouse_contact_person: {
					required: "Please Enter contact person name"
				},
				warehouse_contact_no: {
					required: "Please Enter a contact No",
					number: "Please Enter Number only",
					maxlength: "You can enter only 10 characters"
				},
				warehouse_email: {
					required: "Please Enter an email",
					email: "Enter valid email id"
				},
				warehouse_address_1: {
					required: "Please Enter a address1"
				},
				warehouse_pincode: {
					required: "Please Enter a pincode",
					number: "Please Enter numbers only"
				},
				state: {
					required: "Please Enter a state"
				},
				city: {
					required: "Please Enter a city"
				},
			},
		});
		if ($("#pickup_address_form").valid()) {
			$(".se-pre-con").fadeOut("slow");
			$.ajax({
				url: add_url,
				type: "post",
				data: new FormData(form),
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function (response) {
					if (response.success != "" && response.pickup_id != "") {
						$(".se-pre-con").fadeOut("slow");
						if (str1.indexOf(str2) != -1) {
							$("#add_pickup_from_create_order").prop('disabled', true);
							$('#PickupAddressModal').modal('hide');
							$('.create_order_pickup_address').append('<option value="' + response.pickup_id + '" selected>' + response.address + '</option>');
							$("#result_message").fadeIn("slow").html(response.success);
							setTimeout(function () {
								$("#result_message").fadeOut("slow");
							}, 5000);
							//create order code
						} else {
							$("#add_pickup").prop('disabled', true);
							$("#result_message").fadeIn("slow").html(response.success);
							setTimeout(function () {
								$("#result_message").fadeOut("slow");
								if (response.is_approved == 1) {
									window.location.href = hiddenurl + 'list-pickup-address';
								} else {
									window.location.href = hiddenurl + 'approve-pending';
								}
							}, 5000);
							//add pickup address code
						}
					} else if (response.error != "") {
						$(".se-pre-con").fadeOut("slow");
						if (str1.indexOf(str2) != -1) {
							$("#result_error_message_popup").fadeIn("slow").html(response.error);
							setTimeout(function () {
								$("#result_error_message_popup").fadeOut("slow");
							}, 5000);
						} else {
							$("#result_error_message").fadeIn("slow").html(response.error);
							setTimeout(function () {
								$("#result_error_message").fadeOut("slow");
							}, 5000);
						}
					}
				}
			});
		} else {
			$(".se-pre-con").fadeOut("slow");
			return false;
		}
	});

	var fetchOrdertype = hiddenurl + 'order/fetchcitystate';
	$(document).delegate('#pincode', 'change', function () {
		$('#city').val();
		$('#state').val();
		var pincode = $('#pincode').val();
		$(".se-pre-con").fadeIn("slow");
		$.ajax({
			url: fetchOrdertype,
			type: "post",
			data: {
				pincode: pincode
			},
			dataType: "json",
			success: function (data) {
				$(".se-pre-con").fadeOut("slow");
				$('#city').val(data.city);
				$('#state').val(data.state);
				if (data.city != "" && data.city != null) {
					$('#city').prop('readonly', true);
				} else {
					$('#city').prop('readonly', false);
				}
				if (data.state != "" && data.state != null) {
					$('#state').prop('readonly', true);
				} else {
					$('#state').prop('readonly', false);
				}
			}
		});
	});
	$(document).delegate('#return_pincode', 'change', function () {
		$('#return_city').val();
		$('#return_state').val();
		var pincode = $('#return_pincode').val();
		$(".se-pre-con").fadeIn("slow");
		$.ajax({
			url: fetchOrdertype,
			type: "post",
			data: {
				pincode: pincode
			},
			dataType: "json",
			success: function (data) {
				$(".se-pre-con").fadeOut("slow");
				$('#return_city').val(data.city);
				$('#return_state').val(data.state);
				if (data.city != "") {
					$('#return_city').prop('readonly', true);
				} else {
					$('#return_city').prop('readonly', false);
				}
				if (data.state != "") {
					$('#return_state').prop('readonly', true);
				} else {
					$('#return_state').prop('readonly', false);
				}
			}
		});
	});
	// $(document).delegate("#product_mrp", "keyup", function(){
	//     $('#cod_amount').val($('#product_mrp').val());
	// });
	$('#get_price').on('click', function () {
		var addShippingPrice = hiddenurl + 'order/get_shipping_charge';
		var pincode = $('#pincode').val();
		var state = $('#state').val();
		var city = $('#city').val();
		var customer_address1 = $('#customer_address1').val();
		var customer_address2 = $('#customer_address2').val();
		var physical_weight = $('#phy_weight').val();
		var type_of_shipment = $('#type_of_shipment').val();
		var pickup_address = $('#pickup_address').val();
		var order_type = $('#order_type').val();
		var cod_amount = $('#cod_amount').val();
		var ship_length = $('#ship_length').val();
		var ship_width = $('#ship_width').val();
		var ship_height = $('#ship_height').val();
		var calculate_vol_weight = (parseFloat(ship_length) * parseFloat(ship_width) * parseFloat(ship_height)) / 5000;
		var phy_weight = '0';

		// if (calculate_vol_weight > physical_weight) { phy_weight = calculate_vol_weight;}
		// else if (physical_weight > calculate_vol_weight) { phy_weight = physical_weight;}
		// else{phy_weight = physical_weight;}

		if (pickup_address == "") {
			$('#pickup_address').parent().parent().parent().find('span.error').html('');
			$('#pickup_address').parent().find('span.error').html('Please select Pickup address');
			$('#pickup_address').focus();
			return false;
		}
		if (pincode == "") {
			$('#pincode').parent().parent().parent().find('span.error').html('');
			$('#pincode').parent().find('span.error').html('Enter Pincode');
			$('#pincode').focus();
			return false;
		}
		if (state == "") {
			$('#state').parent().parent().parent().find('span.error').html('');
			$('#state').parent().find('span.error').html('Enter State');
			$('#state').focus();
			return false;
		}
		if (city == "") {
			$('#city').parent().parent().parent().find('span.error').html('');
			$('#city').parent().find('span.error').html('Enter City');
			$('#city').focus();
			return false;
		}
		if (customer_address1 == "") {
			$('#customer_address1').parent().parent().parent().find('span.error').html('');
			$('#customer_address1').parent().find('span.error').html('Enter Address1');
			$('#customer_address1').focus();
			return false;
		}
		if (ship_length == "") {
			$('#ship_length').parent().parent().parent().find('span.error').html('');
			$('#ship_length').parent().find('span.error').html('Enter ship length');
			$('#ship_length').focus();
			return false;
		}
		if (ship_width == "") {
			$('#ship_width').parent().parent().parent().find('span.error').html('');
			$('#ship_width').parent().find('span.error').html('Enter ship width');
			$('#ship_width').focus();
			return false;
		}
		if (ship_height == "") {
			$('#ship_height').parent().parent().parent().find('span.error').html('');
			$('#ship_height').parent().find('span.error').html('Enter ship height');
			$('#ship_height').focus();
			return false;
		}
		if (physical_weight == "") {
			$('#phy_weight').parent().parent().parent().find('span.error').html('');
			$('#phy_weight').parent().find('span.error').html('Enter physical Weight');
			$('#phy_weight').focus();
			return false;
		}
		if (type_of_shipment == "") {
			$('#type_of_shipment').parent().parent().parent().find('span.error').html('');
			$('#type_of_shipment').parent().find('span.error').html('Please select atleast one');
			$('#type_of_shipment').focus();
			return false;
		}
		if (order_type == "") {
			$('#order_type').parent().parent().parent().find('span.error').html('');
			$('#order_type').parent().find('span.error').html('Please select atleast one');
			$('#order_type').focus();
			return false;
		}
		if (order_type == "cod") {
			if (cod_amount == "0" || cod_amount == "") {
				$('#cod_amount').parent().parent().parent().find('span.error').html('');
				$('#cod_amount').parent().find('span.error').html('Enter COD Charge');
				$('#cod_amount').focus();
				return false;
			}
		}
		var gst_charge = 0;
		var amount = 0;
		if (pickup_address != '' && physical_weight != '' && type_of_shipment != '' && pincode != '' && state != '' && city != '' && customer_address1 != '' && ship_length != '' && ship_width != '' && ship_height != '') {
			$(".se-pre-con").fadeIn("slow");
			$.ajax({
				url: addShippingPrice,
				type: "post",
				data: {
					pincode: pincode,
					state: state,
					city: city,
					customer_address1: customer_address1,
					customer_address2: customer_address2,
					physical_weight: physical_weight,
					type_of_shipment: type_of_shipment,
					pickup_address: pickup_address,
					order_type: order_type,
					cod_amount: cod_amount,
					ship_length: ship_length,
					ship_width: ship_width,
					ship_height: ship_height
				},
				dataType: "json",
				success: function (data) {
					$(".se-pre-con").fadeOut("slow");
					// if (data.pickup_adress_add_in_api_error!="") {
					//     $("#result_error_message").fadeIn("slow").html("Delhivery Logistic available but not showing in your price list due to pickup address creation error in api");
					//     setTimeout(function() {
					//     $("#result_error_message").fadeOut("slow");
					//     }, 7000); 
					// }
					if (data.result != '') {
						$("#graph_div").show();
						$('#price_info').html(data.result);
						$('#gst_charge').val(gst_charge.toFixed(2));
						$('#shipping_charge').val(amount.toFixed(2));
						$('.total_gst').html('Rs.' + gst_charge.toFixed(2));
						$('.total_rate').html('Rs.' + amount.toFixed(2));
						$('#create_order_button').prop('disabled', false);
					} else {
						$("#result_error_message").fadeIn("slow").html(data.error);
						setTimeout(function () {
							$("#result_error_message").fadeOut("slow");
						}, 5000);
						$('#price_info').html(data.result);
						$('#gst_charge').val(gst_charge.toFixed(2));
						$('#shipping_charge').val(amount.toFixed(2));
						$('.total_gst').html('Rs.' + gst_charge.toFixed(2));
						$('.total_rate').html('Rs.' + amount.toFixed(2));
						$('#create_order_button').prop('disabled', true);
					}
				}
			});
		}
	});
	$(document).delegate('.styled', 'click', function () {
		$(".se-pre-con").fadeIn("slow");
		var amount = $(this).data('amount');
		var gst_charge = (parseFloat(amount) * 18) / 100;
		$('#gst_charge').val(gst_charge.toFixed(2));
		$('#shipping_charge').val((parseFloat(amount) + parseFloat(gst_charge)).toFixed(2));
		$('.total_gst').html('Rs.' + gst_charge.toFixed(2));
		$('.total_rate').html('Rs.' + (parseFloat(amount) + parseFloat(gst_charge)).toFixed(2));
		$(".se-pre-con").fadeOut("slow");
	});
	$("#order_type1").filter(function () {
		var addShippingPrice1 = hiddenurl + 'order/fetch_shipping_charge';
		$(".se-pre-con").fadeIn("slow");
		var pincode = $('#pincode').val();
		var state = $('#state').val();
		var city = $('#city').val();
		var customer_address1 = $('#customer_address1').val();
		var customer_address2 = $('#customer_address2').val();
		var warehouse_pincode = $('#warehouse_pincode').val();
		var warehouse_state = $('#warehouse_state').val();
		var warehouse_city = $('#warehouse_city').val();
		var address_1 = $('#address_1').val();
		var address_2 = $('#address_2').val();
		var physical_weight = $('#phy_weight').val();
		var type_of_shipment = $('#type_of_shipment').val();
		var pickup_address = $('#pickup_address').val();
		var order_type = $('#order_type1').val();
		var cod_amount = $('#cod_amount').val();
		var ship_length = $('#ship_length').val();
		var ship_width = $('#ship_width').val();
		var ship_height = $('#ship_height').val();
		var calculate_vol_weight = $('#calculate_vol_weight').val();
		var logistics = $('.styled').val();
		var phy_weight = '0';
		switch (logistics) {
			case "Udaan Express":
				if (((parseFloat(ship_length) * parseFloat(ship_width) * parseFloat(ship_height)) / 5000) > physical_weight) {
					phy_weight = ((parseFloat(ship_length) * parseFloat(ship_width) * parseFloat(ship_height)) / 5000);
				} else {
					phy_weight = physical_weight;
				}
				break;
			default:
				if (((parseFloat(ship_length) * parseFloat(ship_width) * parseFloat(ship_height)) / 5000) > physical_weight) {
					phy_weight = ((parseFloat(ship_length) * parseFloat(ship_width) * parseFloat(ship_height)) / 5000);
				} else {
					phy_weight = physical_weight;
				}
				break;
		}
		// if (calculate_vol_weight > physical_weight) { phy_weight = calculate_vol_weight;}
		// else if (physical_weight > calculate_vol_weight) { phy_weight = physical_weight;}
		// else{phy_weight = physical_weight;}
		var gst_charge = 0;
		var amount = 0;
		$.ajax({
			url: addShippingPrice1,
			type: "post",
			data: {
				pincode: pincode,
				state: state,
				city: city,
				customer_address1: customer_address1,
				customer_address2: customer_address2,
				phy_weight: phy_weight,
				type_of_shipment: type_of_shipment,
				pickup_address: pickup_address,
				order_type: order_type,
				cod_amount: cod_amount,
				warehouse_pincode: warehouse_pincode,
				warehouse_state: warehouse_state,
				warehouse_city: warehouse_city,
				address_1: address_1,
				address_2: address_2,
				logistics: logistics
			},
			dataType: "json",
			success: function (data) {
				switch (logistics) {
					case 'shadowfax':
						if (data.shadowfax_price != 0) {
							$('#shadowfax_rate').html('Rs.' + data.shadowfax_price.toFixed(2));
							var gst_charge1 = (parseFloat(data.shadowfax_price) * 18) / 100;
							$('#gst_charge').val(gst_charge1.toFixed(2));
							$('#shipping_charge').val((parseFloat(data.shadowfax_price) + parseFloat(gst_charge1)).toFixed(2));
							$('.total_gst').html('Rs.' + gst_charge1.toFixed(2));
							$('.total_rate').html('Rs.' + (parseFloat(data.shadowfax_price) + parseFloat(gst_charge1)).toFixed(2));
							$(".se-pre-con").fadeOut("slow");
							$('#create_reverse_order_button').prop('disabled', false);
						}
						break;
					case 'delhivery':
						if (data.dehlivery_price != 0) {
							$('#delhivery_rate').html('Rs.' + data.dehlivery_price.toFixed(2));
							var gst_charge1 = (parseFloat(data.dehlivery_price) * 18) / 100;
							$('#gst_charge').val(gst_charge1.toFixed(2));
							$('#shipping_charge').val((parseFloat(data.dehlivery_price) + parseFloat(gst_charge1)).toFixed(2));
							$('.total_gst').html('Rs.' + gst_charge1.toFixed(2));
							$('.total_rate').html('Rs.' + (parseFloat(data.dehlivery_price) + parseFloat(gst_charge1)).toFixed(2));
							$(".se-pre-con").fadeOut("slow");
							$('#create_reverse_order_button').prop('disabled', false);
						}
						break;
					case 'Xpressbees Lite':
						if (data.xpressbees_lite_price != 0) {
							$('#xpressbees_lite_rate').html('Rs.' + data.xpressbees_lite_price.toFixed(2));
							var gst_charge1 = (parseFloat(data.xpressbees_lite_price) * 18) / 100;
							$('#gst_charge').val(gst_charge1.toFixed(2));
							$('#shipping_charge').val((parseFloat(data.xpressbees_lite_price) + parseFloat(gst_charge1)).toFixed(2));
							$('.total_gst').html('Rs.' + gst_charge1.toFixed(2));
							$('.total_rate').html('Rs.' + (parseFloat(data.xpressbees_lite_price) + parseFloat(gst_charge1)).toFixed(2));
							$(".se-pre-con").fadeOut("slow");
							$('#create_reverse_order_button').prop('disabled', false);
						}
						break;
					case 'Xpressbees Express':
						if (data.xpressbees_express_price != 0) {
							$('#xpressbees_express_rate').html('Rs.' + data.xpressbees_express_price.toFixed(2));
							var gst_charge1 = (parseFloat(data.xpressbees_express_price) * 18) / 100;
							$('#gst_charge').val(gst_charge1.toFixed(2));
							$('#shipping_charge').val((parseFloat(data.xpressbees_express_price) + parseFloat(gst_charge1)).toFixed(2));
							$('.total_gst').html('Rs.' + gst_charge1.toFixed(2));
							$('.total_rate').html('Rs.' + (parseFloat(data.xpressbees_express_price) + parseFloat(gst_charge1)).toFixed(2));
							$(".se-pre-con").fadeOut("slow");
							$('#create_reverse_order_button').prop('disabled', false);
						}
						break;
					case 'DTDC':
						if (data.dtdc_price != 0) {
							$('#dtdc_rate').html('Rs.' + data.dtdc_price.toFixed(2));
							var gst_charge1 = (parseFloat(data.dtdc_price) * 18) / 100;
							$('#gst_charge').val(gst_charge1.toFixed(2));
							$('#shipping_charge').val((parseFloat(data.dtdc_price) + parseFloat(gst_charge1)).toFixed(2));
							$('.total_gst').html('Rs.' + gst_charge1.toFixed(2));
							$('.total_rate').html('Rs.' + (parseFloat(data.dtdc_price) + parseFloat(gst_charge1)).toFixed(2));
							$(".se-pre-con").fadeOut("slow");
							$('#create_reverse_order_button').prop('disabled', false);
						}
						break;
					case 'delhivery express':
						if (data.dehlivery_express_price != 0) {
							$('#delhivery_express_rate').html('Rs.' + data.dehlivery_express_price.toFixed(2));
							var gst_charge1 = (parseFloat(data.dehlivery_express_price) * 18) / 100;
							$('#gst_charge').val(gst_charge1.toFixed(2));
							$('#shipping_charge').val((parseFloat(data.dehlivery_express_price) + parseFloat(gst_charge1)).toFixed(2));
							$('.total_gst').html('Rs.' + gst_charge1.toFixed(2));
							$('.total_rate').html('Rs.' + (parseFloat(data.dehlivery_express_price) + parseFloat(gst_charge1)).toFixed(2));
							$(".se-pre-con").fadeOut("slow");
							$('#create_reverse_order_button').prop('disabled', false);
						}
						break;
					case 'Delhivery Air':
						if (data.dehlivery_air_price != 0) {
							$('#delhivery_air_rate').html('Rs.' + data.dehlivery_air_price.toFixed(2));
							var gst_charge1 = (parseFloat(data.dehlivery_air_price) * 18) / 100;
							$('#gst_charge').val(gst_charge1.toFixed(2));
							$('#shipping_charge').val((parseFloat(data.dehlivery_air_price) + parseFloat(gst_charge1)).toFixed(2));
							$('.total_gst').html('Rs.' + gst_charge1.toFixed(2));
							$('.total_rate').html('Rs.' + (parseFloat(data.dehlivery_air_price) + parseFloat(gst_charge1)).toFixed(2));
							$(".se-pre-con").fadeOut("slow");
							$('#create_reverse_order_button').prop('disabled', false);
						}
						break;
					default:
						$(".se-pre-con").fadeOut("slow");
						$("#result_error_message").fadeIn("slow").html(data.error);
						setTimeout(function () {
							$("#result_error_message").fadeOut("slow");
						}, 5000);
						$('#create_reverse_order_button').prop('disabled', true);
						break;
				}
			}
		});
	});



	$('.legitRipple').click(function () {
		$(".se-pre-con").fadeIn("slow");
		var datatarget = $(this).data('target');
		switch (datatarget) {
			case "#intransit_tab":
				$(".se-pre-con").fadeOut("slow");
				$('#intransit_tab').css('display', 'block');
				$('#manifested_tab,#receivedatdestination_tab,#dispatched_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab,#returned_tab,#notfound_tab').css('display', 'none');
				break;
			case "#manifested_tab":
				$(".se-pre-con").fadeOut("slow");
				$('#manifested_tab').css('display', 'block');
				$('#print_shipment_manifest_div').css('display', 'initial');
				$('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab,#returned_tab,#notfound_tab').css('display', 'none');
				break;
			case "#receivedatdestination_tab":
				$(".se-pre-con").fadeOut("slow");
				$('#receivedatdestination_tab').css('display', 'block');
				$('#intransit_tab,#manifested_tab,#dispatched_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab,#returned_tab,#notfound_tab').css('display', 'none');
				break;
			case "#dispatched_tab":
				$(".se-pre-con").fadeOut("slow");
				$('#dispatched_tab').css('display', 'block');
				$('#intransit_tab,#receivedatdestination_tab,#manifested_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab,#returned_tab,#notfound_tab').css('display', 'none');
				break;
			case "#delivered_tab":
				$(".se-pre-con").fadeOut("slow");
				$('#delivered_tab').css('display', 'block');
				$('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#cancellorder_tab,#not_picked_tab,#returned_tab,#notfound_tab').css('display', 'none');
				break;
			case "#cancellorder_tab":
				$(".se-pre-con").fadeOut("slow");
				$('#cancellorder_tab').css('display', 'block');
				$('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#delivered_tab,#not_picked_tab,#returned_tab,#notfound_tab').css('display', 'none');
				break;
			case "#not_picked_tab":
				$(".se-pre-con").fadeOut("slow");
				$('#not_picked_tab').css('display', 'block');
				$('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#delivered_tab,#cancellorder_tab,#returned_tab,#notfound_tab').css('display', 'none');
				break;
			case "#returned_tab":
				$(".se-pre-con").fadeOut("slow");
				$('#returned_tab').css('display', 'block');
				$('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab,#notfound_tab').css('display', 'none');
				break;
			case "#notfound_tab":
				$(".se-pre-con").fadeOut("slow");
				$('#notfound_tab').css('display', 'block');
				$('#intransit_tab,#receivedatdestination_tab,#dispatched_tab,#manifested_tab,#delivered_tab,#cancellorder_tab,#not_picked_tab,#returned_tab').css('display', 'none');
				break;
			default:
				$(".se-pre-con").fadeOut("slow");
				break;
		}
	});

	$('.select_amount').click(function () {
		var amount = $(this).attr('amount');
		$('#input_amount').val(amount);
	});

	$('#report_duration').on('change', function () {
		var fetchReportdata = hiddenurl + 'admin/fetchreportdata';
		$(".se-pre-con").fadeIn("slow");
		var days = $('#report_duration').val();
		var days_name = $('#report_duration option:selected').text();
		$.ajax({
			url: fetchReportdata,
			type: "post",
			data: {
				days: days
			},
			dataType: "json",
			success: function (data) {
				$(".se-pre-con").fadeOut("slow");
				if (days != 5) {
					$('#temp_panel_title').html(days_name + "'s Report");
				} else {
					$('#temp_panel_title').html(days_name + " Report");
				}

				$('#total_manifested').html(data.manifested_count);
				$('#total_ofp').html(data.ofp_count);
				$('#total_intransit').html(data.intransit_count);
				$('#total_delivered').html(data.delivered_count);
				$('#total_np').html(data.np_count);
				$('#total_rto_intransit').html(data.rto_intransit_count);
				$('#total_rto_delivered').html(data.rto_delivered_count);
			}
		});
	});

	$(document).delegate('.order-details', 'click', function () {
		var orderdetailurl = hiddenurl + 'order/order_detail_modal';
		$('.se-pre-con').fadeIn('slow');
		$('.modal-body').html(" ");
		var order_id = $(this).attr('id');
		var button_type = $(this).attr('attr-btntype');
		var tab_style = '';
		var tabtype = $(this).attr('attr-tabtype');
		if (button_type == 'order_detail') {
			tab_style = 'display:block';
		}
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
				$('.se-pre-con').fadeOut('slow');
				$('.modal-body').html(response);
			}
		});
	});

	/**
	 * Changes by dhara
	 * Rejection Code
	 */
	$('#rejected_btn').on('click', function () {
		$('.se-pre-con').fadeIn('slow');
		var reason = $('#rejected_text').val();
		var email = $('#customer_email').val();
		var CusId = $('#customerId').val();
		if (reason != '') {
			$.ajax({
				url: hiddenurl + "customer/reject_customer_request",
				type: "post",
				data: {
					reason: reason,
					email: email,
					CusId: CusId
				},
				success: function (data) {
					$('.se-pre-con').fadeOut('slow');
					if (data == 'sucess') {
						$('#result_message').html('Mail send Successfully.').show();
						setTimeout(function () {
							$("#result_message").fadeOut("slow");
							window.location.replace(hiddenurl + 'pending-customers');
						}, 2000);
					} else {
						$('#result_error').html('Mail send Failed.').show();
						setTimeout(function () {
							$("#result_error").fadeOut("slow");
							location.reload(true);
						}, 2000);
					}
				}
			});
		} else {
			$('.se-pre-con').fadeOut('slow');
			$('#rejected_text_error').html('This Field is required.');
			return false;
		}
	});

	$('#approve_btn').on('click', function () {
		$('.se-pre-con').fadeIn('slow');
		var email = $('#customer_email').val();
		var CusId = $('#customerId').val();
		$.ajax({
			url: hiddenurl + "customer/approve_customer_request",
			type: "post",
			data: {
				email: email,
				CusId: CusId
			},
			success: function (data) {
				$('.se-pre-con').fadeOut('slow');
				if (data == 'sucess') {
					$('#result_message').html('Mail send Successfully.').show();
					setTimeout(function () {
						$("#result_message").fadeOut("slow");
						window.location.replace(hiddenurl + 'pending-customers');
					}, 2000);
				} else {
					$('#result_error').html('Mail send Failed.').show();
					setTimeout(function () {
						$("#result_error").fadeOut("slow");
						location.reload(true);
					}, 2000);
				}
			}
		});
	});



	$(document).delegate('.active_customer', 'click', function () {
		$('.se-pre-con').fadeIn('slow');
		var cusId = $(this).attr('id');
		var Status = $(this).data('status');
		$.ajax({
			url: hiddenurl + "customer/active_customer",
			type: "post",
			data: {
				cusId: cusId,
				Status: Status
			},
			success: function (data) {
				$('.se-pre-con').fadeOut('slow');
				if (data == 'sucess') {
					$('#result_message').html('Customer Updated Successfully.').show();
					setTimeout(function () {
						$("#result_message").fadeOut("slow");
						location.reload(true);
					}, 2000);
				} else {
					$('#result_error').html('Customer Updated Failed.').show();
					setTimeout(function () {
						$("#result_error").fadeOut("slow");
						location.reload(true);
					}, 2000);
				}
			}
		});
	});


	$(document).delegate('.customer_delete', "click", function () {

		if (confirm("Are You Sure You want to Delete ?")) {
			var cusId = $(this).attr('id');
			$('.se-pre-con').fadeIn('slow');
			$.ajax({
				type: "POST",
				url: "customer/delete_customer",
				data: {
					cusId: cusId
				},
				success: function (response) {
					$('.se-pre-con').fadeOut('slow');
					if (response == 'sucess') {
						$('#result_message').html('Customer Deleted Successfully.').show();
						setTimeout(function () {
							$("#result_message").fadeOut("slow");
							location.reload(true);
						}, 2000);
					} else {
						$('#result_error').html('Customer Delete Failed.').show();
						setTimeout(function () {
							$("#result_error").fadeOut("slow");
							location.reload(true);
						}, 2000);
					}
				}
			});
		}
	});

	// $('.active_customer').on('click', function () {

	// });
});

/**
 * Js by Unnati ends
 */
