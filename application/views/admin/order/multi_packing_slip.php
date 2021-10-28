<!DOCTYPE html>
<html>

<head>
	<title>Packing Slip</title>
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
		}

		.wrapper-page1:first-child {
			page-break-before: avoid;
		}
	</style>
	<title>Invoice</title>
</head>

<body>
	<div class="page-container">
		<div class="border-div">
			<table class="wrapper-page1" width="100%">
				<tr>
					<?php $j = 0;
					$count = count($order_info);
					$a = $k = 0;


					foreach ($order_info as $single_order) {

						$k++; ?>
						<td style="width: 45%">
							<table class="table-1 wrapper-page1" cellpadding="0" cellspacing="0">
								<tr>
									<td colspan="7" class="border-bottom text-center">
										<h3 style="margin: 0px;">Please call before delivery</h3>
									</td>
								</tr>
								<tr>
									<td colspan="4" class="border-bottom" style="height:35px;" valign="top">
										order from this Website: <?php echo @$single_order['pickup_website']; ?></p>
									</td>
									<td colspan="3" class="border-bottom" style="height:35px; text-align: right;">



										<?php if ($single_order['logistic_name'] == 'delhivery') { ?>
											<img src="assets/admin/custom/images/delhivery.jpg" width="45" height="25">
										<?php  }
										if ($single_order['logistic_name'] == 'xpressbees') { ?>
											<img src="assets/admin/custom/images/xpressbees.jpg" width="45" height="25">
										<?php } ?>
										<?php if ($single_order['logistic_name'] == 'Delhivery Express') : ?>
											<img src="<?php echo base_url(); ?>assets/custom/img/delhivery.png" width="45" height="25">
										<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td colspan="4" class="border-bottom" height="30px"><strong>DUTIES/TAXES:
											RECIPIENT</strong>
										<!-- </td>
                    <td colspan="4" class="border-bottom"> -->
									</td>
									<td colspan="3" class="border-bottom text-right">
										<h3 style="">Reference No: <?php echo $single_order['order_no']; ?></h3>
									</td>
									<!-- <td class="border-bottom"><strong><?php if ($single_order['order_type'] == 0) {
																				echo "Prepaid";
																			} else {
																				echo 'COD';
																			} ?></strong></td> -->
								</tr>
								<tr>
									<td colspan="4" height="30px" valign="top">
										<strong>SHIP TO:</strong> <br>
										<?php echo $single_order['deliver_name']; ?><br>
										<?php echo wordwrap($single_order['deliver_address_1'] . "," . $single_order['deliver_address_2'], 15, "<br>\n", TRUE); ?><br>
										<?php echo $single_order['deliver_city'] . "<br>" . $single_order['deliver_state'] . "<br> <strong>Pincode :</strong> " . $single_order['deliver_pincode'] . "<br> <strong>Phone No:</strong> " . $single_order['deliver_mobile_no']; ?><br><br><br>
										<strong class="text-center">
											<h1><?php if ($single_order['order_type'] == 0) {
													echo "Prepaid";
												} else {
													echo 'COD<br>' . number_format($single_order['cod_amount'], 2);
												} ?></h1>
										</strong>
									</td>
									<td colspan="3" style="padding-bottom:0%"><br>
										<h4>TRK# <?php echo $single_order['awb_number']; ?></h4>

										<img src="<?php echo base_url('') . $single_order['airwaybill_barcode_img1']; ?>" width="150" height="100">
									</td>
								</tr>
								<tr>
									<td colspan="4" class="border-bottom text-center"></td>
									<td colspan="3" class="border-bottom">
										<strong>Ship Date:
											<?= date('d-m-Y', strtotime($single_order['created_date'])); ?></strong><br />
										<strong>Invoice Date:
											<?= date('d-m-Y', strtotime($single_order['created_date'])); ?></strong><br />
										<strong>Invoice No: <?= $single_order['order_no']; ?></strong><br />
										<strong>Invoice Value: <?= $single_order['cod_amount']; ?></strong><br />
										<!-- <strong>Actual Weight: <?= $single_order['physical_weight']; ?></strong><br/> -->

									</td>
								</tr>
								<tr>
									<td colspan="7" class="border-bottom text-center"><strong>RETAIL INVOICE</strong></td>
									<!-- <td colspan="1" class="border-bottom">
                        <strong><small>GSTIN:</small></strong><?php echo @$single_order['gst_no']; ?>
                    </td> -->
								</tr>
								<tr>
									<td colspan="1" class="border-bottom border-right text-center"><strong style="font-size:10px">SL <BR> NO:</strong></td>
									<td colspan="3" class="border-bottom border-right text-center" width="25%"><strong style="font-size:10px">SHIPMENT</strong></td>
									<td colspan="1" class="border-bottom border-right text-center"><strong style="font-size:10px">QTY</strong></td>
									<td colspan="1" class="border-bottom border-right text-center"><strong style="font-size:10px">RATE<BR> (INR)</strong></td>
									<td colspan="1" class="border-bottom text-center"><strong style="font-size:10px">AMOUNT
											<BR>(INR)</strong></td>
								</tr>
								<tr>
									<td colspan="1" class="border-bottom border-right text-center" height="15px" valign="top">1</td>
									<td colspan="3" class="border-bottom border-right text-center" valign="top">
										<?php echo $single_order['product_name']; ?></td>
									<td colspan="1" class="border-bottom border-right text-center" valign="top">
										<?= $single_order['product_quantity']; ?></td>
									<td colspan="1" class="border-bottom border-right text-center" valign="top">
										<?php
										$rate = $single_order['product_value'] / $single_order['product_quantity'];
										echo number_format(@$rate, 2); ?>
									</td>
									<td colspan="1" class="border-bottom text-center" valign="top">
										<?= number_format($single_order['product_value'], 2); ?></td>
								</tr>
								<tr>
									<td colspan="6" class="border-bottom border-right text-left"><strong>TOTAL (Tax
											Inclusive)</strong></td>
									<td colspan="1" class="border-bottom text-center">
										Rs.<?= number_format($single_order['product_value'], 2); ?></td>
								</tr>
								<tr>
									<td colspan="7" class=" text-left">
										<strong>if there is any product issue please
											contact:<br><?= $single_order['pickup_email']; ?> or call:
											<?= $single_order['pickup_contact_no']; ?></strong>
									</td>
								</tr>
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
						</td>
					<?php //if ($k == $count) {
						//if ($count % 2 == 0) {
						//} else {
						//echo "<td style='width: 40%'><table><tr><td colspan='7' class='text-center' style='height: 450px;width: 300px'>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan='8' style='height:450px;width: 500px'>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table></td></tr></table>";
						// }
						//} 
						$j++;
						$a++;

						// if ($a == 2) {
						//     /*if ($k==$count) { if ($count % 2 == 0) { echo "</tr><tr>"; }}else{*/
						//     echo "</tr><tr>";
						//     $a = 0; /*}*/
						// }

						// if ($j == 4) {
						//     if ($k == $count) {
						//         if ($count % 4 == 0) {
						//             echo "</tr></table>";
						//         }
						//     } else {
						//         echo "</tr></table><table class='wrapper-page1'><tr>";
						//         $j = 0;
						//     }
						// }
					} ?>
		</div>
	</div>
</body>

</html>
