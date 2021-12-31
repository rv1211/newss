<!DOCTYPE html>
<html lang="en">
<?php //dd($order_info)
?>

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
			font-size: 19px;
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
			padding: 12px;
			text-align: left;
		}

		/* .table_order, */
		.td {
			border: none;
		}
	</style>
	<title>Packing Slip</title>
</head>

<body>
	<div class="row">
		<table class="table_order" cellpadding="0" class="wrapper-page1" cellspacing="0">
			<tr>

				<td colspan="2">
					<?php if ($order_info['api_name'] == 'Delhivery_Surface' || $order_info['api_name'] == 'Delhivery_Direct' || $order_info['api_name'] == 'Deliverysexpress_Direct' || strtolower(trim($order_info['api_name'])) == 'delhivery_ssl' || strtolower(trim($order_info['api_name'])) == 'delhivery_surface_5_kgs_ssl' || strtolower(trim($order_info['api_name'])) == 'delhivery_surface_ssl' || strtolower(trim($order_info['api_name'])) == 'delhivery_surface_2_kgs_ssl' || strtolower(trim($order_info['api_name'])) == 'delhivery_surface_10_kgs_ssl' || strtolower(trim($order_info['api_name'])) == 'delhivery_surface_20_kgs_ssl') : ?>
						<?php
						$path = 'assets/custom/img/delhivery.jpg';
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<img src="<?php echo $base64_img; ?>" width="200" height="80">
					<?php endif; ?>

					<?php if ($order_info['api_name'] == 'Xpressbees_Surface' || $order_info['api_name'] == 'Xpressbees_Direct' || $order_info['api_name'] == 'Xpressbeesair_Direct' || strtolower(trim($order_info['api_name'])) == 'xpressbees_ssl' || strtolower(trim($order_info['api_name'])) == 'xpressbees_surface_ssl' || strtolower(trim($order_info['api_name'])) == 'xpressbees_2kg_ssl' || strtolower(trim($order_info['api_name'])) == 'xpressbees_1kg_ssl' || strtolower(trim($order_info['api_name'])) == 'xpressbees_5kg_ssl') : ?>
						<?php
						$path = 'assets/custom/img/xpressbees.jpg';
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<img src="<?php echo $base64_img; ?>" width="200" height="80">
					<?php endif; ?>
					<?php if ($order_info['api_name'] == 'Ekart_Surface' || $order_info['api_name'] == 'Ecart_air' || strtolower(trim($order_info['api_name'])) == 'ekart_logistics_surface_ssl') : ?>
						<?php
						$path = "assets/custom/img/ekart.jpg";
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<img src="<?php echo $base64_img ?>" width="200" height="80">
					<?php endif; ?>
					<?php if ($order_info['api_name'] == 'Ecom_Direct' || strtolower(trim($order_info['api_name'])) == 'ecom_express_surface_500gms_ssl' || strtolower(trim($order_info['api_name'])) == 'ecom_express_surface_ssl' || strtolower(trim($order_info['api_name'])) == 'ecom_express_surface_2kg_ssl') : ?>
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
					<?php if ($order_info['api_name'] == 'Shadowfax_Direct' || strtolower(trim($order_info['api_name'])) == 'shadowfax_surface_ssl') : ?>
						<?php
						$path = "assets/custom/img/shadowfax.jpg";
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<img src="<?php echo $base64_img ?>" width="200" height="80">
					<?php endif; ?>
					<?php if (strtolower(trim($order_info['api_name'])) == 'blue_dart_ssl' || strtolower(trim($order_info['api_name'])) == 'blue_dart_surface_ssl') : ?>
						<?php
						$path = "assets/custom/img/Bluedart.jpg";
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<img src="<?php echo $base64_img ?>" width="200" height="80">
					<?php endif; ?>
					<?php if (strtolower(trim($order_info['api_name'])) == 'amazon_shipping_5kg_ssl' || strtolower(trim($order_info['api_name'])) == 'amazon_shipping_1kg_ssl' || strtolower(trim($order_info['api_name'])) == 'amazon_shipping_2kg_ssl') : ?>
						<?php
						$path = "assets/custom/img/amazon.jpeg";
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<img src="<?php echo $base64_img ?>" width="200" height="80">
					<?php endif; ?>
					<?php if (strtolower(trim($order_info['api_name'])) == 'dtdc_2kg_ssl' || strtolower(trim($order_info['api_name'])) == 'dtdc_surface_ssl') : ?>
						<?php
						$path = "assets/custom/img/dtdc.jpg";
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<img src="<?php echo $base64_img ?>" width="200" height="80">
					<?php endif; ?>
					<?php if (strtolower(trim($order_info['api_name'])) == 'kerry_indev_express_surface_ssl') : ?>
						<?php
						$path = "assets/custom/img/kerry_indev.jpg";
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<img src="<?php echo $base64_img ?>" width="200" height="80" alt="Kerry Indev Express">
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
						Sku : <?php echo $order_info['product_sku']; ?><br>
						Dimention : <?php echo round($order_info['length']); ?> X <?= round($order_info['width']); ?> X <?= round($order_info['height']); ?> <br>
						Weight : <?php echo $order_info['physical_weight']; ?>
					</h4>
				</td>
			</tr>
			<tr>
				<td colspan="3">Note-No Open Delivery Allowed <br>
					<b>Order No.- <?php echo $order_info['customer_order_no']; ?> </b>
				</td>
			</tr>

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
				<td class="td" colspan="3" style="text-align:center;">
					<?php
					$path =  $order_info['airwaybill_barcode_img'];
					$type = pathinfo($path, PATHINFO_EXTENSION);
					$file_data = file_get_contents($path);
					$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
					?>
					<img src="<?php echo $base64_img; ?>" width="400" height="80">
				</td>
			</tr>
			<tr>
				<td class="td" colspan="3" style="text-align:center;"><?php echo $order_info['awb_number']; ?></td>
			</tr>
			<tr>
				<td class="td" colspan="3" style="text-align:center;">
					<?php if (!empty($order_info['uddan_barcode_text'])) :
					?>
						<?php
						$path =  $order_info['uddan_barcode_img'];
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$file_data = file_get_contents($path);
						$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
						?>
						<img src="<?php echo $base64_img; ?>" width="400" height="120">
					<?php endif;
					?>
				</td>
			</tr>
			<tr>
				<td class="td" colspan="3" style="text-align:center;">
					<?php if (!empty($order_info['uddan_barcode_text'])) : ?>
						<?php echo $order_info['uddan_barcode_text']; ?>
					<?php endif; ?></td>
			</tr>
			<?php if (!empty($order_info['packing_slip_warehouse_name'])) : ?>
				<tr>
					<td class="td" colspan="3">
						Reseller Info :- <br>
						<b><?php echo @$order_info['packing_slip_warehouse_name'] ?></b>
					</td>
				</tr>
			<?php endif; ?>
		</table>
	</div>
</body>

</html>
