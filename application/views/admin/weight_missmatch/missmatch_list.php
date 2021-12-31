<!-- <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable"> -->
<table class="table  dataTable table-striped" id="missmatch_list_table">
	<thead>
		<tr>
			<th>Oreder Id</th>
			<th>Order Number</th>
			<th>Email</th>
			<th>AWB No</th>
			<th>Date</th>
			<th>Logistic</th>
			<th>Customer Weight</th>
			<th>Actual Weight</th>
			<th>Debited Rate</th>
			<th>Actual Rate</th>
			<th>Diffrence</th>
			<th>Remarks</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($final_array as $record) : ?>
			<tr>
				<td><?php echo $record['order_no']; ?></td>
				<td><?php echo $record['customer_order_no']; ?></td>
				<td><?php echo $record['email']; ?></td>
				<td><?php echo $record['awb_number']; ?></td>
				<td><?php echo $record['created_date']; ?></td>
				<td><?php echo $record['logistic_name']; ?></td>
				<td><?php echo (($record['physical_weight'] > $record['volumetric_weight']) ? $record['physical_weight'] : $record['volumetric_weight']); ?></td>
				<td><?php echo $record['actual_weight']; ?></td>
				<td>RS. <?php echo number_format($record['total_shipping_amount'], 2); ?></td>
				<td>RS.<?php echo number_format($record['subtotal'], 2); ?></td>
				<td> RS.<?php echo number_format($record['subtotal'] - $record['total_shipping_amount'], 2); ?></td>
				<td> <?php echo $record['remarks']; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<!-- End Page -->
<script>
	$("#missmatch_list_table").DataTable({
		"pageLength": 10,
		"lengthMenu": [
			[10, 25, 50, 100, -1],
			[10, 25, 50, 100, "All"]
		],
		"language": {
			"infoFiltered": "",
		},
		dom: 'lBfrtip',
		buttons: [{
			extend: 'csv',
			filename: 'Missmatch List',
			text: 'Export',
			className: 'btn btn-primary export_btn_errororder_list ',
			exportOptions: {
				//columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
				// columns: 'th:not(:last-child)'
				columns: "thead th:not(.noExport)"
			},

		}]

	});
</script>
