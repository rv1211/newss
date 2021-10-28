<style type="text/css">
	.sorting_disabled {
		width: 100px !important;
	}

	.input {
		width: 120px;
	}
</style>

<div class="page">
	<div class="page-header">
		<h1 class="page-title">Manage Price</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
			<li class="breadcrumb-item active">Manage Price</li>
		</ol>
	</div>
	<div class="page-content">
		<!-- Panel Form Elements -->
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">
					Manage Price
					<hr>
				</h3>
			</div>
			<div class="panel-body container-fluid">
				<div class="page-content">
					<div class="content-wrapper ">
						<div class="content">
							<div class="row">
								<div class="col-lg-12">
									<div class="table-responsive" style="overflow-x: hidden;">
										<form method="post" name="manage_shipping_charge" class="form_order_report" action="<?php echo base_url('manage-price'); ?>" data-parsley-validate>
											<div class="row">
												<div class="col-md-5">
													<h4 class="example-">User</h4>
													<select name="user_id" id="user_id" data-placeholder="Select Logistic *" class="select form-control select2" tabindex="-1" aria-hidden="true">
														<option value="0">select user</option>
														<?php foreach ($users as $user) {?>
														<option value="<?php echo $user->id; ?>" <?php echo set_select('user_id',$user->id);?>><?php echo $user->name." (".$user->email.")"; ?></option>
														<?php } ?>
													</select>
												</div>
												
												<div class="col-md-3">
													<label>&nbsp;&nbsp;</label><br>
													<button class="btn btn-success" type="submit">Get Price Data</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Panel end -->
		<!-- Panel Form Elements -->
		<?php if(@$logistic_price) { ?>
			<form method="post" name="shipping_charge" action="<?php echo base_url('add-price'); ?>" data-parsley-validate>
				<?php foreach($logistic_price as $key => $single_assign_price){ ?>
					<div class="panel" id="logistic_price_table">
						<div class="panel-body container-fluid">
							<div class="page-content">
								<div class="content-wrapper ">
									<div class="content">
										<h2><?= $single_assign_price['logistic_name']; ?></h2>
										<div class="row border" style="margin: 13px;padding-bottom: 20px">
											<div class="col-lg-12">
												<div class="table-responsive" style="overflow-x: hidden;">
													<?php if(!empty($single_assign_price['assign_price_info'])){ ?> 
														<h3 style="margin-bottom:22px;">Assign Price</h3>

														<div class="tab-pane" style="display: block;">
															<div class="table-responsive">
																<div id="all-manifested-order-table_wrapper" class="">
																	<div id="all-manifested-order-table_processing" class="dataTables_processing" style="display: none;">
																		<i class="icon-spinner3 spinner position-left" style="font-size:21px"></i>
																	</div>
																	<table class="table table-xs table-bordered" id="order_report_table" style="width:100%">
																		<thead role="row">
																			<tr>
																				<th type="hidden"></th>
																				<th><strong>Shipment Type</strong></th>
																				<th><strong>Category</strong></th>
																				<th><strong>Within-City</strong></th>
																				<th><strong>Within-State</strong></th>
																				<th><strong>Within-Zone</strong></th>
																				<th><strong>Metro-Metro (National 1)</strong></th>
																				<th><strong>Metro-Metro (National 2)</strong></th>
																				<th><strong>Rest Of India (National 1)</strong></th>
																				<th><strong>Rest Of India (National 2)</strong></th>
																				<th><strong>Special Zone</strong></th>
																				<th><strong>Jammnu And kashmir</strong></th>
																			</tr>
																		</thead>
																		<tbody>
																			<?php if(!empty($single_assign_price['assign_price_info'])){
																			foreach ($single_assign_price['assign_price_info'] as $single_assign_price_info) {?>
																				<tr>
																					<td type="hidden"><input type="hidden" name="assign_price[sender_price_id][<?php echo $single_assign_price_info['id'];?>]" value="<?php echo $single_assign_price_info['sender_id'] ?>"></td>
																					<td>
																						<input type="hidden" name="assign_price[shipment_type][<?php echo $single_assign_price_info['id']?>]" value="<?= $single_assign_price_info['shipment_type'] ?>">
																						<input type="hidden" name="assign_price[logistic_id][<?php echo $single_assign_price_info['id']?>]" value="<?= $single_assign_price_info['logistic_id'] ?>">
																						<?php if ($single_assign_price_info['shipment_type'] == 0) : ?>
																							<strong>Forward</strong>
																						<?php else : ?>
																							<strong>Reverse</strong>
																						<?php endif; ?>
																					</td>
																					<td><strong><?php echo $single_assign_price_info['name']; ?></strong></td>
																					<td>
																						<input type="hidden" name="assign_price[id][<?php echo $single_assign_price_info['id']; ?>]" value="<?php echo @$single_assign_price_info['id']; ?>">
																						<input type="hidden" name="assign_price[rules][<?php echo $single_assign_price_info['id']; ?>]" value="<?= @$single_assign_price_info['rule_name']; ?>">
																						<input type="hidden" name="assign_price[rule_index][<?php echo $single_assign_price_info['id']; ?>]" value="<?= @$single_assign_price_info['rule_index']; ?>">
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="assign_price[within_city][<?php echo $single_assign_price_info['id']; ?>]" value="<?php echo $single_assign_price_info['within_city']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="assign_price[within_state][<?php echo $single_assign_price_info['id']; ?>]" value="<?php echo $single_assign_price_info['within_state']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="assign_price[within_zone][<?php echo $single_assign_price_info['id']; ?>]" value="<?php echo $single_assign_price_info['within_zone']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="assign_price[metro][<?php echo $single_assign_price_info['id']; ?>]" value="<?php echo $single_assign_price_info['metro']; ?>">
																					</td>

																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="assign_price[metro_2][<?php echo $single_assign_price_info['id']; ?>]" value="<?php echo $single_assign_price_info['metro_2']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="assign_price[rest_of_india][<?php echo $single_assign_price_info['id']; ?>]" value="<?php echo $single_assign_price_info['rest_of_india']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="assign_price[rest_of_india_2][<?php echo $single_assign_price_info['id']; ?>]" value="<?php echo $single_assign_price_info['rest_of_india_2']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="assign_price[special_zone][<?php echo $single_assign_price_info['id']; ?>]" value="<?php echo $single_assign_price_info['special_zone']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="assign_price[jammu_kashmir][<?php echo $single_assign_price_info['id']; ?>]" value="<?php echo $single_assign_price_info['jammu_kashmir']; ?>">
																					</td>
																				</tr>
																			<?php } } ?>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="row" style="margin-top: 10px">
																<div class="col-md-4" style="margin-left:44px">
																	<label>COD Amount</label>
																	<input type="text" required onkeypress="return isNumberKey(event)" name="assign_price[cod_price][<?=$key?>]" class="form-control" value="<?php echo $single_assign_price['assign_price_info'][0]['cod_price']; ?>">
																</div>
																<div class="col-md-4" style="margin-left:44px">
																	<label>COD Percentage</label>
																	<input type="text" required onkeypress="return isNumberKey(event)" name="assign_price[cod_percentage][<?=$key?>]" class="form-control" value="<?php echo $single_assign_price['assign_price_info'][0]['cod_percentage']; ?>">
																</div>
															</div>
														</div>
													<?php } 
													if(!empty($single_assign_price['pending_price_info'])){ ?>
														<div class="tab-pane" style="display: block;">
															<h3 style="margin-bottom:22px;">Pending Price</h3>
															<div class="table-responsive">
																<div id="all-manifested-order-table_wrapper" class="">
																	<div id="all-manifested-order-table_processing" class="dataTables_processing" style="display: none;">
																		<i class="icon-spinner3 spinner position-left" style="font-size:21px"></i>
																	</div>
																	<table class="table table-xs table-bordered" id="order_report_table" style="width:100%">
																		<thead role="row">
																			<tr>
																				<th><strong></strong></th>
																				<th><strong>Shipment Type</strong></th>
																				<th><strong>Category</strong></th>
																				<th><strong>Within-City</strong></th>
																				<th><strong>Within-State</strong></th>
																				<th><strong>Within-Zone</strong></th>
																				<th><strong>Metro-Metro (National 1)</strong></th>
																				<th><strong>Metro-Metro (National 2)</strong></th>
																				<th><strong>Rest Of India (National 1)</strong></th>
																				<th><strong>Rest Of India (National 2)</strong></th>
																				<th><strong>Special Zone</strong></th>
																				<th><strong>Jammnu And kashmir</strong></th>
																			</tr>
																		</thead>
																		<tbody>
																			<?php foreach ($single_assign_price['pending_price_info'] as $key => $single_pending_price){ 
																				$logistic = $single_pending_price['logistic_id'];?>
																				<tr>
																					<td>
																						<input type="hidden" name="pending_price[<?=$logistic?>][hidden_user_id]" value="<?=$user_id;?>">
																						<input class="selectable checked_item" type="checkbox" id="checked" name="pending_price[<?=$logistic?>][checkbox_item][<?php echo $single_pending_price['id']; ?>]" value="<?php echo $single_pending_price['id']; ?>">
																					</td>
																					<td>
																						<input type="hidden" name="pending_price[<?=$logistic?>][shipment_type][<?php echo $single_pending_price['id']; ?>]" value="<?= $single_pending_price['shipment_type'] ?>">
																						<?php if ($single_pending_price['shipment_type'] == 0) : ?>
																							<strong>Forward</strong>
																						<?php else : ?>
																							<strong>Reverse</strong>
																						<?php endif; ?>
																					</td>
																					<td><strong><?php echo $single_pending_price['name']; ?></strong></td>
																					<td>
																						<input type="hidden" name="pending_price[<?=$logistic?>][id][<?php echo $single_pending_price['id']; ?>]" value="<?php echo @$single_pending_price['id']; ?>">

																						<input type="hidden" name="pending_price[<?=$logistic?>][rules][<?php echo $single_pending_price['id']; ?>]" value="<?= @$single_pending_price['rule_name']; ?>">
																						<input type="hidden" name="pending_price[<?=$logistic?>][rule_index][<?php echo $single_pending_price['id']; ?>]" value="<?= @$single_pending_price['rule_index']; ?>">
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="pending_price[<?=$logistic?>][within_city][<?php echo $single_pending_price['id']; ?>]" value="<?php echo $single_pending_price['within_city']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="pending_price[<?=$logistic?>][within_state][<?php echo $single_pending_price['id']; ?>]" value="<?php echo $single_pending_price['within_state']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="pending_price[<?=$logistic?>][within_zone][<?php echo $single_pending_price['id']; ?>]" value="<?php echo $single_pending_price['within_zone']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="pending_price[<?=$logistic?>][metro][<?php echo $single_pending_price['id']; ?>]" value="<?php echo $single_pending_price['metro']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="pending_price[<?=$logistic?>][metro_2][<?php echo $single_pending_price['id']; ?>]" value="<?php echo $single_pending_price['metro_2']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="pending_price[<?=$logistic?>][rest_of_india][<?php echo $single_pending_price['id']; ?>]" value="<?php echo $single_pending_price['rest_of_india']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="pending_price[<?=$logistic?>][rest_of_india_2][<?php echo $single_pending_price['id']; ?>]" value="<?php echo $single_pending_price['rest_of_india_2']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="pending_price[<?=$logistic?>][special_zone][<?php echo $single_pending_price['id']; ?>]" value="<?php echo $single_pending_price['special_zone']; ?>">
																					</td>
																					<td>
																						<input class="input" type="text" required onkeypress="return isNumberKey(event)" name="pending_price[<?=$logistic?>][jammu_kashmir][<?php echo $single_pending_price['id']; ?>]" value="<?php echo $single_pending_price['jammu_kashmir']; ?>">
																					</td>
																				</tr>
																			<?php } ?>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="col-md-2">
											<button class="btn btn-primary" type="submit" style="margin-top: 10px">Update Data</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</form>
		<?php } ?>
	</div>
</div>
</div>
<!-- </div> -->


<script type="text/javascript">
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode != 46 && charCode > 31 &&
			(charCode < 48 || charCode > 57))
			return false;

		return true;
	}
</script>