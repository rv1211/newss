<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Packing Slip</title>
	<style>
		.border-div {
			font-size: 22px;
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
			font-size: 25px;
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

</head>

<body>
	<div class="page-container">
		<div class="border-div">
			<?php foreach ($order_info as $single_order) { ?>
				<table class="wrapper-page1" width="100%" style="border: none;" cellspacing="0" cellpadding="8">
					<tr style="background:grey; padding:5px;">
						<td style="padding: 5px;"><?php echo $single_order['deliver_name'] ?></td>
						<td style="text-align: center;"><?php if ($single_order['order_type'] == 0) {
															echo "Prepaid";
														} else {
															echo 'COD Collect<br> Amount Rs.' . number_format($single_order['cod_amount'], 2) . '/-';
														} ?></td>
					</tr>
					<tr>
						<td style="text-align:left;">
							<b> <?php echo $single_order['deliver_name']; ?> </b> <br>

							<?php echo wordwrap($single_order['deliver_address_1'] . "," . $single_order['deliver_address_2'], 50, "<br>\n", TRUE); ?>
							<br><?php echo $single_order['deliver_city'] . "," . $single_order['deliver_state'] . "," . $single_order['deliver_pincode'] ?><br>

							Phone No111111111: <?php echo $single_order['deliver_mobile_no']; ?>
						</td>
						<td style="text-align: right;">
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
								<img src="<?php echo base_url() . $single_order['airwaybill_barcode_img1']; ?>" width="300" height="50">
							</div>
						</td>
					</tr>
				</table>
				<div style="margin-bottom:10px;">
				</div>
				<table style="border: 1px solid black;margin-top:2px;" width="100%">
					<tr>
						<td>
							SKU: <b><?php echo $single_order['product_sku']; ?> </b> <br>
							Size: <b><?= $single_order['physical_weight']; ?></b> <br>
							Quantity: <b><?= $single_order['product_quantity']; ?> </b><br>
							Order Number: <b><?= $single_order['order_no']; ?></b><br>
							Description : <b><?= $single_order['product_name']; ?></b>
						</td>
					</tr>
				</table>
				<table width="100%" style="border: none;" cellspacing="0" cellpadding="8">
					<tr>
						<td style="text-align:left; "> <small> Bill To</small> <br>
							<?php echo $single_order['deliver_name']; ?> <br>
							<?php echo wordwrap($single_order['deliver_address_1'] . "," . $single_order['deliver_address_2'], 25, "<br>\n", TRUE); ?>
							<br><?php echo $single_order['deliver_city'] . "," . $single_order['deliver_state'] . "," . $single_order['deliver_pincode'] ?>
						</td>
						<td></td>
						<!-- <td style="text-align:right; font-size:15px">
                        TAX INVOICE <br>
                        <b>Original For Recipient</b>
                    </td> -->
					</tr>
					<tr>
						<td rowspan="2" style="width: 50%;">
							<small>Ship To</small> <br>
							<?php echo $single_order['deliver_name']; ?> <br>
							<?php echo wordwrap($single_order['deliver_address_1'] . "," . $single_order['deliver_address_2'], 25, "<br>\n", TRUE); ?>
						</td>
						<td style="text-align:right">
							<small>Purchase Order Number</small> <br>
							<?php echo  $single_order['deliver_mobile_no']; ?>
						</td>
						<td style="text-align:right">
							<small> Invoice Number</small> <br>
							<?php echo $single_order['order_no']; ?>
						</td>
					</tr>
					<tr>
						<td style="text-align:right;width:30%">
							<small>Invoice Date</small> <br>
							<?php echo date('Y-m-d H:i:s'); ?>
						</td>
						<td style="text-align:right; width:30%;">
							<small> Order Date</small> <br>
							<?php echo $single_order['created_date']; ?>
						</td>
					</tr>
				</table>
				<table width="100%" style="border:1px solid;margin-top:1px;" cellspacing="0" cellpadding="5">
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
							<?php
							$rate = $single_order['cod_amount'] / $single_order['product_quantity'];
							echo number_format(@$rate, 2); ?>
						</td>
						<td colspan="1" class="border-bottom text-center" valign="top">
							<?= number_format($single_order['cod_amount'], 2); ?></td>
					</tr>
					<tr>
						<td colspan="6" class="border-bottom border-right text-left"><strong>TOTAL (Tax Inclusive)</strong>
						</td>
						<td colspan="1" class="border-bottom text-center">
							Rs.<?= number_format($single_order['cod_amount'], 2); ?></td>
					</tr>
					<tr>
						<td colspan="7" class=" text-left">
							<strong>if there is any product issue please contact:<br><?= $single_order['pickup_email']; ?>
								or call: <?= $single_order['pickup_contact_no']; ?></strong><br>
							<br>
							<strong>Return Address : <br></strong>
							<?php echo $single_order['pickup_address_1'] ?><br>
							<?php echo (!empty($single_order['pickup_address_2'])) ? $single_order['pickup_address_2'] . "<br>" : "" ?>
							<?php echo $single_order['pickup_city'] . " ," . $single_order['pickup_state'] . "-" . $single_order['pickup_pincode']; ?>

						</td>
					</tr>
				</table>
			<?php } ?>
		</div>
	</div>
</body>

</html>
