var hiddenURL = $('#hiddenURL').val();

/**
 * cod-credit recei[t] charges table
 */
$("#cod_credit_receipt").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Codremittance_new/cod_credit_receipt_table',
	},
	"language": {
		"infoFiltered": "",
	}
});
/**
 * cod-Bill-Summary charges table
 */
$("#cod_bill_summary").DataTable({
	// "serverSide": true,
	"pageLength": 10,
	"lengthMenu": [
		[10, 50, 100, -1],
		[10, 50, 100, "All"]
	],
	// "ajax": {
	//     "url": hiddenURL + 'Codremittance_new/cod_bill_summary_table',
	// },
	"language": {
		"infoFiltered": "",
	}
});

/**
 * cod-wallet-transactions table
 */
$("#cod_wallet_transactions").DataTable({
	"serverSide": true,
	"pageLength": 10,
	"lengthMenu": [
		[10, 50, 100, -1],
		[10, 50, 100, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Codremittance_new/cod_wallet_transactions_table',
	},
	"columnDefs": [{
			"targets": [2, 3],
			"orderable": false,
			"searchable": false
		}

	],
	"order": [
		[0, "desc"]
	],
	"language": {
		"infoFiltered": "",
	}
});
/**
 * cod-shipping charges table
 */
$("#cod_shipping_charge").DataTable({
	// "serverSide": true,
	"pageLength": 10,
	"lengthMenu": [
		[10, 50, 100, -1],
		[10, 50, 100, "All"]
	],
	// "ajax": {
	//     "url": hiddenURL + 'Codremittance_new/cod_shipping_charge_table',
	// },
	"language": {
		"infoFiltered": "",
	}
});
/**
 * cod-remittance table
 */
$("#cod_remittance").DataTable({
	"serverSide": true,
	"pageLength": 10,
	"lengthMenu": [
		[10, 50, 100, -1],
		[10, 50, 100, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Codremittance_new/cod_remittance_table',
	},
	"language": {
		"infoFiltered": "",
	}
});

// Start metrocity_form
$("#metrocity_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'metrocity_list',
	},
	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"url": ""

	}],

	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'Metrocity List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data ',
		exportOptions: {
			columns: [1, 2]
		},

	}]
});

// Start priority_form
$("#logisctic_priority_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'loadlogistics_priority',
	},
	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"url": ""

	}],
});

$("#logisctic_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'loadlogistic',
	},
	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"url": ""

	}],
	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'Logistic List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data ',
		exportOptions: {
			columns: [0, 1, 2, 3, 4, 5]
		},
	}]
});

$("#rule_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'loadrule',
	},

	"language": {
		"infoFiltered": "",
	},
	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'Rule List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data ',
		exportOptions: {
			columns: [0, 1, 2, 3]
		},

	}]

});

// Wallet Transaction
$("#wallet_transaction_tbl").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'loadwallat',
	},
	"language": {
		"infoFiltered": "",
	}
});

// Shipping Parice
$("#shipping_price_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'loadshipprice',
	},

	"language": {
		"infoFiltered": "",
	},

	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'Shipping Price',
		text: 'Export',
		className: 'btn btn-primary export_excel_data ',
		exportOptions: {
			columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
		},

	}]
});

// User List 
// change by Ruchita
$("#user_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'user-list',
	},
	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"url": ""
	}],

	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'User Data List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data',
		exportOptions: {
			columns: [1, 2, 3, 4, 5]
		},

	}]

});

$("#pickup_add_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'pickup_address_load',
	},

	"language": {
		"infoFiltered": "",
	},
	"order": [
		[1, "desc"]
	],
	"columnDefs": [{
		"orderable": false,
		"targets": 0

	}],


});

/**
 * Pending Customer List
 */
$("#kyc_pending_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'kyc_pending_customer_table',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 6],
		"visible": false,
	}],

	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'Kyc Pending Customer Data',
		text: 'Export',
		className: 'btn btn-primary export_excel_data ',
		exportOptions: {
			columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
		},

	}]
});


/**
 * Approved Customer List
 */
$("#kyc_approved_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'approve_customer_table',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 6],
		"visible": false,
	}],

	dom: '<“H”lfrp>t<“F”ip>',
	buttons: [{
		extend: 'csv',
		filename: 'Kyc Approved Customer Data',
		text: 'Export',
		className: 'btn btn-primary export_excel_data ',
		exportOptions: {
			columns: [1, 2, 3, 4, 5, 7, 8, 9, 10, 11]
		},

	}]

});

/**
 * Rejected Customer List
 */
$("#kyc_rejected_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'rejected_customer_table',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 6],
		"visible": false,
	}],
	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'Kyc Rejected Customer Data',
		text: 'Export',
		className: 'btn btn-primary export_excel_data ',
		exportOptions: {
			columns: [1, 2, 3, 4, 5, 7, 8, 9, 10, 11]
		},

	}]

});


