<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Packing Slip</title>
	<style>
		.border-div {
			font-size: 20px;
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
			font-size: 20px;
		}

		.font-med {
			font-size: 20px;
		}
	</style>

</head>

<body>
	<div class="page-container">
		<div class="border-div">
			<table class="wrapper-page1" width="100%" style="border: none;" cellspacing="0" cellpadding="5">

				<tr style="padding:5px;">

					<?php
					$path = 'uploads/logo.png';
					$type = pathinfo($path, PATHINFO_EXTENSION);
					$file_data = file_get_contents($path);
					$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
					?>

					<td>
						<?php if ($order_info['api_name'] == 'Delhivery_Surface' || $order_info['api_name'] == 'Delhivery_Direct' || $order_info['api_name'] == 'Deliverysexpress_Direct') : ?>
							<?php
							$path = 'assets/custom/img/delhivery.jpg';
							$type = pathinfo($path, PATHINFO_EXTENSION);
							$file_data = file_get_contents($path);
							$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
							?>
							<img src="<?php echo $base64_img; ?>" width="200" height="80">
						<?php endif; ?>

						<?php if ($order_info['api_name'] == 'Xpressbees_Surface' || $order_info['api_name'] == 'Xpressbees_Direct' || $order_info['api_name'] == 'Xpressbeesair_Direct') : ?>
							<?php
							$path = 'assets/custom/img/xpressbees.jpg';
							$type = pathinfo($path, PATHINFO_EXTENSION);
							$file_data = file_get_contents($path);
							$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
							?>
							<img src="<?php echo $base64_img; ?>" width="200" height="80">
						<?php endif; ?>

						<?php if ($order_info['api_name'] == 'Ekart_Surface' || $order_info['api_name'] == 'Ecart_air') : ?>
							<?php
							$path = "assets/custom/img/ekart.jpg";
							$type = pathinfo($path, PATHINFO_EXTENSION);
							$file_data = file_get_contents($path);
							$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
							?>
							<img src="<?php echo $base64_img ?>" width="200" height="80">
						<?php endif; ?>

						<?php if ($order_info['api_name'] == 'Ecom_Direct') : ?>
							<?php
							$path = "assets/custom/img/ecom.jpg";
							$type = pathinfo($path, PATHINFO_EXTENSION);
							$file_data = file_get_contents($path);
							$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
							?>
							<img src="<?php echo $base64_img ?>" width="200" height="80">
						<?php endif; ?>


						<?php if ($order_info['api_name'] == 'Udaan_Direct') : ?>
							<?php
							$path = "assets/custom/img/uddan.jpg";
							$type = pathinfo($path, PATHINFO_EXTENSION);
							$file_data = file_get_contents($path);
							$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
							?>
							<img src="<?php echo $base64_img ?>" width="200" height="80">
						<?php endif; ?>
						<?php if ($order_info['api_name'] == 'Shadowfax_Direct') : ?>
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
					<td><img src="<?php echo $base64_img; ?>" height="80" width="200" alt="ShipSecure"></td>
					<td style="text-align: center;"><?php if ($order_info['order_type'] == 0 || $order_info['order_type'] == "0") {
														echo "Prepaid<br>Rs." . (@$order_info['product_quantity'] * @$order_info['product_value']);
													} else {
														echo "COD<br>Rs." . $order_info['cod_amount'];
													} ?></td>
				</tr>
				<tr>
					<td style="text-align:left;">
						<b> <?php echo $order_info['deliver_name']; ?> </b> <br>
						<small>
							<?php echo wordwrap($order_info['deliver_address_1'] . "," . $order_info['deliver_address_2'], 30, "<br>\n", TRUE); ?>
							<br><?php echo $order_info['deliver_city'] . "," . $order_info['deliver_state'] . "," . $order_info['deliver_pincode'] ?><br>
						</small>
						Phone No: <?php echo $order_info['deliver_mobile_no']; ?>
					</td>
					<td style="text-align: right;">
						<!-- <b><?php // echo $order_info['logistic_name']; 
								?></b> <br> -->
						Destination Code: <?php echo $order_info['deliver_pincode']; ?><br>
						Return Code : <?php echo $order_info['pickup_pincode']; ?>
					</td>
				</tr>
			</table>
			<table cellspacing="0" cellpadding="5">
				<tr>
					<td></td>
					<td>
						<div style="margin-left:300;">
							<?php echo $order_info['awb_number']; ?> <br>
						</div>
						<div style="margin-left: 200; padding-left:80;">
							<?php
							$path = $order_info['airwaybill_barcode_img'];
							$type = pathinfo($path, PATHINFO_EXTENSION);
							$file_data = file_get_contents($path);
							$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
							?>
							<img src="<?php echo $base64_img; ?>" width="300" height="50">
						</div>
					</td>
				</tr>
			</table>
			<div style="margin-bottom:15px;">
			</div>
			<table style="border: 1px solid black;margin-top:7px;" width="100%">
				<tr>
					<td>
						SKU: <b><?php echo $order_info['product_sku']; ?> </b> <br>
						Quantity: <b><?= $order_info['product_quantity']; ?> </b><br>
						Order Number: <b><?= $order_info['customer_order_no']; ?></b><br>
						Description : <b><?= $order_info['product_name']; ?></b>
					</td>
				</tr>
			</table>
			<table width="100%" style="border: none;" cellspacing="0" cellpadding="5">

				<tr>
					<td rowspan="2" style="width: 50%;">
						<b> <small>Ship To</small></b> <br>
						<?php echo $order_info['deliver_name']; ?> <br>
						<?php echo wordwrap($order_info['deliver_address_1'] . "," . $order_info['deliver_address_2'], 30, "<br>\n", TRUE); ?>
					</td>
					<td style="text-align:right;margin-right:1px;">
						<b><small>Purchase Order Number</small></b> <br>
						<?php echo  $order_info['deliver_mobile_no']; ?>
					</td>
					<td style="text-align:right">
						<b> <small> Invoice Number</small> </b><br>
						<?php echo $order_info['customer_order_no']; ?>
					</td>
				</tr>
				<tr>
					<td style="text-align:right;width:30%">
						<b><small>Invoice Date</small></b> <br>
						<?php echo date('Y-m-d H:i:s'); ?>
					</td>
					<td style="text-align:right; width:30%;">
						<b><small> Order Date</small> </b><br>
						<?php echo $order_info['created_date']; ?>
					</td>
				</tr>
			</table>
			<table width="100%" style="border:1px solid;margin-top:5px;" cellspacing="0" cellpadding="5">

				<tr>
					<td colspan="7" class="border-bottom text-center"><strong style="margin-left: 20px">RETAIL
							INVOICE</strong></td>
					<!-- <td colspan="1" class="border-bottom">
                        <strong><small>GSTIN:</small></strong><?php echo @$order_info['gst_no']; ?>
                    </td> -->
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
					<td colspan="3" style="font-size:17px;" class="border-bottom border-right text-center" valign="top">
						<?php echo $order_info['product_name']; ?></td>
					<td colspan="1" class="border-bottom border-right text-center" valign="top">
						<?= $order_info['product_quantity']; ?></td>
					<td colspan="1" class="border-bottom border-right text-center" valign="top">
						<?php if ($order_info['order_type'] == 0 || $order_info['order_type'] == '0') {
							$rate = @$order_info['product_value'];
							echo number_format(@$rate, 2);
						} else {
							$rate = $order_info['cod_amount'] / $order_info['product_quantity'];
							echo number_format(@$rate, 2);
						}
						?>
					</td>
					<td colspan="1" class="border-bottom text-center" valign="top">
						<?php
						if ($order_info['order_type'] == 0 || $order_info['order_type'] == '0') {
							$rate = ($order_info['product_quantity'] * $order_info['product_value']);
							echo number_format(@$rate, 2);
						} else {
							echo number_format($order_info['cod_amount'], 2);
						}
						?>
				</tr>
				<tr>
					<td colspan="6" class="border-bottom border-right text-left"><strong>TOTAL (Tax Inclusive)</strong>
					</td>
					<td colspan="1" class="border-bottom text-center">
						Rs.<?php
							if ($order_info['order_type'] == 0 || $order_info['order_type'] == '0') {
								$rate = ($order_info['product_quantity'] * $order_info['product_value']);
								echo number_format(@$rate, 2);
							} else {
								echo number_format($order_info['cod_amount'], 2);
							}
							?></td>
				</tr>

			</table>
			<table style="border: 1px solid black;margin-top:20px;" width="100%">
				<tr>
					<td colspan="1" style="text-align:left;"> <b><small> Shipped From :</small> </b><br>
						<?php echo $order_info['sender_name']; ?> <br>
						<?php echo $order_info['pickup_email']; ?> <br>
						<?php echo $order_info['pickup_contact_no']; ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>

</html>
