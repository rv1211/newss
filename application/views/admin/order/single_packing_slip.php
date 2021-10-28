<!DOCTYPE html>
<html>

<head>
	<style type="text/css">
		.border-div {
			font-size: 19px;
			color: #000000 !important;
			margin-top: 5px;
			padding-top: 8px;
		}

		body {
			font-family: Calibri !important;
		}

		body h3,
		body table {
			font-size: 18px;
		}

		.border-bottom {
			border-bottom: 2px solid;
			margin: 0px;
			padding: 0px;
		}

		.border-right {
			border-right: 2px solid;
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

		.border-div table td {
			padding: 2px 5px;
			margin-top: 6px;
		}

		.border-div table {
			width: 100%;
			margin: 0 auto;
			border: 3px solid;
		}

		.border-div strong {
			font-weight: bolder;
		}

		.small-text {
			font-size: 18px
		}
	</style>
	<title>Packing Slip</title>
</head>


<body>
	<div class="page-container">
		<div class="border-div">
			<table cellpadding="0" class="wrapper-page1" cellspacing="0">
				<tr>
					<td colspan="7" class="border-bottom text-center">
						<h3 style="margin: 5px;">Please call before delivery</h3>
					</td>
				</tr>
				<tr>
					<td colspan="5" class="border-bottom" style="height:130px;" valign="top">
						<?php echo (!empty($single_order['pickup_website'])) ? "order from this Website: " . $order_info['pickup_website'] : "" ?>
						</p>
					</td>
					<td colspan="2" class="border-bottom" style="height:130px; text-align: right;">


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
				</tr>
				<tr>
					<td colspan="7" class="border-bottom"><strong> Note:- No Open Delivery Allowed </strong><br></td>

				</tr>
				<tr>
					<td colspan="4" class="border-bottom" height="25px"><strong>DUTIES/TAXES: RECIPIENT</strong>

					</td>
					<td colspan="3" class="border-bottom text-right">
						<h3 style="margin:8px">Reference No: <?php echo $order_info['customer_order_no']; ?></h3>
					</td>

				</tr>
				<tr>
					<td colspan="3" height="150px" valign="top">
						<strong>SHIP TO:</strong> <br>
						<?php echo $order_info['deliver_name']; ?><br>
						<?php echo wordwrap($order_info['deliver_address_1'] . "," . $order_info['deliver_address_2'], 45, "<br>\n", TRUE); ?><br>
						<?php echo $order_info['deliver_city'] . "<br>" . $order_info['deliver_state'] . "<br> <strong>Pincode :</strong> " . $order_info['deliver_pincode'] . "<br> <strong>Phone No:</strong> " . $order_info['deliver_mobile_no']; ?><br><br><br>

					</td>
					<td colspan="4" style="padding-bottom:0%">
						<strong class="text-center">
							<h1><?php if ($order_info['order_type'] == 0) {
									echo "Prepaid";
								} else {
									echo 'COD<br>' . number_format($order_info['cod_amount'], 2);
								} ?></h1>
						</strong><br>
						<h2>TRK# <?php echo $order_info['awb_number']; ?></h2>
						<input type="hidden" name="test" data-url="<?= base_url() ?>" value="<?= $order_info['airwaybill_barcode_img'] ?>">

						<?php
						$path = $order_info['airwaybill_barcode_img'];
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<img src="<?php echo $base64_img; ?>" width="280" height="110">
					</td>
				</tr>
				<tr>
					<td colspan="3" class="border-bottom text-center"></td>
					<td colspan="4" class="border-bottom">
						<strong>Ship Date: <?= date('d-m-Y', strtotime($order_info['created_date'])); ?></strong><br />
						<strong>Invoice Date:
							<?= date('d-m-Y', strtotime($order_info['created_date'])); ?></strong><br />
						<strong>Invoice No: <?= $order_info['order_no']; ?></strong><br />
						<!-- <strong>Actual Weight: <?= $order_info['physical_weight']; ?></strong><br/> -->

					</td>
				</tr>
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
					<td colspan="3" class="border-bottom border-right text-center" valign="top">
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
						} ?>
					</td>
					<td colspan="1" class="border-bottom text-center" valign="top">
						<?php if ($order_info['order_type'] == 0 || $order_info['order_type'] == '0') {
							$rate = ($order_info['product_value'] * $order_info['product_quantity']);
							echo number_format(@$rate, 2);
						} else {
							$rate = $order_info['cod_amount'] / $order_info['product_quantity'];
							echo number_format($order_info['cod_amount'], 2);
						} ?></td>
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
				<!--<tr class="border-bottom">-->
				<!--</tr>-->
				<!--<tr>-->
				<!--    <td colspan="7" class=" text-left">-->
				<!--        <strong>if there is any product issue please contact:<br><?php  // $order_info['pickup_email']; 
																						?> or-->
				<!--            call: <?php  // $order_info['pickup_contact_no']; 
										?>-->
				<!--            <br>-->
				<!--            Reseller Name : <?php  // $order_info['sender_name']; 
												?>-->
				<!--        </strong>-->
				<!--    </td>-->
				<!--</tr>-->
				<!-- <tr>
                    <td colspan="7"></td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                </tr> -->
				<!-- <tr>
                    <td colspan="7"></td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                </tr> -->
				<tr>
					<td colspan="7" class="border-bottom text-left">
						<p>This is a computer generated invoice and needs no signature</p>
					</td>
				</tr>

			</table>
		</div>
	</div>
</body>

</html>
