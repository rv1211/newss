$(function () {
	var hiddenurl = $('#hiddenUrl').val();
	var callUrl = hiddenurl + "home/email";
	$("form.signupform").validate({
		rules: {
			name: {
				required: true,
				maxlength: 25
			},
			email: {
				required: true,
				email: true,
				maxlength: 100,
				remote: {
					url: callUrl,
					type: "post"
				}
			},
			password: {
				required: true,
				minlength: 5
			},
			retype_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			phone: {
				required: true,
				number: true,
				maxlength: 15
			},
			website: {
				url: true
			}
		},
		errorElement: 'span',
		focusInvalid: false,
		ignore: ".ignore",
		messages: {
			name: {
				required: "Please Enter a Name.",
				maxlength: "You can enter 25 characters"
			},
			email: {
				required: "Please Enter an Email",
				email: "Please Enter valid email",
				maxlength: "You can enter 100 characters",
				remote: "Email Id already exist!"
			},
			password: {
				required: "Please Enter a password",
				minlength: "Your password must be at least 5 characters long"
			},
			retype_password: {
				required: "Please Enter a password",
				minlength: "Your password must be at least 5 characters long",
				equalTo: "Password not match"
			},
			phone: {
				required: "Please Enter a Phone No",
				number: "Please Enter Number only",
				maxlength: "You can enter only 15 characters"
			},
			website: {
				url: "Please Enter valid Website URL"
			}
		},
		submitHandler: function (form) {
			form.submit();
			$('#signupbtn').attr("disabled", true);
		}
	});

	/**
	 * Change by dhara
	 */
	$("form.user_profile").validate({
		rules: {
			customer_name: {
				required: true,
				maxlength: 50
			},
			password: {
				minlength: 5
			},
			customer_phone: {
				required: true,
				number: true,
				maxlength: 15
			},
			website: {
				url: true
			},
			bill_pincode: {
				required: true
			},
			bill_state: {
				required: true
			},
			bill_city: {
				required: true
			},
			bill_address_1: {
				required: true
			},
			sms_option: {
				required: true
			}
		},
		errorElement: 'span',
		focusInvalid: false,
		ignore: ".ignore",
		messages: {
			customer_name: {
				required: "Please Enter a Name.",
				maxlength: "You can enter 50 characters"
			},
			password: {
				minlength: "Your password must be at least 5 characters long"
			},
			customer_phone: {
				required: "Please Enter a Phone No",
				number: "Please Enter Number only",
				maxlength: "You can enter only 15 characters"
			},
			website: {
				url: "Please Enter valid Website URL"
			},
			bill_pincode: {
				required: "Please enter pincode"
			},
			bill_state: {
				required: "Please enter state"
			},
			bill_city: {
				required: "Please enter city"
			},
			bill_address_1: {
				required: "Please enter address"
			},
			sms_option: {
				required: "Please select any one option"
			}
		},
		submitHandler: function (form) {
			form.submit();
			$('#profile_btn').attr("disabled", true);
		}
	});

	$("form.enquiryform").validate({
		rules: {
			name: {
				required: true,
				maxlength: 50
			},
			email: {
				required: true,
				email: true,
				maxlength: 255
			},
			contact_no: {
				required: true,
				number: true,
				maxlength: 10
			},
			tracking_number: {
				required: true,
				maxlength: 50
			},
			captcha: {
				required: true,
				equalTo: "#captcha_word"
			}
		},
		errorElement: 'span',
		focusInvalid: false,
		ignore: ".ignore",
		messages: {
			name: {
				required: "Please Enter a Name.",
				maxlength: "You can enter 50 characters"
			},
			email: {
				required: "Please Enter an Email",
				email: "Please Enter valid email",
				maxlength: "You can enter 255 characters"
			},
			contact_no: {
				required: "Please Enter a Mobile No",
				number: "Please Enter Number only",
				maxlength: "You can enter only 10 characters"
			},
			tracking_number: {
				required: "Please Enter an Airwaybill No",
				maxlength: "You can enter only 50 characters"
			},
			captcha: {
				required: "Please Enter a Captcha code",
				equalTo: "Captcha not match"
			}
		},
		submitHandler: function (form) {
			$('#button').prop('disabled', true);
			form.submit();
		},
		invalidHandler: function (form) {
			$(".se-pre-con").hide();
		}
	});

	$("form.form_kyc_verification").validate({
		rules: {
			profile_type: {
				required: true
			},
			name: {
				required: true
			},
			pan_no: {
				required: true,
				maxlength: 15
			},
			/*gst_no: {
			    required: true,
			    maxlength:15
			},*/
			address_proof_type: {
				required: true
			},
			file_name1: {
				required: true
			},
			id_proof_type: {
				required: true
			},
			file_name2: {
				required: true
			},
			file_name3: {
				required: true
			},
			bill_pincode: {
				required: true
			},
			bill_state: {
				required: true
			},
			bill_city: {
				required: true
			},
			bill_address_1: {
				required: true
			},
			sms_option: {
				required: true
			}
		},
		errorElement: 'span',
		focusInvalid: false,
		ignore: ".ignore",
		messages: {
			profile_type: {
				required: "Please select profile type.",
			},
			name: {
				required: "Please enter name",
			},
			pan_no: {
				required: "Please enter pan no",
				maxlength: "you can only enter 10 characters"
			},
			/*gst_no: {
			    required: "Please Enter a GST no",
			    maxlength: "you can only enter 15 characters"
			},*/
			address_proof_type: {
				required: "Please select Documet1"
			},
			file_name1: {
				required: "Please upload image for Document1"
			},
			id_proof_type: {
				required: "Please select Document2"
			},
			file_name2: {
				required: "Please upload image for Document2"
			},
			file_name3: {
				required: "Please upload cancelled chaque"
			},
			bill_pincode: {
				required: "Please enter pincode"
			},
			bill_state: {
				required: "Please enter state"
			},
			bill_city: {
				required: "Please enter city"
			},
			bill_address_1: {
				required: "Please enter address"
			},
			sms_option: {
				required: "Please select any one option."
			}
		},
		submitHandler: function (form) {
			//$(".se-pre-con").fadeIn("slow");
			$(".se-pre-con").show();
			$('#add_kyc').prop('disabled', true);
			form.submit();
		},
		invalidHandler: function (form) {
			$(".se-pre-con").hide();
		}
	});

	var addPickupaddress = hiddenurl + "admin/check_duplicate_name";
	$("form.form_pickup_address").validate({
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
		focusInvalid: false,
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
			}
		},
		submitHandler: function (form) {
			$('.add_pickup').prop('disabled', true);
			$(".se-pre-con").fadeIn("slow");
			form.submit();
		},
		invalidHandler: function (form) {
			$(".se-pre-con").hide();
		}
	});

	$("form.form_pickup_address_edit").validate({
		rules: {
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
		focusInvalid: false,
		ignore: ".ignore",
		messages: {
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
			}
		},
		submitHandler: function (form) {
			$('.add_pickup').prop('disabled', true);
			$(".se-pre-con").fadeIn("slow");
			form.submit();
		},
		invalidHandler: function (form) {
			$(".se-pre-con").hide();
		}
	});

	var metrocity_id = $('#metrocity_id').val();
	if (metrocity_id != '') {
		var addMetrocity = hiddenurl + "metrocity/check_duplicate/" + metrocity_id;
	} else {
		var addMetrocity = hiddenurl + "metrocity/check_duplicate";
	}
	$("form.form_metrocity").validate({
		rules: {
			metrocity_name: {
				required: true,
				remote: {
					url: addMetrocity,
					type: "post"
				}
			}
		},
		messages: {
			metrocity_name: {
				required: "Please Enter a Metrocity Name.",
				remote: "Metrocity Name already exists."
			}
		},
		submitHandler: function (form) {
			$(".se-pre-con").fadeIn("slow");
			$('#add_metrocity_button').prop('disabled', true);
			form.submit();
		},
		invalidHandler: function (form) {
			$(".se-pre-con").hide();
		}
	});


	var rule_id = $('#rule_id').val();
	if (rule_id != '') {
		var addRule = hiddenurl + "rule/check_duplicate/" + rule_id;
		var addRuleweight = hiddenurl + "rule/check_duplicate_weight/" + rule_id;
	} else {
		var addRule = hiddenurl + "rule/check_duplicate";
		var addRuleweight = hiddenurl + "rule/check_duplicate_weight";
	}
	$("form.form_rule").validate({
		rules: {
			rule_name: {
				required: true,
				remote: {
					url: addRule,
					type: "post"
				},
			},
			rule_start_weight: {
				required: true,
			},
			rule_end_weight: {
				required: true,
			},
		},
		messages: {
			rule_name: {
				required: "Please Enter a Rule Name.",
				remote: "Rule Name already exists."
			},
			rule_start_weight: {
				required: "Please Enter a Start Weight.",
			},
			rule_end_weight: {
				required: "Please Enter a End Weight.",
			}
		},
		submitHandler: function (form) {
			$(".se-pre-con").fadeIn("slow");
			form.submit();
		},
		invalidHandler: function (form) {
			$(".se-pre-con").hide();
		}
	});


	var zone_id = $('#zone_id').val();
	if (zone_id != '') {
		var addZone = hiddenurl + "zone/check_duplicate/" + zone_id;
		var addZoneprice = hiddenurl + "zone/check_duplicate_price/" + zone_id;
	} else {
		var addZone = hiddenurl + "zone/check_duplicate";
		var addZoneprice = hiddenurl + "zone/check_duplicate_price";
	}
	$("form.form_zone").validate({
		rules: {
			zone_name: {
				required: true,
				remote: {
					url: addZone,
					type: "post"
				}
			},
			zone_start_distance: {
				required: true,
			},
			zone_end_distance: {
				required: true,
			}
		},
		messages: {
			zone_name: {
				required: "Please Enter a Zone Name.",
				remote: "Zone Name already exists."
			},
			zone_start_distance: {
				required: "Please Enter a Start Distance.",
			},
			zone_end_distance: {
				required: "Please Enter a End Distance.",
			}
		},
		submitHandler: function (form) {
			$(".se-pre-con").fadeIn("slow");
			$('#add_zone_button').prop('disabled', true);
			form.submit();
		},
		invalidHandler: function (form) {
			$(".se-pre-con").hide();
		}
	});


	$("#zone_start_distance, #zone_end_distance, #zone_for").on('change', function () {
		$(".se-pre-con").fadeIn("slow");

		var zone_start_distance = $('#zone_start_distance').val();
		var zone_end_distance = $('#zone_end_distance').val();
		var zone_for = $('#zone_for').val();
		$.ajax({
			type: 'POST',
			url: addZoneprice,
			data: {
				"zone_start_distance": zone_start_distance,
				"zone_end_distance": zone_end_distance,
				"zone_for": zone_for
			},
			dataType: 'HTML',
			success: function (response) {
				$(".se-pre-con").fadeOut("slow");
				if (response == 'false') {
					$("#zone_start_distance").addClass('priceerror');
					$("#zone_end_distance").addClass('priceerror');
					$("#zone_for").addClass('priceerror');
				}
				if (response == 'true') {
					$("#zone_start_distance").removeClass('priceerror');
					$("#zone_end_distance").removeClass('priceerror');
					$("#zone_for").removeClass('priceerror');
				}
			}
		});
	});


	$("#rule_start_weight, #rule_end_weight").on('change', function () {
		$(".se-pre-con").fadeIn("slow");

		var rule_start_weight = $('#rule_start_weight').val();
		var rule_end_weight = $('#rule_end_weight').val();
		$.ajax({
			type: 'POST',
			url: addRuleweight,
			data: {
				"rule_start_weight": rule_start_weight,
				"rule_end_weight": rule_end_weight
			},
			dataType: 'HTML',
			success: function (response) {
				$(".se-pre-con").fadeOut("slow");
				//console.log(response);
				if (response == 'false') {
					$("#rule_start_weight").addClass('priceerror');
					$("#rule_end_weight").addClass('priceerror');
				}
				if (response == 'true') {
					$("#rule_start_weight").removeClass('priceerror');
					$("#rule_end_weight").removeClass('priceerror');
				}
			}
		});
	});



	var manage_shipping_price_id = $('#manage_shipping_price_id').val();
	if (manage_shipping_price_id != '') {
		var addShippingprice = hiddenurl + "manageshippingprice/check_duplicate/" + manage_shipping_price_id;
	} else {
		var addShippingprice = hiddenurl + "manageshippingprice/check_duplicate";
	}
	$("form.form_shippingprice").validate({
		rules: {
			zone_id: {
				required: true,
				remote: {
					url: addShippingprice,
					type: "post",
					data: {
						'rule_id': function () {
							return $('#rule_id').val()
						}
					},
					async: false
				}
			},
			rule_id: {
				required: true,
				remote: {
					url: addShippingprice,
					type: "post",
					data: {
						'zone_id': function () {
							return $('#zone_id').val()
						}
					},
					async: false
				}
			},
			value: {
				required: true
			}
		},
		messages: {
			zone_id: {
				required: "Please select Zone.",
				remote: "Already exists."
			},
			rule_id: {
				required: "Please select Rule.",
				remote: "Already exists."
			},
			value: {
				required: "Enter Value for Shipping Price"
			}
		},
		submitHandler: function (form) {
			$(".se-pre-con").fadeIn("slow");
			$('#add_shippingprice_button').prop('disabled', true);
			form.submit();
		},
		invalidHandler: function (form) {
			$(".se-pre-con").hide();
		}
	});




	/*$("#wallet_update_for_user").validate({
	    rules: {
	        user_id: {
	            required: true,
	        },
	        wallet_amount:{
	            required: true,
	            number: true,
	        },
	        razorpay_pay_id:{
	            required: true
	        }
	    },
	    messages: {         
	        user_id: {
	            required: "Please select User.",
	        },
	        wallet_amount:{
	            required: "Please enter amount.",
	            number: "Please enter number only.",
	        },
	        razorpay_pay_id:{
	            required: "Please enter razorpay pay id."
	        }
	    },
	    submitHandler: function(form) {
	      $(".se-pre-con").fadeIn("slow");
	      $('#wallet_update_for_user_button').prop('disabled', true);
	      form.submit();
	    }, invalidHandler: function(form){
	        $(".se-pre-con").hide();
	    }
	});*/
	$("#wallet_update_for_user").validate({
		rules: {
			user_id: {
				required: true,
			},
			wallet_action: {
				required: true,
			},
			wallet_amount: {
				required: true,
				number: true,
			},
			wallet_remarks: {
				required: true
			}
		},
		messages: {
			user_id: {
				required: "Please select User.",
			},
			wallet_action: {
				required: "Please select action.",
			},
			wallet_amount: {
				required: "Please enter amount.",
				number: "Please enter number only.",
			},
			wallet_remarks: {
				required: "Please enter remarks."
			}
		},
		submitHandler: function (form) {
			$(".se-pre-con").fadeIn("slow");
			$('#wallet_update_for_user_button').prop('disabled', true);
			form.submit();
		},
		invalidHandler: function (form) {
			$(".se-pre-con").hide();
		}
	});

});
