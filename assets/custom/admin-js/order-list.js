$(function () {
	var hiddenurl = $('#hiddenURL').val();

	$(document).delegate('#order_detail_btn', 'click', function () {
		$(".modal-body").html(" ");
		var order_id = $(this).data('id');
		let ord_type = "detail";
		$.ajax({
			type: "POST",
			url: hiddenurl + "Order_details/all_order_details",
			data: {
				order_id: order_id,
				ord_type: ord_type,
				button_type: 'order_detail'
			},
			success: function (response) {
				$("#myModal").modal('show');
				$(".modal-body").html(response);

			}
		});

	});

	$(document).delegate('#order_tracking_btn', 'click', function () {
		$(".modal-body").html(" ");
		var order_id = $(this).data('id');
		// alert(order_id);
		let ord_type = "track";
		$.ajax({
			type: "POST",
			url: hiddenurl + "Order_details/all_order_details",
			data: {
				order_id: order_id,
				ord_type: ord_type,
				button_type: 'order_tracking'
			},
			success: function (response) {
				$("#myModal").modal('show');
				$(".modal-body").html(response);

			}
		});
	});

	//select all checkbox
	$(document).delegate('#select_all', 'click', function () {

		if ($(this).prop("checked") == true) {
			$('.select-item').prop('checked', true);
		} else {
			$('.select-item').prop('checked', false);
		}
	});

	//order ndr details
	$(document).delegate('#order_ndr_comment,#pre_order_ndr_comment', 'click', function () {

		//$('#intransit_order_details').modal("show")
		var order_id = $(this).data('id');
		var order_type = $(this).data('type');
		var other_tabs = $(this).data('ndr');

		$("#loader").show();
		if (order_id) {
			$.ajax({
				type: "POST",
				url: hiddenurl + "Order_details/ndr_tracking_details",
				data: {
					order_id: order_id,
					order_type: order_type,
					other_tabs: other_tabs
				},
				success: function (response) {
					if (response) {
						// console.log(response);
						$('.modal-body-ndr').html(response);
						$("#loader").hide();
					}
				}
			});
		}
	});


	//multiple print 
	$(document).delegate('#multi_print', 'click', function () {
		$("#loader").fadeIn("slow");
		var check_array = [];
		if ($('.table').length > 0) {
			$.each($("input[name='id[]']:checked"), function () {
				check_array.push($(this).val());
			});
		}
		if (check_array != "") {
			if ($("input[name=radio_btn]:checked").length > 0) {
				var label_type = $("input[name=radio_btn]:checked").val();
				$.ajax({
					type: "POST",
					url: hiddenurl + "multiple_print",
					data: {
						id: check_array,
						label_type: label_type
					},
					success: function (response) {
						if (response) {
							$("#loader").fadeOut("slow");
							window.open(hiddenURL + 'uploads/multiple_print/' + response, '_blank');
							$('.select-item').prop('checked', false);
							$('#select_all').prop('checked', false);
						}
					}
				});
			} else {
				$("#loader").fadeOut("slow");
				alert("Please select any one label option....")
			}
		} else {
			alert("Please select alt least one record");
			$("#loader").fadeOut("slow");
		}
	});

	//print manifest
	$(document).delegate('#multi_print_manifest', 'click', function () {
		$("#loader").fadeIn("slow");
		var check_array = [];
		if ($('.table').length > 0) {
			$.each($("input[name='id[]']:checked"), function () {
				check_array.push($(this).val());
			});
		}
		if (check_array != "") {
			$.ajax({
				type: "POST",
				url: hiddenurl + "multiple-menifest-slip",
				data: {
					order_id: check_array
				},
				success: function (response) {
					if (response) {
						$("#loader").fadeOut("slow");
						window.open(hiddenURL + 'uploads/multiple_manifest/' + response, '_blank');
						$('.select-item').prop('checked', false);
						$('#select_all').prop('checked', false);
					}
				}
			});
		} else {
			alert("Please select alt least one record...");
			$("#loader").fadeOut("slow");
		}
	});

	$(document).delegate('.single_order_print_button', 'click', function () {
		if ($("input[name=radio_btn]:checked").length > 0) {
			var order_id = $(this).data('id');
			var label_type = $("input[name=radio_btn]:checked").val();
			var label_type_name = $("input[name=radio_btn]:checked").data('name');
			window.open(hiddenurl + 'packing-slip-' + label_type_name + '/' + order_id, '_blank');
		} else {
			alert("Please select any one label option....")
		}
	});

	$(document).delegate('#order_type_xpressbess', 'change', function () {
		$("#totalAwbxpressbess").html("00");
		var order_type = $(this).val();
		$.ajax({
			type: "post",
			url: "xpress_awb/get_total_awb",
			data: {

				order_type: order_type
			},
			dataType: 'JSON',
			success: function (response) {
				$("#totalAwbxpressbess").html(response.count);
			}
		});
	});


	$(document).delegate('#order_type_xpressbessair', 'change', function () {
		$("#totalAwbxpressbessair").html("00");
		var order_type = $(this).val();
		$.ajax({
			type: "post",
			url: "xpress_awb/get_total_awb",
			data: {
				is_express: '1',
				order_type: order_type
			},
			dataType: 'JSON',
			success: function (response) {
				$("#totalAwbxpressbessair").html(response.count);
			}
		});
	});

	//delete multiple order
	$(document).delegate('#multiple_delete', 'click', function () {

		$("#loader").fadeIn("slow");
		var check_array = [];
		if ($('.table').length > 0) {
			$.each($("input[name='id[]']:checked"), function () {
				check_array.push($(this).val());
			});
		}
		if (check_array != "") {
			if (confirm("Are you sure ? You want to delete the record !!")) {
				$.ajax({
					type: "POST",
					dataType: "json",
					url: hiddenurl + "Order_list/delete_multiple_created_order",
					data: {
						order_id: check_array
					},
					success: function (response) {
						if (response.total != "") {
							$("#loader").fadeOut("slow");
							$("#result_message").fadeIn("slow").html("Successfully refunded " + response.success + ", Error refund: " + response.error);
							setTimeout(function () {
								$("#result_error_message").fadeOut("slow");
							}, 7000);
							$('.select-item').prop('checked', false);
							$('#select_all').prop('checked', false);
							location.reload();
						}
					}
				});
			} else {
				$('.select-item').prop('checked', false);
				$('#select_all').prop('checked', false);
				$("#loader").fadeOut("slow");
			}


		} else {
			alert("Please select at least one record...");
			$("#loader").fadeOut("slow");
		}
	});


	//delete multiple bulk order
	$(document).delegate('#delete_nultiple_bulk_order', 'click', function () {

		$("#loader").fadeIn("slow");
		var check_array = [];
		if ($('.table').length > 0) {
			$.each($("input[name='check_single']:checked"), function () {
				check_array.push($(this).val());
			});
		}
		if (check_array != "") {
			if (confirm("Are you sure ? You want to delete the record ??")) {
				$.ajax({
					type: "POST",
					url: hiddenurl + "Create_bulk_order/delete_multiple_bulk_order",
					data: {
						order_id: check_array
					},
					success: function (response) {

						if (response) {

							console.log(response);
							$("#loader").fadeOut("slow");
							$('.Bulk_checkAll').prop('checked', false);
							$('#check_single').prop('checked', false);
							if (response != 0) {

								$("#result_error_message").fadeIn("slow").html("Bulk order deleted sucessfully");
								setTimeout(function () {
									$("#result_error_message").fadeOut("slow");
								}, 7000);
							} else {

								$("#result_error_message").fadeIn("slow").html("Failed !!Try again");
								setTimeout(function () {
									$("#result_error_message").fadeOut("slow");
								}, 7000);
							}
							location.reload();
							// window.location.href(hiddenurl + "bulk-order");

						}

						// window.location.href(hiddenurl + "bulk-order");

					}

				});
			}
			$("#loader").fadeOut("slow");
		} else {
			alert("Please select at least one record...");
			$("#loader").fadeOut("slow");
		}
	});


	//delete multiple Simple order
	$(document).delegate('#multiple_error_delete', 'click', function () {

		$("#loader").fadeIn("slow");
		var check_array = [];
		if ($('.table').length > 0) {
			$.each($("input[name='id[]']:checked"), function () {
				check_array.push($(this).val());
			});
		}

		if (check_array != "") {
			if (confirm("Are you sure ? You want to delete the record ??")) {
				$.ajax({
					type: "POST",
					url: hiddenurl + "Order_list/delete_multiple_error_order",
					data: {
						order_id: check_array
					},
					success: function (response) {
						if (response) {
							if (response != 0) {
								$("#result_error_message").fadeIn("slow").html("Order deleted sucessfully");
								setTimeout(function () {
									$("#result_error_message").fadeOut("slow");
								}, 7000);
							} else {
								console.log("else");
								$("#result_error_message").fadeIn("slow").html("Failed !!Try again");
								setTimeout(function () {
									$("#result_error_message").fadeOut("slow");
								}, 7000);
							}
							$("#loader").fadeOut("slow");
							$('.select-item').prop('checked', false);
							$('#select_all').prop('checked', false);

							location.reload();

						}
					}
				});
			}
			$("#loader").fadeOut("slow");
		} else {
			alert("Please select at least one record...");
			$("#loader").fadeOut("slow");
		}
	});

});