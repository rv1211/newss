<div class="row" id="table_row">
	<div class="col-xl-5" style="margin-left: 15px;">
		<h4 class="example-title">
			Select logistic partner as per your preference</h4>
		<div class="example">
			<table class="table table-hover" data-plugin="selectable" data-row-selectable="true" border="1" id="shippingtable">
				<thead>
					<tr>
						<th></th>
						<th><strong>Logistic Partner</strong></th>
						<th><strong>Amount</strong></th>
					</tr>
				</thead>
				<tbody>
					<?php

					function sort_price($element1, $element2)
					{
						$datetime1 = $element1['subtotal'];
						$datetime2 = $element2['subtotal'];
						return $datetime1 - $datetime2;
					}

					usort($shippingprice, 'sort_price');
					foreach ($shippingprice as $key => $shippingvalue) {

						if ($shippingvalue['subtotal'] != "Rulse Is Not Proper It's Infinite") {
					?>
							<tr>
								<td>
									<input class="selectable-item" name="logi" type="radio">
									<label for="row-619"></label>
								</td>
								<td>
									<?php if (trim($shippingvalue['api_name']) == 'Delhivery_Surface' || trim($shippingvalue['api_name']) == 'Delhivery_Direct' || strtolower(trim($shippingvalue['api_name'])) == 'delhivery_surface_10_kgs_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'delhivery_surface_2_kgs_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'delhivery_surface_20_kgs_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'delhivery_surface_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'delhivery_surface_5_kgs_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'delhivery_ssl') : ?>
										<img src="<?php echo base_url(); ?>assets/custom/img/delhivery.jpg" style="border: none; height:40px; width:150px;">
									<?php endif; ?>
									<?php if (trim($shippingvalue['api_name']) == 'Xpressbees_Surface' || trim($shippingvalue['api_name']) == 'Xpressbees_express' ||  trim($shippingvalue['api_name']) == 'Xpressbees_Direct' || trim($shippingvalue['api_name']) == 'Xpressbeesair_Direct' || strtolower(trim($shippingvalue['api_name'])) == 'xpressbees_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'xpressbees_surface_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'xpressbees_1kg_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'xpressbees_2kg_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'xpressbees_5kg_ssl') : ?>
										<img src="<?php echo base_url(); ?>assets/custom/img/xpressbees.jpg" style="border: none; height:40px; width:150px;">
									<?php endif; ?>
									<?php if (trim($shippingvalue['api_name']) == 'ekart_Surface' || trim($shippingvalue['api_name']) == 'ecart_air' || trim($shippingvalue['api_name']) == 'ekart_Direct' || strtolower(trim($shippingvalue['api_name'])) == 'ekart_logistics_surface_ssl'  || strtolower(trim($shippingvalue['api_name'])) == 'ekart_logistics_surface_ssl') : ?>
										<img src="<?php echo base_url(); ?>assets/custom/img/ekart.jpg" style="border: none; height:40px; width:150px;">
									<?php endif; ?>
									<?php if (trim($shippingvalue['api_name']) == 'Udaan_Direct') : ?>
										<img src="<?php echo base_url(); ?>assets/custom/img/uddan.jpg" style="border: none; height:40px; width:150px;">
									<?php endif; ?>
									<?php if (trim($shippingvalue['api_name']) == 'Ecom_Direct' || strtolower(trim($shippingvalue['api_name'])) == 'ecom_express_surface_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'ecom_express_surface_2kg_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'ecom_express_surface_500gms_ssl') : ?>
										<img src="<?php echo base_url(); ?>assets/custom/img/ecom.jpg" style="border: none; height:40px; width:150px;">
									<?php endif; ?>
									<?php if (trim($shippingvalue['api_name']) == 'Shadowfax_Direct' || strtolower(trim($shippingvalue['api_name'])) == 'shadowfax_surface_ssl') : ?>
										<img src="<?php echo base_url(); ?>assets/custom/img/shadowfax.jpg" style="border: none; height:40px; width:150px;">
									<?php endif; ?>
									<?php if (strtolower(trim($shippingvalue['api_name'])) == 'blue_dart_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'blue_dart_surface_ssl') : ?>
										<img src="<?php echo base_url(); ?>assets/custom/img/Bluedart.jpg" style="border: none; height:40px; width:150px;">
									<?php endif; ?>
									<?php if (strtolower(trim($shippingvalue['api_name'])) == 'amazon_shipping_5kg_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'amazon_shipping_1kg_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'amazon_shipping_2kg_ssl') : ?>
										<img src="<?php echo base_url(); ?>assets/custom/img/amazon.jpeg" style="border: none; height:40px; width:150px;">
									<?php endif; ?>
									<?php if (strtolower(trim($shippingvalue['api_name'])) == 'dtdc_2kg_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'dtdc_surface_ssl' || strtolower(trim($shippingvalue['api_name'])) == 'dtdc_surface_ssl') : ?>
										<img src="<?php echo base_url(); ?>assets/custom/img/dtdc.jpg" style="border: none; height:40px; width:150px;">
									<?php endif; ?>
									<?php if (strtolower(trim($shippingvalue['api_name'])) == 'kerry_indev_express_surface_ssl') : ?>
										<img src="<?php echo base_url(); ?>assets/custom/img/kerry_indev.jpg" style="border: none; height:40px; width:150px;">
									<?php endif; ?>
									<?= $shippingvalue['logistic']; ?>
									<span class="logistic_id amount"><?php echo $shippingvalue['logistic_id']; ?></span>
									<span class="cgst amount"><?php echo $shippingvalue['tax']['CGST']; ?></span>
									<span class="igst amount"><?php echo $shippingvalue['tax']['IGST']; ?></span>
									<span class="sgst amount"><?php echo $shippingvalue['tax']['SGST']; ?></span>
									<input type="hidden" id="cod_amount" value="<?= $shippingvalue['cod_ammount']; ?>">
									<span class="zone amount"><?= $shippingvalue['zone']; ?></span>
								</td>
								<td>
									<strong>&#8377; </strong>
									<span class="subtotal"><?= $shippingvalue['subtotal']; ?></span>
								</td>
							</tr>
					<?php }
					} ?>
					<?php //if ($shippingprice[0]['tax']['IGST'] == "0") { 
					?>
					<!-- <tr>
                            <td></td>
                            <td>CGST</td>
                            <td>9%</td>
                        </tr> -->
					<!-- <tr>
                            <td></td>
                            <td>SGST</td>
                            <td>9%</td>
                        </tr> -->
					<?php //} else { 
					?>
					<!-- <tr>
                            <td></td>
                            <td>IGST</td>
                            <td>18%</td>
                        </tr> -->
					<?php //} 
					?>
				</tbody>
				<!-- <tfooter>
                    <tr>
                        <td></td>
                        <td>Total(inc.GST)</td>
                        <td class="totalsummary"></td>
                    </tr>
                </tfooter> -->
			</table>
		</div>
	</div>
</div>