$("#pre_airway_order_bulk").DataTable({
	"serverSide": true,
	"order": [
		[1, "asc"]
	],
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'pre_awb_data',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
			"targets": [0],
			"orderable": false,
			"searchable": false
		},
		{
			"targets": [7],
			"visible": false,
			"searchable": false
		},
		{
			"targets": [8],
			"orderable": false

		}

	],


});

$("#bulk_order_table").DataTable({
	"serverSide": true,
	"order": [
		[1, "asc"]
	],
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'bulk_order_data',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
			"targets": [0],
			"orderable": false,
			"searchable": false
		},
		{
			"targets": [7],
			"visible": false,
			"searchable": false
		},
		{
			"targets": [8],
			"orderable": false

		}

	],

});

/**
 * Order List
 */
$("#order_table").DataTable({
	"processing": true,
	"serverSide": true,
	"pageLength": 50,
	"lengthMenu": [
		[50, 100, 500, 1000, -1],
		[50, 100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'order-list',
	},
	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
			"targets": [0, 9, 10, 12],
			"orderable": false,
			"searchable": false,
		},
		// {
		//     "targets": [12],
		//     "visible": false,
		// }
	],

	"order": [
		[8, "desc"]
	],

	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'All Order List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data export_btn_order_table ',
		exportOptions: {
			columns: "thead th:not(.noExport)",
			//     columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			// columns: 'th:not(:first-child)',
			page: 'all',
		},

	}]


});

/**
 * On process Order List
 */
$("#onprocess_order_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'onprocess-order-list',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],

	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'onProcess Order List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data export_btn_onprocess_order_table ',
		exportOptions: {
			//columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			// columns: 'th:not(:last-child)'
			columns: 'th:not(:first-child)'
		},

	}]

});
/**
 * created Order List
 */

$("#createorder_list").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'created-order-list',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],
	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'Created Order List',
		text: 'Export',
		// className: 'btn btn-primary export_excel_data export_btn_create ',
		className: 'btn btn-primary export_excel_data ',
		exportOptions: {
			//columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			// columns: 'th:not(:last-child)'
			columns: "thead th:not(.noExport)"
		},

	}]

});


/**
 * Error Order List
 */

$("#errororder_list").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'errorOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],
	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'Error Order List',
		text: 'Export',
		className: 'btn btn-primary export_btn_errororder_list ',
		exportOptions: {
			//columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			// columns: 'th:not(:last-child)'
			columns: "thead th:not(.noExport)"
		},

	}]

});

/**
 * Intransit Order List
 */

$("#order_intransit").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'IntransitOrderList',
	},
	"columnDefs": [{
		"targets": [0, 9, 10, 12],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],

	"language": {
		"infoFiltered": "",
	},

	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'intransit Order List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data export_btn_order_intransit ',
		exportOptions: {
			//columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			// columns: 'th:not(:last-child)'
			columns: "thead th:not(.noExport)"
		},

	}]
});

/**
 * OFD Order List
 */

$("#order_ofd").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'ofdOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10, 12],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],
	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'ofd Order List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data export_btn_order_ofd ',
		exportOptions: {
			//columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			// columns: 'th:not(:last-child)'
			columns: "thead th:not(.noExport)"
		},

	}]
});

/**
 * NDR Order List
 */

$("#order_ndr").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'ndrOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10, 12],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],
	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'NDR Order List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data export_btn_order_ndr ',
		exportOptions: {
			//columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			// columns: 'th:not(:last-child)'
			columns: "thead th:not(.noExport)"
		},

	}]
});

/**
 * Delivered Order List
 */

$("#order_delivered").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'deliveredOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],

	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'Delivered Order List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data export_btn_order_delivered ',
		exportOptions: {
			//columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			// columns: 'th:not(:last-child)'
			columns: "thead th:not(.noExport)"
		},

	}]
});

/**
 * RTO Intransit Order List
 */

$("#order_rto_intransit").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'rtoIntransitOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10, 12],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],
	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'rtointransit Order List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data export_btn_order_rto_intransit ',
		exportOptions: {
			//columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			// columns: 'th:not(:last-child)'
			columns: "thead th:not(.noExport)"
		},

	}]
});

/**
 * RTO Delivered Order List
 */

$("#order_rto_delivered").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'rtoDeliveredOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],
	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'rtodelivered Order List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data export_btn_order_rto_delivered ',
		exportOptions: {
			//columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			// columns: 'th:not(:last-child)'
			columns: "thead th:not(.noExport)"
		},

	}]
});


/**
 * On process Order List
 */
