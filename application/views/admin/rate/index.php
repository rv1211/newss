<style>
	.selectable-item {
		display: none;
	}
</style>
<div class="page">
	<div class="page-header">
		<h1 class="page-title">Calculate Rate</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
			<li class="breadcrumb-item active"><a href="#">Calculate rate</a></li>
		</ol>
	</div>
	<form method="POST" name="create_single_order" id="create_simple_oreder">
		<div class="page-content">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">
						Pincode Details
						<hr>
					</h3>
				</div>
				<div class="panel-body container-fluid">
					<div class="row row-lg">
						<div class="col-md-6 col-lg-6">
							<div class="form-group form-material">
								<h4 class="example-title">Pickup Pincode</h4>
								<input type="text" class="form-control pincode_class" name="pickup_pincode" id="pickup_pincode" placeholder="Pincode">
								<label class="text-danger pickup_pincode"></label>
								<?php if (isset($errors['pickup_pincode'])) : ?>
									<label class="text-danger"><?= $errors['pickup_pincode']; ?></label>
								<?php endif; ?>
							</div>
						</div>

						<div class="col-md-6 col-lg-6">
							<div class="form-group form-material ">
								<h4 class="example-title">Deliver Pincode</h4>
								<input type="text" class="form-control pincode_class" name="pincode" id="pincode" placeholder="Pincode">
								<label id="pincode-not-error" class="error-not text-danger" for="pincode"></label>
								<?php if (isset($errors['pincode'])) : ?>
									<label class="text-danger "><?= $errors['pincode']; ?></label>
								<?php endif; ?>
								<label id="pincode-error" class="error" for="pincode"></label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<br>
			<div class="panel">
				<div class="panel-heading title1">
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
										<input type="text" readonly class="form-control" name="collectable_amount" id="collectable_amount" placeholder="Collectable Amount">
										<?php if (isset($errors['collectable_amount'])) : ?>
											<label class="text-danger"><?= $errors['collectable_amount']; ?></label>
										<?php endif; ?>
										<label id="collectable_amount-error" class="error" for="collectable_amount"></label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<br />
				<input type="hidden" name="base_ship" id="base_ship" value="">
				<input type="hidden" name="sgst" id="sgst" value="">
				<input type="hidden" name="cgst" id="cgst" value="">
				<input type="hidden" name="igst" id="igst" value="">
				<input type="hidden" name="total" id="total" value="">
				<input type="hidden" name="logistic_id" id="logistic_id" value="">
				<input type="hidden" name="cod_charge" id="cod_charge" value="">


				<div class="ship_div"></div>
				<div class="form-actions right" style="margin-top: 10px;">
					<div class="animation-example animation-hover hover">
						<button type="button" id="create_order" name="get_price" class="btn btn-primary pull-left legitRipple waves-effect waves-classic get-price-simple-order-rate" style="margin-bottom: 37px;margin-left:10px;">Get Price</button>

					</div>
				</div>
			</div>
	</form>
</div>
