$(function () {
	var hiddenurl = $('#hiddenURL').val();
	// Start - create single order form 
	/**
	 *  Create - Order Form
	 */
	$.validator.addMethod("requiredIfChecked", function (val, ele, arg) {
			if ($("input[name='is_return_address_same_as_pickup']:checked").val() == '0' && val == '') {
				return false;
			} else {
				return true;
			};
		},
		"This field is required");
	$.validator.addMethod("OrderType", function (val, ele, arg) {
			if ($("#order_type").val() == 'cod') {
				return false;
			} else {
				return true;
			}
		},
		"This field is required");

	$.validator.addMethod("sellerinfo", function (val, ele, arg) {
			if (($("#seller_info").prop('checked') == true) && val == '') {
				return false;
			} else {
				return true;
			}
		},
		"This field is required");

	//craete order awb
	$("form[name='create_single_name']").validate({
		rules: {
			pickup_address: 'required',
			shipment_type: 'required',
			logistic: 'required',
			awbno: {
				required: true,
				number: true,
				min: 0
			},
			shippingcharge: {
				required: true,
				number: true,
				min: 0
			},
			pincode: {
				required: true,
				number: true,
				min: 0
			},
			state: 'required',
			city: 'required',
			customer_name: 'required',
			customer_mobile: {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 15
			},
			customer_address1: 'required',
			length: {
				required: true,
				number: true,
				min: 0
			},
			width: {
				required: true,
				number: true,
				min: 0
			},
			height: {
				required: true,
				number: true,
				min: 0
			},
			physical_width: {
				required: true,
				number: true,
				min: 0
			},
			product_value: {
				required: true,
				number: true,
				min: 0
			},
			product_name: 'required',
			product_qty: {
				required: true,
				number: true,
				min: 0
			},
			order_type: 'required',

			package_count: {
				required: true,
				number: true,
				min: 0
			},
			reseller_name: {
				sellerinfo: true
			},
			is_return_address_same_as_pickup: 'required',
			collectable_amount: {
				OrderType: true
			},
			return_pincode: {
				requiredIfChecked: true,
				number: true
			},
			return_state: {
				requiredIfChecked: true,
			},
			return_city: {
				requiredIfChecked: true
			},
			return_name: {
				requiredIfChecked: true
			},
			return_mobile_no: {
				requiredIfChecked: true,
				number: true,
				minlength: 10,
				maxlength: 15
			},
			return_address1: {
				requiredIfChecked: true
			},

		},
		messages: {
			pickup_address: 'This Field is required',
			shipment_type: 'This Field is required',
			logistic: 'This Field is required',
			shippingcharge: {
				required: 'This Field is required',
				number: 'You can enter only numbers',
				min: 'You can enter only positive value'
			},
			awbno: {
				required: 'This Field is required',
				number: 'You can enter only numbers',
				min: 'You can enter only positive value'
			},
			pincode: {
				required: 'This Field is required',
				number: 'You can enter only numbers',
				min: 'You can enter only positive value'
			},
			state: 'This Field is required',
			city: 'This Field is required',
			customer_name: 'This Field is required',
			customer_mobile: {
				required: 'This Field is required',
				number: 'You can enter only numbers',
				minlength: 'You can not enter less than 10 digits ',
				maxlength: 'You can not enter more than 10 digits'
			},
			customer_address1: 'This Field is required',
			length: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			width: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			height: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			physical_width: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			product_value: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			product_name: 'This Field is required',
			product_qty: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			order_type: 'This Field is required',

			package_count: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			reseller_name: 'This Field is required',
			is_return_address_same_as_pickup: 'This Field is required',
			//collectable_amount: 'This Field is required'
			// return_pincode: "This field is required"
		},
		submitHandler: function (form) {
			form.submit();
			$("#create_single_name").attr("disabled", true);
			$("#awb_order_btn").attr("enabled", true);
		}
	});

	/**
	 * Create Simple Order
	 */
	$("form[name='create_single_order']").validate({
		rules: {
			pickup_address: 'required',
			shipment_type: 'required',
			pincode: {
				required: true,
				number: true,
				min: 0
			},
			state: 'required',
			city: 'required',
			customer_name: 'required',
			customer_mobile: {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 15
			},
			customer_address1: 'required',
			length: {
				required: true,
				number: true,
				min: 0
			},
			width: {
				required: true,
				number: true,
				min: 0
			},
			height: {
				required: true,
				number: true,
				min: 0
			},
			physical_width: {
				required: true,
				number: true,
				min: 0
			},
			product_value: {
				required: true,
				number: true,
				min: 0
			},
			order_number: 'required',
			product_name: 'required',
			product_qty: {
				required: true,
				number: true,
				min: 0
			},
			order_type: 'required',
			//quantity: 'required',
			package_count: {
				required: true,
				number: true,
				min: 0
			},
			reseller_name: {
				sellerinfo: true
			},
			//     is_return_address_same_as_pickup: 'required',
			//     return_pincode: { requiredIfChecked: true, number: true },
			//     return_state: { requiredIfChecked: true },
			//     return_city: { requiredIfChecked: true },
			//     return_name: { requiredIfChecked: true },
			//     return_mobile_no: {
			//         requiredIfChecked: true,
			//         number: true,
			//         minlength: 10,
			//         maxlength: 15
			//     },
			//     return_address1: { requiredIfChecked: true },
		},
		messages: {
			pickup_address: 'This Field is required',
			shipment_type: 'This Field is required',
			pincode: {
				required: 'This Field is required',
				number: 'You can enter only numbers',
				min: 'You can enter only positive value'
			},
			state: 'This Field is required',
			city: 'This Field is required',
			customer_name: 'This Field is required',
			customer_mobile: {
				required: 'This Field is required',
				number: 'You can enter only numbers',
				minlength: 'You can not enter less than 10 digits ',
				maxlength: 'You can not enter more than 10 digits'
			},
			customer_address1: 'This Field is required',
			length: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			width: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			height: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			physical_width: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			product_value: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			order_number: 'This Field is required',
			product_name: 'This Field is required',
			product_qty: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			order_type: 'This Field is required',

			package_count: {
				required: 'This Field is required',
				number: 'Enter numbers only',
				min: 'Enter only positive value'
			},
			reseller_name: 'This Field is required'
			// is_return_address_same_as_pickup: 'This Field is required'
		},
		submitHandler: function (form) {
			form.submit();
			$("#create_single_order").attr("disabled", true);
		}
	});

	// change pickup address select No
	//@return show return address
	$(document).on('change', '.pickup_address', function () {
		var pick_address = $(this).val();
		if (pick_address == '0') {
			$('#return_address').show();
		} else {
			$('#return_address').hide();
		}
	});


	// change length,width and height 
	//@return total of volumetric weight

	$('#length,#width,#height').on('change', function () {
		$(".se-pre-con").fadeIn("slow");
		var length = $('#length').val();
		var width = $('#width').val();
		var height = $('#height').val();
		var total = ((length * width * height) / 5000);
		$('#volumetric_weight').val(total.toFixed(2));
		$(".se-pre-con").fadeOut("slow");
	});

	// change order type
	// @return show collectable amount

	$(document).delegate('#order_type', 'change', function () {

		var ordertype = $(this).children(':selected').val();
		if (ordertype == 1) {
			$('#cod_amount_div').show();
		} else {
			$('#cod_amount_div').hide();
		}
	});

	//bugfix js
	$('#pickupaddress,#order_type').change(function () {
		$(".ship_div").hide();
		$("#create_order_button").prop('disabled', true);
	});
	$('#pincode,#length,#width,#height,#volumetric_weight,#physical_width,#cod_amount,#Product_Value,#Product_Quantity').keyup(function () {
		$(".ship_div").hide();
		$("#create_order_button").prop('disabled', true);
	});

	$('#pickupaddress,#order_type').change(function () {
		// alert("change");
		$("#order_btn").hide();
	});
	$('#pincode,#length,#width,#height,#volumetric_weight,#physical_width,#cod_amount,#Product_Value,#Product_Quantity').keyup(function () {
		// alert("change");
		$("#order_btn").hide();
	});
	// change Seller Info for Packing Slip 
	// @retun disable Reseller Name

	$('#seller_info').on('change', function () {
		var seller_info = $(this).prop('checked');

		if (seller_info == true) {
			$("#reseller_name").attr('readonly', false);
		} else {
			$("#reseller_name").attr('readonly', true);
		}
	});

	//get state and city on pinocode

	$(document).delegate('.pincode_class', 'change', function () {
		var pincode_data = $(this).val();
		var pincode = $(this);
		if (pincode_data != "") {
			$.ajax({
				type: "POST",
				url: hiddenurl + "Orderawb/get_pincode",
				data: {
					pincode_data: pincode_data
				},
				success: function (response) {
					var data = response.replace(/\r?\n|\r/g, '');
					var obj = $.parseJSON(data);
					if (obj.error) {
						$('#pincode-not-error').html('pincode not available');
					} else {
						$('#pincode-not-error').html('');
						pincode.parent().parent().parent().find('.state').val(obj.state);
						pincode.parent().parent().parent().find('.city').val(obj.city);
					}
				}
			});
		}

	});

	//calculate collecteble amount
	$(document).delegate('#order_type,#Product_Quantity,#Product_Value', 'change', function () {
		var orderType = $('#order_type').val();
		if (orderType == '1') {
			var pro_val = $('#Product_Value').val();
			var pro_qty = $('#Product_Quantity').val();
			var collectable_amt = pro_val * pro_qty;
			if (collectable_amt != "") {
				$('#collectable_amount').val(collectable_amt);
			}
		}
	});

	//get duplicate awb number
	$(document).delegate('.airwaybill_number,#order_type', 'change', function () {
		var awb_no = $('.airwaybill_number').val();
		var ordertype = $('#order_type').val();
		if (awb_no && ordertype != "") {
			$.ajax({
				type: "POST",
				url: hiddenurl + "Orderawb/get_duplicate_awbno",
				data: {
					awb_no: awb_no,
					ordertype: ordertype
				},
				success: function (data) {
					if (data == 'error') {
						$("#order_btn").prop('disabled', true);
						$('#awb_order_btn').prop('disabled', true);
						// $("#order_btn").attr("disabled", true);
						$('#awb_number').html('Airwaybill not available ..');
					} else {
						var obj = $.parseJSON(data);
						$('#logistic_type').val(obj.logistic_name);
						$('#logistic_id').val(obj.id);
						$('#logistic-error').html('');
						$('#awb_number').html('');
						// $("#order_btn").show();
						$("#order_btn").prop('disabled', false);
						$('#awb_order_btn').prop('disabled', false);
					}
				},
			});
		}
	});

	//shipping_charge
	$('.get-price').click(function () {

		var pickup_id = ($('#pickup_address').children(':selected').val());
		var deliverd_pincode = ($('#pincode').val());
		var shipment_type = $('#shipment_type').children(':selected').val();
		var order_type = $('#order_type').children(':selected').val();
		var volumetric_weight = $('#volumetric_weight').val();
		var physical_width = $('#physical_width').val();
		var collectable_amount = $('#collectable_amount').val();
		var logistic = $('#logistic_id').val();
		$("#create_order").prop('disabled', true);

		if (pickup_id && deliverd_pincode && pincode && shipment_type && order_type && volumetric_weight && physical_width && logistic != '') {
			$.ajax({
				type: "POST",
				url: hiddenurl + "Orderawb/get_shipping_charge",
				data: {
					logistic: logistic,
					pickup_id: pickup_id,
					deliverd_pincode: deliverd_pincode,
					shipment_type: shipment_type,
					order_type: order_type,
					volumetric_weight: volumetric_weight,
					physical_width: physical_width,
					collectable_amount: collectable_amount
				},
				success: function (data) {
					var data1 = $.trim(data);
					var obj = $.parseJSON(data1);
					if (obj.error != "") {
						$("#result_error_message").fadeIn("slow").html(obj.error);
						$("#create_order").prop('disabled', true);
						setTimeout(function () {
							$("#result_error_message").fadeOut("slow");
						}, 7000);
					} else {
						$('#shipping_charge').val(obj.shipping_amount_array.subtotal);
						$('.totalshipping').val(obj.shipping_amount_array.total);
						if (obj.shipping_amount_array.tax.IGST == 0) {
							$('#sgst').removeAttr("style");
							$('#cgst').removeAttr("style");
							$('.sgst').val(obj.shipping_amount_array.tax.SGST);
							$('.cgst').val(obj.shipping_amount_array.tax.CGST);
							$('#codcharge').val(obj.shipping_amount_array.cod_ammount);
						} else {
							$('#igst').removeAttr("style");
							$('.igst').val(obj.shipping_amount_array.tax.IGST);
						}
						$('html, body').animate({
							scrollTop: $("#logistic_type").offset().top
						}, 2000);
						$("#order_btn").show();

					}
				},
			});
		}

	});

	$('.get-price-ratye').click(function () {

		var pickup_id = ($('#pickup_address').children(':selected').val());
		var deliverd_pincode = ($('#pincode').val());
		var shipment_type = $('#shipment_type').children(':selected').val();
		var order_type = $('#order_type').children(':selected').val();
		var volumetric_weight = $('#volumetric_weight').val();
		var physical_width = $('#physical_width').val();
		var collectable_amount = $('#collectable_amount').val();
		var logistic = $('#logistic_id').val();
		$("#create_order").prop('disabled', true);

		if (pickup_id && deliverd_pincode && pincode && shipment_type && order_type && volumetric_weight && physical_width && logistic != '') {
			$.ajax({
				type: "POST",
				url: hiddenurl + "Orderawb/get_shipping_charge",
				data: {
					logistic: logistic,
					pickup_id: pickup_id,
					deliverd_pincode: deliverd_pincode,
					shipment_type: shipment_type,
					order_type: order_type,
					volumetric_weight: volumetric_weight,
					physical_width: physical_width,
					collectable_amount: collectable_amount
				},
				success: function (data) {
					var data1 = $.trim(data);
					var obj = $.parseJSON(data1);
					if (obj.error != "") {
						$("#result_error_message").fadeIn("slow").html(obj.error);
						$("#create_order").prop('disabled', true);
						setTimeout(function () {
							$("#result_error_message").fadeOut("slow");
						}, 7000);
					} else {
						$('#shipping_charge').val(obj.shipping_amount_array.subtotal);
						$('.totalshipping').val(obj.shipping_amount_array.total);
						if (obj.shipping_amount_array.tax.IGST == 0) {
							$('#sgst').removeAttr("style");
							$('#cgst').removeAttr("style");
							$('.sgst').val(obj.shipping_amount_array.tax.SGST);
							$('.cgst').val(obj.shipping_amount_array.tax.CGST);
							$('#codcharge').val(obj.shipping_amount_array.cod_ammount);
						} else {
							$('#igst').removeAttr("style");
							$('.igst').val(obj.shipping_amount_array.tax.IGST);
						}
						$('html, body').animate({
							scrollTop: $("#logistic_type").offset().top
						}, 2000);
						$("#order_btn").show();

					}
				},
			});
		}

	});


	//check duplicate order number
	$(document).delegate('#Order_Number', 'change', function () {
		var ordernumber = $('#Order_Number').val();
		if (ordernumber != "") {
			$.ajax({
				type: "POST",
				url: hiddenurl + "Orderawb/check_oreder_number",
				data: {
					ordernumber: ordernumber
				},
				success: function (response) {
					var data = response.replace(/\r?\n|\r/g, '');
					if ($.trim(data) == "sucess") {
						$('#ordernumber').html('');
					} else {
						$('#ordernumber').html('Order number is duplicate');
					}

				}
			});
		}
	});


	// get price simple order craete-simple-order
	$('.get-price-simple-order').click(function () {
		$(".loader-style").fadeIn("slow");
		var pickup_id = ($('#pickupaddress').children(':selected').val());
		var deliverd_pincode = ($('#pincode').val());
		var shipment_type = $('#shipment_type').children(':selected').val();
		var order_type = $('#order_type').children(':selected').val();
		var volumetric_weight = $('#volumetric_weight').val();
		var physical_width = $('#physical_width').val();
		var collectable_amount = $('#collectable_amount').val();
		if (pickup_id && deliverd_pincode && shipment_type && order_type && volumetric_weight && physical_width != '') {
			$.ajax({
				type: "POST",
				url: hiddenurl + "order/shipping_charge",
				data: {
					pickup_id: pickup_id,
					deliverd_pincode: deliverd_pincode,
					shipment_type: shipment_type,
					order_type: order_type,
					volumetric_weight: volumetric_weight,
					physical_width: physical_width,
					collectable_amount: collectable_amount
				},
				success: function (data) {
					$(".loader-style").fadeOut("slow");
					var data1 = $.trim(data);
					var obj = jQuery.parseJSON(data1);
					if (obj.error != "") {
						$("#result_error_message").fadeIn("slow").html(obj.error);
						setTimeout(function () {
							$("#result_error_message").fadeOut("slow");
						}, 7000);
					} else {
						$("#table_row").removeAttr("style");
						$('.ship_div').removeAttr("style");
						$('.ship_div').html(obj.message);

					}
				},
			});
		} else {
			$(".loader-style").fadeOut("slow");
			$('#create_order').on('click', function () {
				$("#create_simple_oreder").valid();
			});

		}


	});

	$(document).delegate('.selectable-item', 'change', function () {

		if ($(this).prop('checked') == true) {
			var tr = $(this).parent().parent();
			var cgst = tr.find('span.cgst').html();
			var sgst = tr.find('span.sgst').html();
			var igst = tr.find('span.igst').html();
			var total = tr.find('span.subtotal').html();
			var logistic_id = tr.find('span.logistic_id').html();
			var codamount = $('#cod_amount').val();
			// console.log(codamount);
			$.ajax({
				type: "POST",
				url: hiddenurl + "Order/check_wallet",
				data: {
					cgst: cgst,
					sgst: sgst,
					igst: igst,
					total: total,
					codamount: codamount
				},
				success: function (response) {

					var data = $.trim(response);
					var obj = jQuery.parseJSON(data);
					// console.log(obj);
					if (obj.error == "") {
						$('#create_order').css('cursor', 'not-allowed');
						var shipCharge = obj.shippingcharge;
						//console.log(shipCharge);
						$('#base_ship').val(total);
						$('#cgst').val(cgst);
						$('#sgst').val(sgst);
						$('#igst').val(igst);
						$('#total').val(shipCharge.toFixed(2));
						$('#logistic_id').val(logistic_id);
						// console.log(codamount);
						$('#cod_charge').val(codamount);
						$('.totalsummary').html(shipCharge.toFixed(2));
						$("#createorder").removeAttr("disabled");
					} else {
						$("#result_error_message").fadeIn("slow").html(obj.error);
						setTimeout(function () {
							$("#result_error_message").fadeOut("slow");
						}, 7000);
						$("#createorder").attr("disabled");
					}
				}
			});
		} else {
			$('.totalsummary').html('0.00');
			$("#createorder").attr("disabled");
		}

	});

	//rate calculation ajax

	$(document).delegate('.get-price-simple-order-rate', 'click', function () {

		$(".loader-style").fadeIn("slow");
		var pickup_id = ($('#pickup_pincode').val());
		var deliverd_pincode = ($('#pincode').val());
		var shipment_type = "0";
		var order_type = $('#order_type').children(':selected').val();
		var volumetric_weight = $('#volumetric_weight').val();
		var physical_width = $('#physical_width').val();
		var collectable_amount = $('#collectable_amount').val();
		if (pickup_id && deliverd_pincode && shipment_type && order_type && volumetric_weight && physical_width != '') {
			$.ajax({
				type: "POST",
				url: hiddenurl + "order/shipping_charge_rate",
				data: {
					pickup_id: pickup_id,
					deliverd_pincode: deliverd_pincode,
					shipment_type: shipment_type,
					order_type: order_type,
					volumetric_weight: volumetric_weight,
					physical_width: physical_width,
					collectable_amount: collectable_amount
				},
				success: function (data) {
					$(".loader-style").fadeOut("slow");
					var data1 = $.trim(data);
					var obj = jQuery.parseJSON(data1);
					if (obj.error != "") {
						$("#result_error_message").fadeIn("slow").html(obj.error);
						setTimeout(function () {
							$("#result_error_message").fadeOut("slow");
						}, 7000);
					} else {
						$("#table_row").removeAttr("style");
						$('.ship_div').removeAttr("style");
						$('.ship_div').html(obj.message);

					}
				},
			});
		} else {
			$(".loader-style").fadeOut("slow");
			alert("Please Enter All Details");
		}
	});

	// $('.get-price-simple-order-rate').click(function () {
	// 	$(".loader-style").fadeIn("slow");
	// 	var pickup_id = ($('#pickupaddress').children(':selected').val());
	// 	var deliverd_pincode = ($('#pincode').val());
	// 	var shipment_type = $('#shipment_type').children(':selected').val();
	// 	var order_type = $('#order_type').children(':selected').val();
	// 	var volumetric_weight = $('#volumetric_weight').val();
	// 	var physical_width = $('#physical_width').val();
	// 	var collectable_amount = $('#collectable_amount').val();
	// 	if (pickup_id && deliverd_pincode && shipment_type && order_type && volumetric_weight && physical_width != '') {
	// 		$.ajax({
	// 			type: "POST",
	// 			url: hiddenurl + "order/shipping_charge",
	// 			data: {
	// 				pickup_id: pickup_id,
	// 				deliverd_pincode: deliverd_pincode,
	// 				shipment_type: shipment_type,
	// 				order_type: order_type,
	// 				volumetric_weight: volumetric_weight,
	// 				physical_width: physical_width,
	// 				collectable_amount: collectable_amount
	// 			},
	// 			success: function (data) {
	// 				$(".loader-style").fadeOut("slow");
	// 				var data1 = $.trim(data);
	// 				var obj = jQuery.parseJSON(data1);
	// 				if (obj.error != "") {
	// 					$("#result_error_message").fadeIn("slow").html(obj.error);
	// 					setTimeout(function () {
	// 						$("#result_error_message").fadeOut("slow");
	// 					}, 7000);
	// 				} else {
	// 					$("#table_row").removeAttr("style");
	// 					$('.ship_div').removeAttr("style");
	// 					$('.ship_div').html(obj.message);

	// 				}
	// 			},
	// 		});
	// 	} else {
	// 		$(".loader-style").fadeOut("slow");
	// 		$('#create_order').on('click', function () {
	// 			$("#create_simple_oreder").valid();
	// 		});

	// 	}


	// });

	// End - create single order form 
});
