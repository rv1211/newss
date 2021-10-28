<html>

<head>
	<style type="text/css">
		body {
			font-size: 10;
		}

		.margin-10 {
			margin: 10px;
		}

		.margin-10-0 {
			margin: 10px 0px;
		}

		.margin-20-0 {
			margin: 20px 0px;
		}

		table td {
			padding: 4px 10px;
		}

		table th {
			padding: 4px 10px;
		}

		table {
			width: 100%;
			border-top: 1px solid;
			border-right: 1px solid;
			border-left: 1px solid;
		}

		.border-bottom {
			border-bottom: 1px solid;
		}

		.border-right {
			border-right: 1px solid;
		}

		.border-top {
			border-top: 1px solid;
		}

		table tr:last-child {
			border-bottom: 0px solid;
		}

		.text-center {
			text-align: center;
		}

		.text-left {
			text-align: left;
		}

		.text-right {
			text-align: right;
		}

		.footer {
			position: fixed;
			bottom: 45;
		}

		.wrapper-page1 {
			page-break-before: always;
		}

		.wrapper-page1:first-child {
			page-break-before: avoid;
		}
	</style>
	<title>Manifest</title>
</head>

<body>
	<div>
		<div class="margin-10-0">
			<strong>Company Name:</strong> <?php echo @$order['user_result']->name; ?>
		</div>
		<div class="margin-10-0">
			<strong>GST No:</strong> <?php echo @$order['user_kyc_result']->gst_no; ?>
		</div>
		<div class="margin-10-0">
			<strong>Date :</strong> <?php echo date("d-m-Y"); ?>
		</div>
		<hr>

		<?php foreach ($order['order_info'] as $key => $single_logistic) { ?>

			<div class="wrapper-page1">
				<div class="margin-20-0">
					<?php $arr = explode('_', $order['order_info'][$key]['api_name_display']);
					$logistic_name = $arr[0];
					?>
					<strong>Courier Name:</strong> <?= $logistic_name; ?>
				</div>
				<table cellpadding="0" cellspacing="0" class="" width="100%">
					<thead>
						<tr>
							<th class="border-bottom border-right border-top" width="5%">Sr. No.</th>
							<th class="border-bottom border-right border-top" width="20%">Order ID</th>
							<th class="border-bottom border-right border-top" width="5%">Order Type</th>
							<th class="border-bottom border-right border-top" width="5%">Customer Name</th>
							<th class="border-bottom border-right border-top" width="15%">Awb No</th>
							<th class="border-bottom border-right border-top" width="50%">AWB Barcode</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1;
						foreach ($order['order_info'][$key]['info'] as $single_order) {
							if (@$single_order['order_type'] == '0') {
								$order_type = "PREPAID";
							} else {
								$order_type = "COD";
							}
						?>
							<tr>
								<td class="border-bottom border-right" width="5%"><?php echo $i; ?></td>
								<td class="border-bottom border-right" width="20%"><?php echo @$single_order['order_no']; ?>
								</td>
								<td class="border-bottom border-right" width="5%"><?php echo strtoupper($order_type); ?></td>
								<td class="border-bottom border-right" width="5%"><?php echo @$single_order['deliver_name']; ?>
								</td>
								<td class="border-bottom border-right" width="15%"><?php echo @$single_order['awb_number']; ?>
								</td>
								<td class="border-bottom" width="50%">
									<?php
									$path = $single_order['logistic_name_display']; //base_url('uploads/order_barcode/69.jpg'); ;
									$type = pathinfo($path, PATHINFO_EXTENSION);
									$file_data = file_get_contents($path);
									$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
									?>
									<img src="<?php echo $base64_img; ?>" width="150" height="50">
								</td>
							</tr>
						<?php $i++;
						} ?>
					</tbody>
				</table>
			</div>
			<div class="footer">
				<div>
					<table style="border: 0px" width="100%">
						<tr>
							<td width="50%" class="text-left">
								<span style="text-align: left;" class="border-top text-left">Vendor Company Seal &
									Sign</span>
							</td>
							<td class="text-right">
								<span style="text-align: right;" class="border-top text-right">Courier Company Seal &
									Sign</span>
							</td>
						</tr>
					</table>
				</div>
				<div class="text-center" style="margin-top:15px;border-top: 2px solid">
					<div style="margin-top:10px;">
						<small>Shipping Manifest generated using Shipsecurelogistics.com.</small></small>
					</div>
					<div>
						<small>
							<!-- Tel.: +91-22-40166997 --> Email: support@shipsecurelogistics.com website:<a href="<?= base_url(); ?>">www.shipsecurelogistics.com</a>
						</small>
					</div>
				</div>
			</div>
		<?php } ?>

	</div>
	</div>
</body>

</html>
