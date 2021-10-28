<!DOCTYPE html>
<html>

<head>
	<style type="text/css">
		.border-div {
			font-size: 10px !important;
			color: #000000 !important;
			margin-top: 0px;
			padding-top: 0px;
		}

		body {
			font-family: Calibri !important;
		}

		.border-bottom {
			border-bottom: 2px solid;
		}

		.border-right {
			border-right: 2px solid;
		}

		.border-top {
			border-top: 2px solid;
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

		.border-div .table-1 td {
			padding: 2px 4px !important;
		}

		.border-div .table-1 {
			width: 350px;
			border: 3px solid;
			margin-top: 5px;
		}

		.border-div strong {
			font-weight: bolder;
		}

		.background-color {
			background-color: #f5dcdc
		}

		.wrapper-page1 {
			page-break-before: always;
			border: none !important;
		}

		.wrapper-page1:first-child {
			page-break-before: avoid;
		}

		.table-1 th,
		td {
			border: 1px solid black;
			border-collapse: collapse;
		}
	</style>
	<title>Packaging Slip</title>
</head>

<body>
	<div class="page-container">
		<div class="border-div">
			<table class="wrapper-page1" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<?php $j = 0;
					$count = count($order_info);
					$a = $k = 0;
					foreach ($order_info as $single_order) {
						// dd($single_order);
						$k++; ?>
						<td style="width: 45%; border:none;">
							<table class="table-1" cellpadding="0" cellspacing="0">
								<tr>
									<td><img src="<?php echo base_url('uploads/logo2.jpg')  ?>" width="100" height="30" alt="Pack And Drop"></td>
									<td><?php if ($single_order['logistic_name'] == 'delhivery') { ?>
											<img src="assets/admin/custom/images/delhivery.jpg" width="100" height="45">
										<?php }
										if ($single_order['logistic_name'] == 'xpressbees' || $single_order['api_name'] == 'Xpressbeesair_Direct') { ?>
											<img src="assets/admin/custom/images/xpressbees.jpg" width="100" height="45">
										<?php } ?>
										<?php if ($single_order['logistic_name'] == 'Delhivery Express' || $single_order['api_name'] == 'Delhivery_Direct' || $single_order['api_name'] == 'Deliverysexpress_Direct') : ?>
											<img src="<?php echo base_url(); ?>assets/custom/img/delhivery.jpg" width="100" height="45">
										<?php endif; ?>
										<?php if ($single_order['logistic_name'] == 'Xpressbees Express') : ?>
											<img src="<?php echo base_url(); ?>assets/custom/img/xpressbees.jpg" width="100" height="45">
										<?php endif; ?>
										<?php if ($single_order['logistic_name'] == 'Shadowfax Lite') : ?>
											<img src="<?php echo base_url(); ?>assets/custom/img/shadowfax.jpg" width="100" height="45">
										<?php endif; ?>
									</td>
									<td style="text-align:center;"><b><?php if ($single_order['order_type'] == 0) {
																			echo "Prepaid";
																		} else {
																			echo 'COD';
																		} ?></b>
										<h3>Rs. <?php echo $single_order['cod_amount']; ?></h3>
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
										<b>Order No.- <?php echo $single_order['order_no']; ?> </b>
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
										<?php echo $single_order['deliver_state']; ?> <br><br />
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
									<td class="td" colspan="3" style="text-align:center;"><img src="<?php echo base_url('') . $single_order['airwaybill_barcode_img1']; ?>" width="300" height="90"></td>
								</tr>
								<tr>
									<td class="td" colspan="3" style="text-align:center;">
										<?php echo $single_order['awb_number']; ?></td>
								</tr>
								<tr>
									<td colspan="3" style="text-align:left;">
										If not Deliverd so please Return at below address :- <br>
										<b><?php echo $single_order['pickup_name'] ?>(<?php echo $single_order['pickup_email']; ?>)</b><br>
										<?php echo $single_order['pickup_address_1']; ?><br>
										<?php echo $single_order['pickup_address_2']; ?> <br>
										<?php echo $single_order['pickup_state']; ?> -
										<?php echo $single_order['pickup_pincode'] ?><br><br />
										Contact Number : <?php echo $single_order['pickup_contact_no']; ?>
									</td>
								</tr>
							</table>
						</td>
						<?php if ($k == $count) {
							if ($count % 2 == 0) {
							} else {
								echo "<td style='width: 40%;border:none;'><table><tr><td colspan='7' class='text-center' style='height: 450px;width: 300px; border:none'>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan='8' style='height:450px;width: 500px; border:none'>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table></td></tr></table>";
							}
						} ?>
					<?php $j++;
						$a++;

						if ($a == 2) {
							/*if ($k==$count) { if ($count % 2 == 0) { echo "</tr><tr>"; }}else{*/
							echo "</tr><tr>";
							$a = 0; /*}*/
						}

						if ($j == 4) {
							if ($k == $count) {
								if ($count % 4 == 0) {
									echo "</tr></table>";
								}
							} else {
								echo "</tr></table><table class='wrapper-page1'><tr>";
								$j = 0;
							}
						}
					} ?>
		</div>
	</div>
</body>

</html>
