<!DOCTYPE html>
<html>

<head>
	<title>Packing Slip</title>
	<style type="text/css">
		.border-div {
			font-size: 20px;
			color: #000000 !important;
			margin-top: 2px;
			padding-top: 2px;
		}

		body {
			font-family: Calibri !important;
		}

		body h3,
		body table {
			font-size: 20px;
		}

		.border-bottom {
			border-bottom: 2px solid;
			margin: 0px;
			padding: 0px;
		}

		.border-right {
			border-right: 1px solid;
		}

		/* .barcode-img {
            width: 100%;
        } */

		.text-center {
			text-align: center;
		}

		.text-left {
			text-align: left;
		}

		.text-right {
			text-align: right;
		}

		.border-div table td {
			padding: 3px 4px;
			margin-top: 1px;
		}

		.border-div table {
			width: 100%;
			margin: 0 auto;
			border: 2px solid;
		}

		.border-div strong {
			font-weight: bolder;
		}

		.small-text {
			font-size: 20px
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
				<table cellpadding="0" class="wrapper-page1" cellspacing="0">
					<tr>
						<td colspan="7" class="border-bottom text-center">
							<h3 style="margin: 5px;">Please call before delivery</h3>
						</td>
					</tr>
					<tr>
						<td colspan="7" class="border-bottom" style="height:130px; text-align: right;">
							<?php if ($single_order['api_name'] == 'Delhivery_Surface' || $single_order['api_name'] == 'Delhivery_Direct' || $single_order['api_name'] == 'Deliverysexpress_Direct') : ?>
								<?php
								$path = "assets/custom/img/delhivery.jpg";
								$type = pathinfo($path, PATHINFO_EXTENSION);
								$file_data = file_get_contents($path);
								$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
								?>
								<img src="<?php echo $base64_img; ?>" width="200" height="80">
							<?php endif; ?>
							<?php if ($single_order['api_name'] == 'Xpressbees_Surface' || $single_order['api_name'] == 'Xpressbees_Direct' || $single_order['api_name'] == 'Xpressbeesair_Direct') : ?>

								<?php
								$path = "assets/custom/img/xpressbees.jpg";
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
								<img src="<?php echo $base64_img; ?>" width="200" height="80">
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
					</tr>
					<tr>
						<td colspan="7" class="border-bottom"><strong>Note-No Open Delivery Allowed </strong><br>

						</td>
					</tr>
					<tr>
						<td colspan="3" class="border-bottom" height="35px"><strong>DUTIES/TAXES: RECIPIENT</strong>

						</td>
						<td colspan="4" class="border-bottom text-right">
							<h3 style="margin:3px">Reference No: <?php echo $single_order['customer_order_no']; ?></h3>
						</td>
					</tr>
					<tr>
						<td colspan="5" height="180px" valign="top">
							<strong>SHIP TO:</strong> <br>
							<?php echo $single_order['deliver_name']; ?><br>
							<?php echo wordwrap($single_order['deliver_address_1'] . "," . @$single_order['deliver_address_2'], 50, "<br>\n", TRUE); ?><br>
							<?php echo wordwrap($single_order['deliver_city'] . "," . @$single_order['deliver_state'] . "<br><strong>Pincode:</strong>" . @$single_order['deliver_pincode'] . "<br><strong>PhoneNo:</strong>" . @$single_order['deliver_mobile_no'] . "<br>\n", 35, TRUE); ?><br><br>

						</td>
						<td colspan="2" style="padding-bottom:0%;text-align:right">
							<strong class="text-center">
								<h3><?php if ($single_order['order_type'] == 0) {
										echo "Prepaid";
									} else {
										echo 'COD<br>' . number_format($single_order['cod_amount'], 2);
									} ?></h3>
							</strong><br>
							<h5>TRK# <?php echo $single_order['awb_number']; ?></h5>
							<?php
							$path = $single_order['airwaybill_barcode_img1'];
							$type = pathinfo($path, PATHINFO_EXTENSION);
							$file_data = file_get_contents($path);
							$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
							?>
							<img src="<?php echo $base64_img;  ?>" width="400" height="120">
						</td>
					</tr>
					<tr>
						<td colspan="3" class="border-bottom text-center"></td>
						<td colspan="4" class="border-bottom" style="text-align: right;">
							<strong>Ship Date:
								<?= date('d-m-Y', strtotime($single_order['created_date'])); ?></strong><br />
							<strong>Invoice Date:
								<?= date('d-m-Y', strtotime($single_order['created_date'])); ?></strong><br />
							<strong>Invoice No: <?= $single_order['order_no']; ?></strong>

						</td>
					</tr>
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
						</td>
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
					<!-- <tr>
                    <td colspan="7" class=" text-left" style="font-size: 13px;">
                        <strong>if there is any product issue please contact:<br><?= $single_order['pickup_email']; ?>
                            or call: <?= $single_order['pickup_contact_no']; ?>
                            <br>
                            Reseller Name : <?= $single_order['sender_name']; ?>
                        </strong>
                    </td>
                </tr> -->
					<tr>
						<td colspan="7" class="border-bottom text-left">
							<p>This is a computer generated invoice and needs no signature</p>
						</td>
					</tr>

				</table>
			<?php } ?>
		</div>
	</div>
</body>

</html>
