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
			font-size: 21px;
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
			border: 2px solid black;
			border-collapse: collapse;
		}

		th,
		td {
			padding: 8px;
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
	<div class="page-container">
		<div class="border-div">
			<?php foreach ($order_info as $single_order) { ?>
				<table class="table_order wrapper-page1" cellpadding="0" cellspacing="0">
					<tr>
						<td>
							<?php
							$path = "uploads/logo.png";
							$type = pathinfo($path, PATHINFO_EXTENSION);
							$file_data = file_get_contents($path);
							$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
							?>
							<img src="<?php echo $base64_img; ?>" alt="Pack And Drop">
						</td>
						<td><?php if ($single_order['api_name'] == 'Delhivery_Surface' || $single_order['api_name'] == 'Delhivery_Direct' || $single_order['api_name'] == 'Deliverysexpress_Direct') : ?>
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
																echo "Prepaid<br>Rs." . (@$single_order['product_quantity'] * @$single_order['product_value']);
															} else {
																echo "COD<br>Rs." . $single_order['cod_amount'];
															} ?>
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
						<td colspan="3">Note-No Open Delivery Allowed<br>
							<b>Order No.- <?php echo $single_order['customer_order_no']; ?> </b>
						</td>
					</tr>

					<tr>
						<td colspan="2"> Buyer Details :<b> <br>
								<?php echo $single_order['deliver_name'] ?>(<?php echo $single_order['deliver_mobile_no']; ?>)</b><br>
							<?php echo $single_order['deliver_address_1']; ?><br>
							<?php echo $single_order['deliver_address_2']; ?> <br>
							<?php echo $single_order['deliver_city'] . ", " . $single_order['deliver_state'] . "-" . $single_order['deliver_pincode']; ?>
							<br>
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
							?>
						</td>
					</tr>
					<tr>
						<td class="td" colspan="3" style="text-align:center;">
							<?php
							$path = $single_order['airwaybill_barcode_img1'];
							$type = pathinfo($path, PATHINFO_EXTENSION);
							$file_data = file_get_contents($path);
							$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
							?>
							<img src="<?php echo  $base64_img;  ?>" width="400" height="120">
						</td>
					</tr>
					<tr>
						<td class="td" colspan="3" style="text-align:center;"><?php echo $single_order['awb_number']; ?>
						</td>
					</tr>
					<tr>
						<td colspan="3" style="text-align:left;">
							If not Deliverd so please Return at below address :- <br>
							<b><?php echo $single_order['pickup_name'] ?>(<?php echo $single_order['pickup_email']; ?>)</b><br>
							<b>Address :</b><?php echo $single_order['pickup_address_1']; ?><br>
							<?php echo $single_order['pickup_address_2']; ?><br>
							<?php echo $single_order['pickup_state'] . ',' . $single_order['pickup_pincode']; ?><br>
							<b> Contact Number </b>: <?php echo $single_order['pickup_contact_no']; ?>
						</td>
					</tr>
				</table>
			<?php } ?>
		</div>
	</div>
	</div>
</body>

</html>
