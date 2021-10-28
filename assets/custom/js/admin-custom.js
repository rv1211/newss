$(function () {
	var razorpay_key = $("#razorpay_key").val();
	var hiddenURL = $('#hiddenURL').val();

	$('.wallet_btn').on('click', function () {
		var amount = $(this).val();
		$('#wallet_amount').val(amount);
	});

	$('#wallet_transaction_recharge_wallet_button').on('click', function (e) {
		$(".ajax-loader").fadeIn("slow");
		var totalAmount = $('#wallet_amount').val();
		if (totalAmount != '') {
			if (totalAmount >= 100) {
				var options = {
					"key": razorpay_key,
					"amount": parseInt((totalAmount.replace(",", "")) * 100),
					"name": "ShipSecure",
					"description": "Wallet Recharge",
					"image": hiddenURL + "uploads/logo.png",
					"handler": function (response) {
						$(".ajax-loader").fadeOut("slow");
						$.ajax({
							url: hiddenURL + 'wallet-reinsertcharge',
							type: 'post',
							dataType: 'json',
							data: {
								razorpay_payment_id: response.razorpay_payment_id,
								totalAmount: totalAmount
							},
							success: function (ajaxresponse) {
								console.log(ajaxresponse);
								$(".ajax-loader").fadeOut("slow");
								if (ajaxresponse.message == 'success') {
									$("#result_message").fadeIn("slow").html('Payment successfully credited.');
									setTimeout(function () {
										$("#result_error_message").fadeOut("slow");
										location.reload();
									}, 4000);
								} else {
									$("#result_error_message").fadeIn("slow").html(ajaxresponse.status);
									setTimeout(function () {
										$("#result_error_message").fadeOut("slow");
										//location.reload();
									}, 4000);
								}
							}
						});
					},
					"theme": {
						"color": "#528FF0"
					}
				};
				$(".ajax-loader").fadeOut("slow");
				var rzp1 = new Razorpay(options);
				rzp1.open();
				e.preventDefault();
			} else {
				$(".ajax-loader").fadeOut("slow");
				alert("Minimum amount for balance is: Rs.2000");
				return false;
			}
		} else {
			$(".ajax-loader").fadeOut("slow");
			alert("Please Enter Wallet Amount");
			return false;
		}
	});


	$("#kycpincode").keyup(function () {
		var pincode = $(this).val();
		// console.log(pincode);
		$.ajax({
			url: hiddenURL + 'get-city-state-from-pincode',
			type: 'POST',
			data: {
				pincode: pincode
			},
			dataType: 'json',
			success: function (response) {
				$("input[name=city]").val(response.city);
				$("input[name=state]").val(response.state);
				$('ajax-loader').fadeOut('slow');
			}
		});
	});

	$('.select2').select2();

	$('#order_type_ecom').on('change', function () {
		$("#totalAwbecom").html("0");
		var order_type = $(this).val();
		$.ajax({
			type: "post",
			url: "ecom_awb/get_total_awb",
			data: {
				order_type: order_type
			},
			dataType: 'JSON',
			success: function (response) {
				$("#totalAwbecom").html(response.count);
			}
		});
	});

});

function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	} else {
		return true;
	}
}


function istext(evt) {
	var charCode = (evt.which) ? evt.which : window.event.keyCode;
	if (charCode <= 13) {
		return true;
	} else {
		var keyChar = String.fromCharCode(charCode);
		var re = /^[a-zA-Z ]+$/
		return re.test(keyChar);
	}
}

// pickup address get pincode from state and city 
$("#pickup_pincode").keyup(function () {
	var pincode = $(this).val();
	// console.log(pincode);
	$.ajax({
		url: hiddenURL + 'get-city-state-from-pincode',
		type: 'POST',
		data: {
			pincode: pincode
		},
		dataType: 'json',
		success: function (response) {
			$("input[name=city]").val(response.city);
			$("input[name=state]").val(response.state);
			$('ajax-loader').fadeOut('slow');
		}
	});
});


$(document).delegate('.print_shipment_manifest', 'click', function () {
	$(".ajax-loader").fadeIn("slow");
	var order_id = [];
	var rowcollection = $(".select-item:checked");
	rowcollection.each(function (index, elem) {
		order_id.push($(elem).val());
	});
	if (order_id.length > 0) {
		$.ajax({
			type: 'POST',
			url: hiddenURL + 'multiple-menifest-slip',
			data: {
				order_id: order_id
			},
			success: function (response) {
				$(".ajax-loader").fadeOut("slow");
				window.open(hiddenURL + 'uploads/manifest_print/' + response, '_blank');
			}
		});
	} else {
		$(".ajax-loader").fadeOut("slow");
		alert("Please Select Order..");
	}
});




$(document).delegate('.view_missmatch_detail', 'click', function (e) {

	console.log(this);
	var id = $(this).attr('id');

	$.ajax({
		type: "post",
		url: hiddenURL + "get_missmatch_data",
		data: {
			id: id
		},
		// dataType: "html",
		success: function (response) {
			$(".ndr_comment").html(response);
		}
	});



});