$("#pre_awb_onprocess_order_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Pre-awb-onprocessOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],
	// dom: 'lBfrtip',
	// buttons: [{
	//     extend: 'csv',
	//     filename: 'Onprocess Order List',
	//     text: 'Export',
	//     className: 'btn btn-primary export_excel_data preawb_onprocess_data',
	//     exportOptions: {
	//         //     columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
	//         columns: 'th:not(:first-child)'
	//     },

	// }]
});

/**
 * Pre awb Order List
 */
$("#pre_awb_order_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Pre-awb-order-list',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],
	// dom: 'lBfrtip',
	// buttons: [{
	//     extend: 'csv',
	//     filename: 'All Order List',
	//     text: 'Export',
	//     className: 'btn btn-primary export_excel_data preawb_all_data',
	//     exportOptions: {
	//         //     columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
	//         columns: 'th:not(:first-child)'
	//     },

	// }]
});

/**
 * created Order List
 */

$("#preawb_createorder_list").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Pre-awb-createdOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],
	// dom: 'lBfrtip',
	// buttons: [{
	//     extend: 'csv',
	//     filename: 'Created Order List',
	//     text: 'Export',
	//     className: 'btn btn-primary export_excel_data preawb_created_orders_export',
	//     exportOptions: {
	//         //columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
	//         // columns: 'th:not(:last-child)'
	//         columns: "thead th:not(.noExport)"
	//     },

	// }]
});

/**
 * Intransit Order List
 */

$("#pre_awb_order_intransit").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Pre-awb-IntransitOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],
	// dom: 'lBfrtip',
	// buttons: [{
	//     extend: 'csv',
	//     filename: 'Intransit Order List',
	//     text: 'Export',
	//     className: 'btn btn-primary export_excel_data preawb_intransit_orders_export',
	//     exportOptions: {
	//         //columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
	//         // columns: 'th:not(:last-child)'
	//         columns: "thead th:not(.noExport)"
	//     },

	// }]

});

/**
 * OFD Order List
 */

$("#pre_awb_order_ofd").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Pre-awb-ofdOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	],
	// dom: 'lBfrtip',
	// buttons: [{
	//     extend: 'csv',
	//     filename: 'Ofd Order List',
	//     text: 'Export',
	//     className: 'btn btn-primary export_excel_data preawb_ofd_orders_export',
	//     exportOptions: {
	//         columns: "thead th:not(.noExport)"
	//     },

	// }]
});

/**
 * NDR Order List
 */

$("#pre_awb_order_ndr").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Pre-awb-ndrOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	]
});

/**
 * Delivered Order List
 */

$("#pre_awb_order_delivered").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Pre-awb-deliveredOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	]
});

/**
 * RTO Intransit Order List
 */

$("#pre_awb_order_rto_intransit").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Pre-awb-rtoIntransitOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	]
});

/**
 * RTO Delivered Order List
 */

$("#pre_awb_order_rto_delivered").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Pre-awb-rtoDeliveredOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0, 9, 10],
		"orderable": false,
		"searchable": false,
	}],
	"order": [
		[8, "desc"]
	]
});

$("#pre_awb_error_order_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Pre-awb-errorOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0],
		"orderable": false
	}],
	"order": [
		[8, "desc"]
	]
});



$("#waitingorder_list").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'waitingOrderList',
	},

	"language": {
		"infoFiltered": "",
	},
	"columnDefs": [{
		"targets": [0],
		"orderable": false
	}],
	"order": [
		[8, "desc"]
	],
	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'Waiting Order List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data waiting_orders_export export_btn_waitingorder_list ',
		exportOptions: {
			//columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			// columns: 'th:not(:last-child)'
			columns: "thead th:not(.noExport)"
		},

	}]

});

$("#pre_awb_waiting_order_table").DataTable({
	//"info": false,
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'Pre-awb-waitingOrderList',
	},
	"language": {
		"infoFilterd": "",

	},
	"columnDefs": [{
		"targets": [0],
		"orderable": false
	}],
	"order": [
		[8, "desc"]
	],
	// "oLanguage": { "sSearch": "" }
	//"language": { "search": "" },
});

$("#customer_list_table").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'list-customer',
	},
	"columnDefs": [{
		"targets": [4, 5, 6],
		"searchable": false,
		"orderable": false,
	}],

	"language": {
		"infoFiltered": "",
	},
	dom: 'lBfrtip',
	buttons: [{
		extend: 'csv',
		filename: 'Customer List',
		text: 'Export',
		className: 'btn btn-primary export_excel_data',

	}]
});

$("#pre_awb_list").DataTable({
	"serverSide": true,
	"pageLength": 100,
	"lengthMenu": [
		[100, 500, 1000, -1],
		[100, 500, 1000, "All"]
	],
	"ajax": {
		"url": hiddenURL + 'customer-pre-awb-list',
	},

	"language": {
		"infoFiltered": "",
	},

});