$(function () {
	var hiddenurl = $('#hiddenURL').val();

	/**
	 *  Registration Form
	 */

	$("form[name='signup_form']").validate({
		rules: {
			first_name: 'required',
			last_name: 'required',
			user_email: {
				required: true
			},
			user_password: {
				required: true,
				minlength: 8,
				maxlength: 16
			},
			user_confirm_password: {
				required: true,
				equals: "#user_password",
				minlength: 8,
				maxlength: 16
			},
			user_phone: {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 15
			},
			user_website: {
				url: true
			},
			user_agreement: 'required'
		},
		messages: {
			first_name: 'Please Enter First Name',
			last_name: 'Please Enter Last Name',
			user_email: {
				required: "Please Enter Email"
			},
			user_password: {
				required: "Please Enter Password",
				minlength: "Your password must be at least 8 characters long",
				maxlength: "Your password must be less than 16 characters long"
			},
			user_confirm_password: {
				required: "Please Enter Password",
				equals: "Password does not match",
				minlength: "Your password must be at least 8 characters long",
				maxlength: "Your password must be less than 16 characters long"
			},
			user_phone: {
				required: "Please Enter Mobile No",
				number: "Please Enter Number Only",
				minlength: "Your phone number must be at least 10 characters long",
				maxlength: "Your phone number must be less than 15 characters long"
			},
			user_website: {
				url: "Please Enter Valid Website"
			},
			user_agreement: 'Please select Terms and conditions'
		},
		submitHandler: function (form) {
			form.submit();
			$("#signup_btn").attr("disabled", true);
		}
	});

	/**
	 * login
	 */
	$("form[name='login_form']").validate({
		rules: {
			user_email: {
				required: true,
				email: true
			},
			user_password: {
				required: true,
				minlength: 8,
				maxlength: 16
			}
		},
		messages: {
			user_email: {
				required: 'Please Enter Email',
				email: "Please Enter Valid Email"
			},
			user_password: {
				required: "Please Enter Password",
				minlength: "Your password must be at least 8 characters long",
				maxlength: "Your password must be less than 16 characters long"
			}
		},
		submitHandler: function (form) {
			form.submit();
			$("#login_btn").attr("disabled", true);
		}
	});




	$("#reset_pwd_form").validate({
		rules: {
			password: {
				required: true,
				minlength: 8,
				maxlength: 16,
			},
			confirm_password: {
				required: true,
				minlength: 6,
				equalTo: '#password',
			},
		},
		messages: {
			password: {
				required: "Please enter Password",
				minlength: "Your password must be at least 6 characters long",
				maxlength: "Your password  max length is 16 characters long"
			},
			confirm_password: {
				required: "Please enter Password",
				equalTo: "password does not match",
			},
		},
	});






});
