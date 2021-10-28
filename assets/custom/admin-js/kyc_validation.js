$(function () {
	var hiddenurl = $('#hiddenURL').val();
	$('#profile_types').on('change', function () {
		var profiletype = $('#profile_types').children(':selected').val();
		if (profiletype == 1) {
			$('#company_div').show();
		} else {
			$('#company_div').hide();
		}
	});

	$.validator.addMethod("company", function (val, ele, arg) {
			if ($("#profile_types").val() == 1 && val == '') {
				return false;
			} else {
				return true;
			}
		},
		"This field is required");

	$.validator.addMethod("pan_number", function (val, ele, arg) {
			// var panformat = new RegExp('/([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/');
			var panformat = new RegExp('^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}$');
			if (panformat.test(val)) {
				return true;
			} else {
				return false;
			}
		},
		"This field is not in the correct format.");

	$.validator.addMethod("gstnumber", function (val, ele, arg) {
			var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');
			if (val != '' && gstinformat.test(val)) {
				return true;
			} else if (val == '') {
				return true;
			} else {
				return false;
			}
		},
		"This field is not in the correct format.");

	$("form[name='kyc_verification_form']").validate({
		rules: {
			profile_type: {
				required: true,
			},
			pan_no: {
				required: true,
				maxlength: 10,
				pan_number: true
			},
			company_type: {
				company: true
			},
			company_name: {
				company: true
			},
			gst_no: {
				company: true,
				minlength: 15,
				gstnumber: true
			},
			pincode: {
				required: true,
				number: true,
				maxlength: 10,
			},
			state: {
				required: true,
				maxlength: 25,
			},
			city: {
				required: true,
				maxlength: 25,
			},
			address_1: {
				required: true,
				maxlength: 100,
			},
			address_2: {
				maxlength: 100,
			},
			doc1_id: {
				required: true
			},
			doc1_1_img: {
				required: true,
				accept: "png|jpeg|jpg|gif|pdf",
				filesize: 7340032,
			},
			doc1_2_img: {
				required: true,
				accept: "png|jpeg|jpg|gif|pdf",
				filesize: 7340032,
			},
			doc2_id: {
				required: true
			},
			doc2_image1: {
				required: true,
				accept: "png|jpeg|jpg|gif|pdf",
				filesize: 7340032,
			},
			// doc2_image2: {
			//     required: true,
			//     accept: "png|jpeg|jpg|gif|pdf",
			//     filesize: 7340032,
			// },
			cancelled_cheque_image: {
				required: true,
				accept: "png|jpeg|jpg|gif|pdf",
				filesize: 7340032,
			},
			pickup_id: {
				required: true
			},
			pick_up_img: {
				required: true,
				accept: "png|jpeg|jpg|gif|pdf",
				filesize: 7340032,
			},
			bankname: {
				required: true,
			},
			benificiary: {
				required: true,
			},
			acno: {
				required: true,
			},
			ifsc: {
				required: true,
			}
		},
		messages: {
			profile_type: {
				required: "Please select profile type.",
			},
			pan_no: {
				required: "Please enter pan no.",
				maxlength: "You can enter 10 characters",
			},
			gst_no: {
				maxlength: "You can enter 15 characters"
			},
			pincode: {
				required: "Please enter pincode.",
				number: "enter numbers only",
				maxlength: "You can enter 6 characters",
			},
			state: {
				required: "Please enter state.",
				maxlength: "You can enter 25 characters",
			},
			city: {
				required: "Please enter city.",
				maxlength: "You can enter 25 characters",
			},
			address_1: {
				required: "Please enter address line 1.",
				maxlength: "You can enter 100 characters",
			},
			address_2: {
				maxlength: "You can enter 100 characters",
			},
			doc1_id: {
				required: "Please Select Document Id"
			},
			doc1_1_img: {
				required: "Please select address proof"
			},
			doc1_2_img: {
				required: "Please select image for address proof.",
				accept: "Allow only png,jpeg,jpg,gif,pdf",
				filesize: "Allow less than 7MB",
			},
			doc1_image2: {
				required: "Please select image for address proof.",
				accept: "Allow only png,jpeg,jpg,gif,pdf",
				filesize: "Allow less than 7MB",
			},
			doc2_id: {
				required: "Please select identification proof"
			},
			doc2_image1: {
				required: "Please select image for identification proof.",
				accept: "Allow only png,jpeg,jpg,gif,pdf",
				filesize: "Allow less than 7MB",
			},
			// doc2_image2: {
			//     required: "Please select image for identification proof.",
			//     accept: "Allow only png,jpeg,jpg,gif,pdf",
			//     filesize: "Allow less than 7MB",
			// },
			cancelled_cheque_image: {
				required: "Please select image of cancelled cheque.",
				accept: "Allow only png,jpeg,jpg,gif,pdf",
				filesize: "Allow less than 7MB",
			},
			pickup_id: {
				required: "Please select identification proof"
			},
			pick_up_img: {
				required: "Please select image of pickup proof.",
				accept: "Allow only png,jpeg,jpg,gif,pdf",
				filesize: "Allow less than 7MB",
			},
			bankname: {
				required: "Please Enter Bank Name.",
			},
			benificiary: {
				required: "Please Enter Benificiary Name"
			},
			acno: {
				required: "Please Enter Account Number"
			},
			ifsc: {
				required: "Please Enter IFSC Code"
			}
		},
		submitHandler: function (form) {
			form.submit();
			$("#add_kyc").attr("disabled", true);
		}
	});


	$(document).delegate('.removeImage1', 'click', function () {
		if (confirm("Are you sure you want to delete ?")) {
			var imgid = $(this).data("id");
			var thisdata = $(this);
			// alert(imgid);
			$.ajax({
				url: hiddenurl + 'Manage_customer/deleteimage',
				type: 'POST',
				data: {
					imgid: imgid,
				},
				success: function (response) {
					if (response.success != "") {
						thisdata.parent('div').remove();
						$("#result_message").fadeIn("slow").html("Image Deleted Successfully");
						setTimeout(function () {
							$("#result_message").fadeOut("slow");
						}, 5000);
					} else {
						$("#result_error").fadeIn("slow").html("Something went wrong..");
						setTimeout(function () {
							$("#result_error").fadeOut("slow");
						}, 5000);
					}
				}
			});
		}
	});

	//cancelled check
	$("#cc_btn").on("click", function () {
		$("#cc_id_1").hide();
		$("#cc_id_2").show();
	});

	//other document
	$(".other_doc_btn").on("click", function () {
		$(this).parent().hide();
	});

	//pickup
	$("#pickup_btn").on("click", function () {
		$("#pickup_id_1").hide();
		$("#pickup_id_2").show();
	});

	// document-1 img 1
	$(".doc_1_img1_btn").on("click", function () {
		$(this).parent().parent().find('#doc_1_img_1_id_1').hide();
		$(this).parent().parent().find('#doc_1_img_1_id_2').show();
	});

	// document-1 img 2
	$(".doc_3_btn_edit").on("click", function () {
		$(this).parent().parent().find('#doc_1_img_2_id_1').hide();
		$(this).parent().parent().find('#doc_1_img_2_id_2').show();
	});




});
