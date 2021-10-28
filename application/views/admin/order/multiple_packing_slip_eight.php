<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Packing Slip</title>
	<style>
		.border-div {
			font-size: 19px;
			color: #000000 !important;
			margin-top: 0px;
			padding-top: 0px;
		}

		body {
			font-family: Calibri !important;
		}

		.border-bottom {
			border-bottom: 1px solid;
			margin: 0px;
			padding: 0px;
		}

		.border-right {
			border-right: 1px solid;
		}

		.border-left {
			border-left: 1px solid;
		}

		.barcode-img {
			width: 100%;
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

		hr.new1 {
			border: 1px dotted black;
		}

		small {
			font-size: 19px;
		}

		.font-med {
			font-size: 20px;
		}


		.wrapper-page1 {
			page-break-before: always;
		}

		.wrapper-page1:first-child {
			page-break-before: avoid;
		}
	</style>
	<title>Packing Slip</title>
</head>

<body>
	<div class="page-container">
		<div class="border-div">
			<?php foreach ($order_info as $single_order) { ?>
				<table class="wrapper-page1" width="100%" style="border: none;" cellspacing="0" cellpadding="8">
					<tr style="padding:3px;">
						<?php
						$path = 'uploads/logo.png';
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<td>
							<?php if ($single_order['api_name'] == 'Delhivery_Surface' || $single_order['api_name'] == 'Delhivery_Direct' || $single_order['api_name'] == 'Deliverysexpress_Direct') : ?>
								<?php
								$path = 'assets/custom/img/delhivery.jpg';
								$type = pathinfo($path, PATHINFO_EXTENSION);
								$file_data = file_get_contents($path);
								$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
								?>
								<img src="<?php echo $base64_img; ?>" width="200" height="80">
							<?php endif; ?>

							<?php if ($single_order['api_name'] == 'Xpressbees_Surface' || $single_order['api_name'] == 'Xpressbees_Direct' || $single_order['api_name'] == 'Xpressbeesair_Direct') : ?>
								<?php
								$path = 'assets/custom/img/xpressbees.jpg';
								$type = pathinfo($path, PATHINFO_EXTENSION);
								$file_data = file_get_contents($path);
								$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
								?>
								<img src="<?php echo $base64_img; ?>" width="200" height="80">
							<?php endif; ?>

							<?php if ($single_order['api_name'] == 'Ekart_Surface' || $single_order['api_name'] == 'Ecart_air') : ?>
								<?php
								$path = "assets/custom/img/ekart.jpg";
								$type = pathinfo($path, PATHINFO_EXTENSION);
								$file_data = file_get_contents($path);
								$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
								?>
								<img src="<?php echo $base64_img ?>" width="200" height="80">
							<?php endif; ?>

							<?php if ($single_order['api_name'] == 'Ecom_Direct') : ?>
								<?php
								$path = "assets/custom/img/ecom.jpg";
								$type = pathinfo($path, PATHINFO_EXTENSION);
								$file_data = file_get_contents($path);
								$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
								?>
								<img src="<?php echo $base64_img ?>" width="200" height="80">
							<?php endif; ?>


							<?php if ($single_order['api_name'] == 'Udaan_Direct') : ?>
								<?php
								$path = "assets/custom/img/uddan.jpg";
								$type = pathinfo($path, PATHINFO_EXTENSION);
								$file_data = file_get_contents($path);
								$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
								?>
								<img src="<?php echo $base64_img ?>" width="200" height="80">
							<?php endif; ?>


							<?php if ($single_order['api_name'] == 'Shadowfax_Direct') : ?>
								<?php
								$path = "assets/custom/img/shadowfax.jpg";
								$type = pathinfo($path, PATHINFO_EXTENSION);
								$file_data = file_get_contents($path);
								$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
								?>
								<img src="<?php echo $base64_img ?>" width="200" height="80">
							<?php endif; ?>

						</td>
						<?php
						$path = 'uploads/logo.png';
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<td><img src="<?php echo $base64_img; ?>" alt="Pack And Drop"></td>
						<td style="text-align: center;"><?php if ($single_order['order_type'] == 0) {
															echo "Prepaid";
														} else {
															echo 'COD Collect<br> Amount Rs.' . number_format($single_order['cod_amount'], 2) . '/-';
														} ?></td>
					</tr>
					<tr>
						<td colspan="1" style="text-align:left;">
							<b> <?php echo $single_order['deliver_name']; ?> </b> <br>
							<small>
								<?php echo wordwrap($single_order['deliver_address_1'] . "," . $single_order['deliver_address_2'], 45, "<br>\n", TRUE); ?>
								<br><?php echo $single_order['deliver_city'] . "," . $single_order['deliver_state'] . "," . $single_order['deliver_pincode'] ?><br>
							</small>
							Phone No: <?php echo $single_order['deliver_mobile_no']; ?>
						</td>
						<td colspan="2" style="text-align: right;">
							<!-- <b><?php //echo $single_order['logistic_name']; 
									?></b> <br> -->
							Destination Code: <?php echo $single_order['deliver_pincode']; ?><br>
							Return Code : <?php echo $single_order['pickup_pincode']; ?>
						</td>
					</tr>
				</table>
				<table cellspacing="0" cellpadding="8">
					<tr>
						<td></td>
						<td>
							<div style="margin-left:300;">
								<?php echo $single_order['awb_number']; ?> <br>
							</div>
							<div style="margin-left: 200; padding-left:80;">
								<?php
								$path =  $single_order['airwaybill_barcode_img1'];
								$type = pathinfo($path, PATHINFO_EXTENSION);
								$file_data = file_get_contents($path);
								$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
								?>
								<img src="<?php echo $base64_img; ?>" width="300" height="50">
							</div>
						</td>
					</tr>
				</table>
				<div style="margin-bottom:3px;">
				</div>
				<table style="border: 1px solid black;margin-top:2px;" width="100%">
					<tr>
						<td colspan="3">
							<b>SKU: </b><?php echo $single_order['product_sku']; ?> <br>
							<b>Quantity:</b> <?= $single_order['product_quantity']; ?>

						</td>
						<td colspan="4">

							<b>Order Number: </b><?= $single_order['customer_order_no']; ?><br>
							<b>Description :</b> <?= $single_order['product_name']; ?>
						</td>
					</tr>
				</table>
				<table width="100%" style="border: none;" cellspacing="0" cellpadding="8">

					<tr>
						<td rowspan="2" style="width: 50%;">
							<b><small>Ship To</small></b> <br>
							<?php echo $single_order['deliver_name']; ?> <br>
							<?php echo wordwrap($single_order['deliver_address_1'] . "," . $single_order['deliver_address_2'], 40, "<br>\n", TRUE); ?>
						</td>
						<td style="text-align:right">
							<b><small>Purchase Order Number</small> </b><br>
							<?php echo  $single_order['deliver_mobile_no']; ?>
						</td>
						<td style="text-align:right">
							<b><small> Invoice Number</small> </b><br>
							<?php echo $single_order['order_no']; ?>
						</td>
					</tr>
					<tr>
						<td style="text-align:right;width:30%">
							<b><small>Invoice Date</small> </b><br>
							<?php echo date('Y-m-d H:i:s'); ?>
						</td>
						<td style="text-align:right; width:30%;">
							<b><small> Order Date</small></b> <br>
							<?php echo $single_order['created_date']; ?>
						</td>
					</tr>
				</table>
				<table width="100%" style="border:1px solid;margin-top:1px;" cellspacing="0" cellpadding="8">
					<tr>
						<td colspan="7" class="border-bottom text-center"><strong style="margin-left: 20px">RETAIL
								INVOICE</strong></td>
					</tr>
					<tr>
						<td colspan="1" class="border-bottom border-right text-center"><strong>SL NO:</strong></td>
						<td colspan="3" class="border-bottom border-right text-center" width="200"><strong>SHIPMENT</strong>
						</td>
						<td colspan="1" class="border-bottom border-right text-center"><strong>QTY</strong></td>
						<td colspan="1" class="border-bottom border-right text-center"><strong>RATE (INR)</strong></td>
						<td colspan="1" class="border-bottom text-center"><strong>AMOUNT (INR)</strong></td>
					</tr>
					<tr>
						<td colspan="1" class="border-bottom border-right text-center" height="100px" valign="top">1</td>
						<td colspan="3" class="border-bottom border-right text-center" valign="top">
							<?php echo $single_order['product_name']; ?></td>
						<td colspan="1" class="border-bottom border-right text-center" valign="top">
							<?= $single_order['product_quantity']; ?></td>
						<td colspan="1" class="border-bottom border-right text-center" valign="top">
							<?php if ($single_order['order_type'] == 0 || $single_order['order_type'] == '0') {
								$rate = @$single_order['product_value'];
								echo number_format(@$rate, 2);
							} else {
								$rate = $single_order['cod_amount'] / $single_order['product_quantity'];
								echo number_format(@$rate, 2);
							}
							?>
						</td>
						<td colspan="1" class="border-bottom text-center" valign="top">
							<?php
							if ($single_order['order_type'] == 0 || $single_order['order_type'] == '0') {
								$rate = ($single_order['product_quantity'] * $single_order['product_value']);
								echo number_format(@$rate, 2);
							} else {
								echo number_format($single_order['cod_amount'], 2);
							}
							?>
					</tr>
					<tr>
						<td colspan="6" class="border-bottom border-right text-left"><strong>TOTAL (Tax Inclusive)</strong>
						</td>
						<td colspan="1" class="border-bottom text-center">
							Rs.<?php
								if ($single_order['order_type'] == 0 || $single_order['order_type'] == '0') {
									$rate = ($single_order['product_quantity'] * $single_order['product_value']);
									echo number_format(@$rate, 2);
								} else {
									echo number_format($single_order['cod_amount'], 2);
								}
								?></td>
					</tr>
				</table>
				<table style="border: 1px solid black;margin-top:15px;" width="100%">
					<tr>
						<td style="text-align:left;border-top:10px;"> <b><small> Shipped From</small> </b><br>
							<?php echo $single_order['sender_name']; ?> <br>
							<?php echo $single_order['pickup_email']; ?> <br>
							<?php echo $single_order['pickup_contact_no']; ?> <br>
						</td>
					</tr>
				</table>
			<?php } ?>
		</div>
	</div>
</body>

</html>
