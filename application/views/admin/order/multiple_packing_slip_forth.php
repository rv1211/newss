<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Packing Slip</title>
	<style>
		body {
			font-family: Calibri !important;
			font-size: 20px;
		}

		body h3,
		body table {
			font-size: 22px;
		}

		table {
			width: 100%;
		}

		thead {
			background-color: #daedf1;
		}

		.thead {
			background-color: #daedf1;
		}

		table,
		th,
		td {
			border: 1px solid black;
			border-collapse: collapse;
		}

		th,
		td {
			padding: 13px;
			text-align: left;
		}

		/* .table_order, */
		.td {
			border: none;
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
	<div class="row">
		<div class="page-container">
			<div class="border-div">
				<?php foreach ($order_info as $single_order) { ?>
					<table class="table_order wrapper-page1" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="2"><?php if ($single_order['api_name'] == 'Delhivery_Surface' || $single_order['api_name'] == 'Delhivery_Direct' || $single_order['api_name'] == 'Deliverysexpress_Direct') : ?>
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
							<td style="text-align:center;"><b><?php if ($single_order['order_type'] == 0) {
																	echo "Prepaid";
																} else {
																	echo "COD<br>Rs." . $single_order['cod_amount'];
																} ?></b>

							</td>
						</tr>
						<tr>
							<td colspan="3">
								<h4>Product Name : <?php echo $single_order['product_name']; ?><br>
									Quantity : <?php echo $single_order['product_quantity']; ?><br>
									Sku : <?php echo $single_order['product_sku']; ?>
								</h4>
							</td>
						</tr>
						<tr>
							<td colspan="3">Note-No Open Delivery Allowed <br>
								<b>Order No.- <?php echo $single_order['customer_order_no']; ?> </b>
							</td>
						</tr>
						<!-- <tr>
                <td class="td" colspan="2"></td>
                <td></td>
            </tr> -->
						<tr>
							<td colspan="2"> Buyer Details :<b> <br>
									<?php echo $single_order['deliver_name'] ?>(<?php echo $single_order['deliver_mobile_no']; ?>)</b><br>
								<?php echo $single_order['deliver_address_1']; ?><br>
								<?php echo $single_order['deliver_address_2']; ?> <br>
								<?php echo $single_order['deliver_city'] . ", " . $single_order['deliver_state'] . "-" . $single_order['deliver_pincode']; ?>
								<br><br />
								<b>Contact Number : </b>
								<?php echo $single_order['deliver_mobile_no']; ?>
							</td>
							<td style="text-align: center;">
								<h3><?php echo $single_order['deliver_state'] ?></h3>
								<h3><?php echo $single_order['deliver_pincode']; ?></h3>
							</td>
						</tr>
						<tr>
							<td class="td" colspan="3" style="text-align:center;">
								<?php //echo $single_order['logistic_name']; 
								?></td>
						</tr>
						<tr>
							<td class="td" colspan="3" style="text-align:center;">
								<?php
								$path = $single_order['airwaybill_barcode_img1'];
								$type = pathinfo($path, PATHINFO_EXTENSION);
								$file_data = file_get_contents($path);
								$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
								?>
								<img src="<?php echo $base64_img; ?>" width="400" height="90">
							</td>
						</tr>
						<tr>
							<td class="td" colspan="3" style="text-align:center;"><?php echo $single_order['awb_number']; ?>
							</td>
						</tr>

					</table>
				<?php } ?>
			</div>
		</div>
	</div>
</body>

</html>
