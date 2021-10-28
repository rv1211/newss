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
			padding: 10px;
			text-align: left;
		}

		/* .table_order, */
		.td {
			border: none;
		}
	</style>
</head>

<body>
	<div class="row">
		<table class="table_order" cellpadding="0" class="wrapper-page1" cellspacing="0">
			<tr>
				<?php
				$path = 'uploads/logo.png';
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$file_data = file_get_contents($path);
				$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
				?>
				<td><img src="<?php echo $base64_img; ?>" height="80" width="200" alt="Shipsecure"></td>
				<td><?php if ($order_info['api_name'] == 'Delhivery_Surface' || $order_info['api_name'] == 'Delhivery_Direct' || $order_info['api_name'] == 'Deliverysexpress_Direct') : ?>
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
				<td style="text-align:center;"><b><?php if ($order_info['order_type'] == 0 || $order_info['order_type'] == "0") {
														echo "Prepaid<br>Rs." . (@$order_info['product_quantity'] * @$order_info['product_value']);
													} else {
														echo "COD<br>Rs." . $order_info['cod_amount'];
													} ?></b>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<h4>Product Name : <?php echo $order_info['product_name']; ?><br>
						Quantity : <?php echo $order_info['product_quantity']; ?><br>
						Sku : <?php echo $order_info['product_sku']; ?>
					</h4>
				</td>
			</tr>
			<tr>
				<td colspan="3">Note-No Open Delivery Allowed <br>
					<b>Order No.- <?php echo $order_info['customer_order_no']; ?> </b>
				</td>
			</tr>
			<!-- <tr>
                <td class="td" colspan="2"></td>
                <td></td>
            </tr> -->

			<tr>
				<td colspan="2"> Buyer Details :<b> <br>
						<?php echo $order_info['deliver_name'] ?>(<?php echo $order_info['deliver_mobile_no']; ?>)</b><br>
					<?php echo $order_info['deliver_address_1']; ?><br>
					<?php echo $order_info['deliver_address_2']; ?> <br>
					<?php echo $order_info['deliver_city'] . ", " . $order_info['deliver_state'] . "-" . $order_info['deliver_pincode']; ?>
					<br><br />
					<b>Contact Number : </b>
					<?php echo $order_info['deliver_mobile_no']; ?>
				</td>
				<td style="text-align: center;">
					<h3><?php echo $order_info['deliver_state'] ?></h3>
					<h3><?php echo $order_info['deliver_pincode']; ?></h3>
				</td>
			</tr>
			<tr>
				<td class="td" colspan="3" style="text-align:center;"><?php //echo $order_info['logistic_name']; 
																		?></td>
			</tr>
			<tr>
				<td class="td" colspan="3" style="text-align:center;"><img src="<?php echo $order_info['base64_barcode_img']; ?>" width="400" height="90">
				</td>
			</tr>
			<tr>
				<td class="td" colspan="3" style="text-align:center;"><?php echo $order_info['awb_number']; ?></td>
			</tr>
			<tr>
				<td colspan="3" style="text-align:left;">
					If not Deliverd so please Return at below address :- <br>
					<b><?php echo $order_info['pickup_name'] ?>(<?php echo $order_info['pickup_email']; ?>)</b><br>

					<b>Contact Number : </b><?php echo $order_info['pickup_contact_no']; ?><br>
					<b>Address :</b> <?php echo $order_info['pickup_address_1']; ?><br>
					<?php echo $order_info['pickup_address_2']; ?>

				</td>
			</tr>
		</table>
	</div>
</body>

</html>
