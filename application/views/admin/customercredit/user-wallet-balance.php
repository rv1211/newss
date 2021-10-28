<div class="page">
	<div class="page-header">
		<h1 class="page-title">User Wallet balance</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
			<li class="breadcrumb-item active">Manage</li>
		</ol>
	</div>
	<div class="page-content">
		<!-- Panel Form Elements -->
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">
					User Wallet balance
					<hr>
				</h3>
			</div>
			<div class="panel-body container-fluid">
				<div class="row row-lg">
					<div class="col-md-12">
						<div id="step3_div" style="display:block">

							<form id="wallet_update_for_user" method="POST" class="" action="<?php echo base_url('update-wallet-balance') ?>">
								<!-- <div class="col-md-2 col-sm-12"></div> -->
								<div class="col-md-8 col-sm-12">
									<!-- <fieldset class="step" id="ajax-step3"> -->
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label for=""> User :</label>
											</div>
										</div>
										<div class="col-md-10">
											<div class="form-group">
												<select name="user_id" tabindex="-1" id="wallet_user_id" data-placeholder="User *" class="form-control   select2 wallet_user_id">
													<option value="">Select User</option>
													<?php foreach ($user_list as $single_user) { ?>
														<option value="<?php echo $single_user->id; ?>"><?php echo $single_user->name; ?> (<?php echo $single_user->email; ?>) </option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Action :</label>
											</div>
										</div>
										<div class="col-md-10">
											<div class="form-group">
												<select name="wallet_action" id="perform_action" data-placeholder="Action *" class=" form-control  perform_action">
													<option value="">Select Action</option>
													<option value="0">Debit</option>
													<option value="1">Credit</option>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Amount :</label>
											</div>
										</div>
										<div class="col-md-10">
											<div class="form-group">
												<input class="form-control inputnumbers" type="text" autocomplete="off" name="wallet_amount" id="wallet_amount" />
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Remarks :</label>
											</div>
										</div>
										<div class="col-md-10">
											<div class="form-group">
												<input class="form-control inputnumbers" autocomplete="off" type="text" name="wallet_remarks" id="wallet_remarks" />
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>PayId :</label>
											</div>
										</div>
										<div class="col-md-10">
											<div class="form-group">
												<input class="form-control inputnumbers" autocomplete="off" type="text" name="razorpay_pay_id" id="razorpay_pay_id" />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<button class="btn btn-primary pull-left" id="wallet_update_for_user_button" type="submit" style="margin-right: 10px">Save</button>
											</div>
										</div>
									</div>
									</fieldset>
								</div>
							</form>
						</div>
					</div>

				</div>
			</div>
		</div>
		</form>
	</div>
</div>
