<div class="page">
	<div class="page-header">
		<h1 class="page-title">Create Single Order</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
			<li class="breadcrumb-item"><a href="#">Create Order</a></li>
			<li class="breadcrumb-item active">Create Single Order</li>
		</ol>
	</div>
	<form method="POST" action="<?= base_url('insert_single_order_awbno'); ?>" name="create_single_name">
		<div class="page-content">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">
					</h3>
				</div>

				<div class="panel-body container-fluid">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-material">
								<h4 class="example-title">Pickup Address</h4>
								<select class="form-control select2" name="pickup_address" id="pickup_address">
									<option value="">Select Option</option>
									<?php
									if (!empty($pickup_address)) {
										foreach ($pickup_address as $value) { ?>
											<option value="<?= $value['id'] ?>">
												<?= $value['warehouse_name']; ?></option>
									<?php }
									} ?>
								</select>
								<?php if (isset($errors['pickup_address'])) : ?>
									<label class="text-danger"><?= $errors['pickup_address']; ?></label>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group form-material">
								<h4 class="example-title">Shipment Type</h4>
								<select class="form-control select2" name="shipment_type" id="shipment_type">
									<option value="">Select Option</option>
									<option value="0">Forward</option>
									<!-- <option value="2">Reverse</option> -->
								</select>
								<?php if (isset($errors['shipment_type'])) : ?>
									<label class="text-danger"><?= $errors['shipment_type']; ?></label>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel">
				<div class="panel-heading title1">
					<h3 class="panel-title">
						What are Shipment Type
						<hr>
					</h3>
					<div class="panel-body container-fluid">
						<div class="row row-lg">
							<div class="col-md-4">
								<div class="form-group form-material">
									<h4 class="example-title">Logistic Type</h4>
									<input type="hidden" class="form-control" name="logistic_id" id="logistic_id">
									<input type="text" class="form-control" name="logistic" id="logistic_type" placeholder="Logistic" readonly>
									<label class="text-danger" id="logistic-error"></label>
									<?php if (isset($errors['logistic'])) : ?>
										<label class="text-danger"><?= $errors['logistic']; ?></label>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-material">
									<h4 class="example-title">Airwaybill Number</h4>
									<input type="text" name="awbno" class="form-control airwaybill_number" placeholder="airwaybillno">
									<label class="text-danger" id="awb_number"></label>
									<?php if (isset($errors['awbno'])) : ?>
										<label class="text-danger"><?= $errors['awbno']; ?></label>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-material">
									<h4 class="example-title">Shipping charge</h4>
									<input type="text" name="shippingcharge" id="shipping_charge" class="form-control" placeholder="Shipping charge" readonly>
									<input type="hidden" name="codcharge" id="codcharge" class="form-control">
									<?php if (isset($errors['shippingcharge'])) : ?>
										<label class="text-danger"><?= $errors['shippingcharge']; ?></label>
									<?php endif; ?>
									<div class="form-actions right">
										<div class="animation-example animation-hover hover">
											<label class="text" id="sgst" style="display: none; color:black;margin-left:15px;">SGST:9%</label>
											<label class="text" id="cgst" style="display: none;color:black;margin-left:15px;">CGST:9%</label>
											<label class="text" id="igst" style="display: none;color:black;margin-left:15px;">IGST:18%</label>
											<input type="hidden" class="totalshipping" name="totalshipping">
											<input type="hidden" class="sgst" name="sgst">
											<input type="hidden" class="cgst" name="cgst">
											<input type="hidden" class="igst" name="igst">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<br>
				<div class="panel">
					<div class="panel-heading title1">
						<h3 class="panel-title">
							Where are you sending to?
							<hr>
						</h3>
						<div class="panel-body container-fluid">
							<div class="row sender-pincode">
								<div class="col-md-4">
									<div class="form-group form-material ">
										<h4 class="example-title">Pincode</h4>
										<input type="text" class="form-control pincode_class" name="pincode" id="pincode" placeholder="Pincode">
										<label id="pincode-not-error" class="error-not text-danger" for="pincode"></label>
										<?php if (isset($errors['pincode'])) : ?>
											<label class="text-danger"><?= $errors['pincode']; ?></label>
										<?php endif; ?>
										<label id="pincode-error" class="error" for="pincode"></label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-material">
										<h4 class="example-title">State</h4>
										<input type="text" class="form-control state" name="state" id="State" placeholder="State" readonly>
										<?php if (isset($errors['state'])) : ?>
											<label class="text-danger"><?= $errors['state']; ?></label>
										<?php endif; ?>
										<label id="state-error" class="error" for="state"></label>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-material">
										<h4 class="example-title">City</h4>
										<input type="text" class="form-control city" name="city" id="City" placeholder="City" readonly>
										<?php if (isset($errors['city'])) : ?>
											<label class="text-danger"><?= $errors['city']; ?></label>
										<?php endif; ?>
										<label id="city-error" class="error" for="city"></label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group form-material">
										<h4 class="example-title">Customer Name</h4>
										<input type="text" class="form-control" name="customer_name" id="Customer Name" placeholder="Customer Name">
										<?php if (isset($errors['customer_name'])) : ?>
											<label class="text-danger"><?= $errors['customer_name']; ?></label>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-material">
										<h4 class="example-title">Customer email </h4>
										<input type="text" class="form-control" name="customer_email" id="Customer email" placeholder="Customer email">
										<?php if (isset($errors['customer_email'])) : ?>
											<label class="text-danger"><?= $errors['customer_email']; ?></label>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-material">
										<h4 class="example-title">Customer Mobile no </h4>
										<input type="text" class="form-control" name="customer_mobile" id="Customer_Mobile_no" placeholder="Customer Mobile no">
										<?php if (isset($errors['customer_mobile'])) : ?>
											<label class="text-danger"><?= $errors['customer_mobile']; ?></label>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-material">
										<h4 class="example-title">Customer Address line 1 </h4>
										<input type="text" class="form-control" name="customer_address1" id="address_line_1" placeholder="Customer Address line 1">
										<?php if (isset($errors['customer_address1'])) : ?>
											<label class="text-danger"><?= $errors['customer_address1']; ?></label>
										<?php endif; ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-material">
										<h4 class="example-title">Customer Address line 2 </h4>
										<input type="text" class="form-control" name="customer_address2" id="address_line_2" placeholder="Customer Address line 2">
										<?php if (isset($errors['customer_address2'])) : ?>
											<label class="text-danger"><?= $errors['customer_address2']; ?></label>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<br />
						<div class="panel-heading">
							<h3 class="panel-title">
								What size is your parcel??
								<hr>
							</h3>
							<div class="panel-body container-fluid">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group form-material">
											<h4 class="example-title">Length (cms)</h4>
											<input type="text" class="form-control parcel_weight" name="length" id="length" placeholder="Length (cms)">
											<?php if (isset($errors['length'])) : ?>
												<label class="text-danger"><?= $errors['length']; ?></label>
											<?php endif; ?>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-material">
											<h4 class="example-title">Width (cms)</h4>
											<input type="text" class="form-control parcel_weight" name="width" id="width" placeholder="Width (cms)">
											<?php if (isset($errors['width'])) : ?>
												<label class="text-danger"><?= $errors['width']; ?></label>
											<?php endif; ?>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-material">
											<h4 class="example-title">Height (cms)</h4>
											<input type="text" class="form-control parcel_weight" name="height" id="height" placeholder="Height (cms)">
											<?php if (isset($errors['height'])) : ?>
												<label class="text-danger"><?= $errors['height']; ?></label>
											<?php endif; ?>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-material">
											<h4 class="example-title">Volumetric Weight (in kg)</h4>
											<input type="text" class="form-control" name="volumetric_weight" id="volumetric_weight" placeholder="Volumetric Weight (in kg)" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<div class="form-group form-material">
											<h4 class="example-title">Physical Weight (In KG)</h4>
											<input type="text" class="form-control" name="physical_width" id="physical_width" placeholder="Physical Weight (In KG)">
											<?php if (isset($errors['physical_width'])) : ?>
												<label class="text-danger"><?= $errors['physical_width']; ?></label>
											<?php endif; ?>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-material">
											<h4 class="example-title">Product Value</h4>
											<input type="text" class="form-control" name="product_value" id="Product_Value" placeholder="Product Value">
											<?php if (isset($errors['product_value'])) : ?>
												<label class="text-danger"><?= $errors['product_value']; ?></label>
											<?php endif; ?>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-material">
											<h4 class="example-title">Product Name</h4>
											<input type="text" class="form-control" name="product_name" id="Product Name" placeholder="Product Name">
											<?php if (isset($errors['product_name'])) : ?>
												<label class="text-danger"><?= $errors['product_name']; ?></label>
											<?php endif; ?>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group form-material">
											<h4 class="example-title">Product Quantity</h4>
											<input type="text" class="form-control" name="product_qty" id="Product_Quantity" placeholder="Product Quantity">
											<?php if (isset($errors['product_qty'])) : ?>
												<label class="text-danger"><?= $errors['product_qty']; ?></label>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<br />
					<div class="panel">
						<div class="panel-heading title1">
							<h3 class="panel-title">
								What are the order details?
								<hr>
							</h3>
							<div class="panel-body container-fluid">
								<div class="row ">
									<div class="col-md-4">
										<div class="form-group form-material">
											<h4 class="example-title">Order Number</h4>
											<input type="text" class="form-control" name="order_number" id="Order_Number" placeholder="Order Number">
											<label class="text-danger" id="ordernumber"></label>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group form-material">
											<h4 class="example-title">Order Type</h4>
											<select class="form-control select2" id="order_type" name="order_type">
												<option value="">Select Option</option>
												<option value="1">COD</option>
												<option value="0">Prepaid</option>
											</select>
											<?php if (isset($errors['order_type'])) : ?>
												<label class="text-danger"><?= $errors['order_type']; ?></label>
											<?php endif; ?>
										</div>
									</div>
									<div class="col-md-4" id="cod_amount_div" style="display: none;">
										<div class="form-group form-material">
											<h4 class="example-title">Collectable Amount</h4>
											<input type="text" class="form-control" name="collectable_amount" id="collectable_amount" readonly placeholder="Collectable Amount">
											<?php if (isset($errors['collectable_amount'])) : ?>
												<label class="text-danger"><?= $errors['collectable_amount']; ?></label>
											<?php endif; ?>
											<label id="collectable_amount-error" class="error" for="collectable_amount"></label>
										</div>
									</div>
								</div>
								<!-- <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-material">
                                            <h4 class="example-title">Package Count</h4>
                                            <input type="text" class="form-control" name="package_count"
                                                id="Package Count" placeholder="Package Count">
                                            <?php if (isset($errors['package_count'])) : ?>
                                            <label class="text-danger"><?= $errors['package_count']; ?></label>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div> -->
							</div>
						</div>
					</div>
					<div class="panel">
						<div class="panel-heading title1">
							<h3 class="panel-title">
								Seller Info for Packing Slip
								<hr>
							</h3>
							<div class="panel-body container-fluid">
								<div class="row ">
									<div class="col-md-5">
										<div class="form-group form-material">
											<input type="checkbox" name="seller_info" id="seller_info" placeholder="Seller info">
											Display seller info in packing slip?
										</div>

									</div>
									<div class="col-md-12">
										<div class="form-group form-material">
											<h4 class="example-title">Reseller Name</h4>
											<div class="col-md-6">
												<input type="text" name="reseller_name" class="form-control" id="reseller_name" placeholder="Reseller Name">
												<?php if (isset($errors['reseller_name'])) : ?>
													<label class="text-danger"><?= $errors['reseller_name']; ?></label>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="panel">
                        <div class="panel-heading title1">
                            <h3 class="panel-title">
                                Return Shipment Info
                                <hr>
                            </h3>
                            <div class="panel-body container-fluid">
                                <div class="row ">
                                    <div class="form-group form-material" style="margin-left: 17px;">
                                        <h4 class="example-title">Want to Return Address same as pickup address?</h4>
                                        <input type="radio" name="is_return_address_same_as_pickup" value="1"
                                            class="pickup_address" checked> Yes &nbsp;
                                        <input type="radio" name="is_return_address_same_as_pickup" value="0"
                                            id="other_pickup_add" class="pickup_address"> No
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-heading title1" id="return_address" style="display:none;">
                            <h3 class="panel-title"> Return Address Info
                                <hr />
                            </h3>
                            <div class="panel-body container-fluid">
                                <div class="row return-pincode">
                                    <div class="col-md-4">
                                        <div class="form-group form-material">
                                            <h4 class="example-title">Pincode</h4>
                                            <input type="text" class="form-control pincode_class" name="return_pincode"
                                                id="return_pincode" placeholder="Pincode">
                                            <?php if (isset($errors['return_pincode'])) : ?>
                                            <label class="text-danger"><?= $errors['return_pincode']; ?></label>
                                            <?php endif; ?>
                                            <label id="return_pincode-error" class="error" for="return_pincode"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-material">
                                            <h4 class="example-title">State</h4>
                                            <input type="text" class="form-control state" name="return_state"
                                                id="return_state" placeholder="State">
                                            <?php if (isset($errors['return_state'])) : ?>
                                            <label class="text-danger"><?= $errors['return_state']; ?></label>
                                            <?php endif; ?>
                                            <label id="return_state-error" class="error" for="return_state"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-material">
                                            <h4 class="example-title">City</h4>
                                            <input type="text" class="form-control city" name="return_city"
                                                id="return_city" placeholder="City">
                                            <?php if (isset($errors['return_city'])) : ?>
                                            <label class="text-danger"><?= $errors['return_city']; ?></label>
                                            <?php endif; ?>
                                            <label id="return_city-error" class="error" for="return_city"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-material">
                                            <h4 class="example-title">Name</h4>
                                            <input type="text" class="form-control" name="return_name" id="Name"
                                                placeholder="Name">
                                            <?php if (isset($errors['return_name'])) : ?>
                                            <label class="text-danger"><?= $errors['return_name']; ?></label>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-material">
                                            <h4 class="example-title">Mobile no </h4>
                                            <input type="text" class="form-control" name="return_mobile_no"
                                                id="Mobile no" placeholder="Mobile no">
                                            <?php if (isset($errors['return_mobile_no'])) : ?>
                                            <label class="text-danger"><?= $errors['return_mobile_no']; ?></label>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-material">
                                            <h4 class="example-title">Address 1 </h4>
                                            <input type="text" class="form-control" name="return_address1"
                                                id="Address 1" placeholder="Address 1">
                                            <?php if (isset($errors['return_address1'])) : ?>
                                            <label class="text-danger"><?= $errors['return_address1']; ?></label>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-material">
                                            <h4 class="example-title">Address 2 </h4>
                                            <input type="text" class="form-control" name="return_address2"
                                                id="Address 2" placeholder="Address 2">
                                            <?php if (isset($errors['return_address2'])) : ?>
                                            <label class="text-danger"><?= $errors['return_address2']; ?></label>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
					<br />

					<div class="form-actions right">
						<div class="animation-example animation-hover hover">

							<button type="button" id="create_simple_order" name="temp_success" class="btn btn-primary pull-left legitRipple waves-effect waves-classic get-price" style="margin-bottom: 37px;margin-left:10px;">Get Price</button>
							<div id="order_btn">
								<button type="submit" id="awb_order_btn" class="btn btn-primary create_order pull-left legitRipple waves-effect waves-classic" style="margin-bottom: 37px;" disabled="disabled">Create Order</button>
							</div>
						</div>
					</div>
				</div>
	</form>
</div>
