<!DOCTYPE html>
<html>

<head>
	<title>Bill</title>
</head>
<style type="text/css">
	body {
		width: 100%;
		border: 2px solid black;
		margin: 10px auto;
		font-family: ProximaNovaLight, ProximaNovaRegular, 'Source Sans Pro', Calibri;
	}

	/*body{font-family: ProximaNovaLight,ProximaNovaRegular,'Source Sans Pro',Calibri;}*/
	/*body{font-family: Calibri !important;}      */
	table {
		margin-top: 30px;
	}

	div.relative {
		position: relative;
	}

	div.row {
		padding: 2em;
	}

	div.absolute {
		position: absolute;
		top: 80px;
		right: 50px;
	}

	p.font {
		font-weight: bold;
	}

	.md {
		padding-left: 170px;
	}

	.tb3 {
		position: relative;
		left: 250px;

	}

	.shipadd tbody tr td,
	.shipadd thead tr th {
		border: 1px solid black;
	}

	table tbody tr td,
	table tbody tr th,
	table thead tr th {
		padding: 7px;
	}
</style>

<body>
	<div class="row">
		<div class="relative">
			<p class="font">
				ShipSecure Logistics<br />
				(www.shipsecurelogistics.com)<br />
				TAX INVOICE<br />
				PAN #: AECFS0983G<br />
				GST #: 24AECFS0983G1Z2<br />
				GST ADDRESS :<br />
				306, Vishala Supreme, Opp. Nikol Power station, nikol,<br> Ahmedabad-382350<br>
			</p>
		</div>
		<!-- https://shipsecurelogistics.com/assets/front-end/images/logo.png -->
		<div class="absolute">
			<?php
			$path = "https://shipsecurelogistics.com/assets/front-end/images/logo.png";
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$file_data = file_get_contents($path);
			$base64_img = 'data:image/' . $type . ';base64,' . base64_encode($file_data);
			?>

			<img src="<?php echo $base64_img ?>" width="280px" alt="logo" style="margin-left:100px">
		</div>


		<table cellpadding="0" class="shipadd" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="60%">Ship Secure Logistics</th>
					<th>Invoice #</th>
					<th>SSL2020....</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php $address = @$pickupaddress['address_line_1'];
					if (@$pickupaddress['address_line_2'] != '') {
						$address .= ",<br>" . @$pickupaddress['address_line_2'];
					}
					$address .= ".<br>" . @$pickupaddress['city'] . ", " . @$pickupaddress['state'] . ", " . @$pickupaddress['pincode']; ?>
					<td height="30px"><?php echo str_replace(array(", ,", ",,"), ",", @$address); ?></td>
					<td>Invoice Date</td>
					<td><?php echo date('M d, Y', strtotime(@$orderdata['created_date'])); ?></td>
				</tr>
				<!-- <tr>
					<td style="border: 0;"></td>
					<td style="border: 0;"></td>
				</tr> -->
			</tbody>
		</table>

		<table cellpadding="0" cellspacing="0" border="1" width="100%">
			<thead>
				<tr style="background-color: #efeff8;">
					<th>Item</th>
					<th>Description</th>
					<!-- <th>Unit Cost</th> -->
					<th>Quantity</th>
					<th>Line Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php //$total = @$orderdata->product_mrp*@$orderdata->quantity;
					$total_amount = $orderdata['total_shipping_amount'];
					$gst_percentage  = 18;
					$nontaxamount = $total_amount * 100 / (100 + $gst_percentage);
					$totataxamount  = $total_amount - $nontaxamount;
					?>
					<td><?php echo 1; ?></td>
					<td><?php echo @$orderdata['product_name']; ?></td>
					<!-- <td><?php //echo @$orderdata->product_mrp; 
								?><?php echo @$total_amount; ?></td> -->
					<td><?php echo @$orderdata['product_quantity']; ?></td>
					<td><?php echo @$total_amount; ?></td>
				</tr>
			</tbody>
		</table>

		<table class="tb3" border="1" cellpadding="0" cellspacing="0">
			<thead>
				<tr style="background-color: #efeff8;">
					<th style="border-right: 0;">Subtotal </th>
					<th style="border-left: 0;" class="md"><?php echo @$total_amount; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (strtolower(@$kycDetail['bill_state']) == 'gujarat') { ?>
					<tr>
						<td style="border-right: 0;">CGST (9%) </td>
						<td style="border-left: 0;" class="md"> <?php echo number_format(@$totataxamount / 2, 2); ?></td>
					</tr>
					<tr>
						<td style="border-right: 0;">SGST (9%)</td>
						<td style="border-left: 0;" class="md"><?php echo number_format(@$totataxamount / 2, 2); ?></td>
					</tr>
				<?php } else { ?>
					<tr>
						<td style="border-right: 0;">IGST (18%)</td>
						<td style="border-left: 0;" class="md"><?php echo number_format(@$totataxamount / 2, 2); ?></td>
					</tr>
				<?php } ?>
				<tr>
					<td style="border-right: 0;">Total</td>
					<td style="border-left: 0;" class="md"><?php echo number_format(@$total_amount, 2); ?></td>
				</tr>
				<tr style="background-color: #efeff8;">
					<th style="border-right: 0; ">Amount Paid (INR)</th>
					<th style="border-left: 0;" class="md"> <?php echo number_format(@$total_amount, 2); ?></th>
				</tr>
				<tr style="background-color: #efeff8;">
					<th style="border-right: 0;">Balance Due (INR)</th>
					<th style="border-left: 0;" class="md"><?php echo  number_format('0.00', 2); ?></th>
				</tr>
			</tbody>
		</table>

		<p>"This is computer generated invoice and does not require any stamp or signature"</p>
		<h4>Note :</h4>
		<h4>Service for (<?php echo $userdata['name']; ?>) to GST ID: (<?php echo @$kycdata['gst_no']; ?>) from ShipSecure</h4>

	</div>
</body>

</html>