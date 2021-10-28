<div class="page">
	<div class="page-header">
		<h1 class="page-title">Assign Label</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
			<li class="breadcrumb-item active">Assign Label</li>
		</ol>
	</div>
	<div class="page-content">
		<form action="<?= base_url('assign_label_user') ?>" method="post" id="" name="assingawb">
			<!-- Panel Form Elements -->
			<div class="panel">
				<div class="panel-body container-fluid">
					<div class="row row-lg">
						<div class="col-md-4">
							<div class="form-group form-material">
								<h4 class="example-">Customers</h4>
								<select name="sender_name" id="sender_name_assig_label" class="form-control select2" required="">
									<option value="">Select Customer</option>
									<?php foreach ($this->data['sender_list'] as  $sender_list_value) { ?>
										<option value="<?php echo $sender_list_value['id']; ?>" <?php echo set_select('sender_name', $sender_list_value['id'], False); ?>>
											<?php echo $sender_list_value['email']; ?></option>
									<?php } ?>
								</select>
								<label class="sender_error"></label>
								<?php if (isset($errors['sender_name'])) : ?>
									<label class="error"><?php echo $errors['sender_name']; ?></label>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-12 row" style="display:inline-flex; margin:12px;">
							<div class="col-md-3" style="padding: 10px"><input type="checkbox" id="label_1" value="1" name="lable_id[]">
								<strong>Non logo Label 1</strong>
								<iframe src="<?= base_url() ?>uploads/sample_label_pdf/sample_1.pdf" height="200" width="300"></iframe>
							</div>
							<div class="col-md-3" style="padding: 10px"><input type="checkbox" id="label_2" value="2" name="lable_id[]">
								<strong>Non logo Label 2</strong>
								<iframe src="<?= base_url() ?>uploads/sample_label_pdf/sample_2.pdf" height="200" width="300"></iframe>
							</div>
							<div class="col-md-3" style="padding: 10px"><input type="checkbox" id="label_3" value="3" name="lable_id[]">
								<strong>Non logo Label 3</strong>
								<iframe src="<?= base_url() ?>uploads/sample_label_pdf/sample_3.pdf" height="200" width="300"></iframe>
							</div>
							<!-- <div class="col-md-3" style="padding: 10px"><input type="checkbox" id="label_4" value="4" name="lable_id[]">
                                <strong>Non logo Label 4</strong>
                                <iframe src="<?= base_url() ?>uploads/sample_label_pdf/sample_4.pdf" height="200" width="300"></iframe>
                            </div> -->
							<div class="col-md-3" style="padding: 10px"><input type="checkbox" id="label_4" value="5" name="lable_id[]">
								<strong>Non logo Label 4</strong>
								<iframe src="<?= base_url() ?>uploads/sample_label_pdf/sample_5.pdf" height="200" width="300"></iframe>
							</div>
							<div class="col-md-3" style="padding: 10px"><input type="checkbox" id="label_6" value="6" name="lable_id[]">
								<strong>Label 5</strong>
								<iframe src="<?= base_url() ?>uploads/sample_label_pdf/sample_6.pdf" height="200" width="300"></iframe>
							</div>
							<div class="col-md-3" style="padding: 10px"><input type="checkbox" id="label_7" value="7" name="lable_id[]">
								<strong>Label 6</strong>
								<iframe src="<?= base_url() ?>uploads/sample_label_pdf/sample_7.pdf" height="200" width="300"></iframe>
							</div>
							<div class="col-md-3" style="padding: 10px"><input type="checkbox" id="label_8" value="8" name="lable_id[]">
								<strong>Label 7</strong>
								<iframe src="<?= base_url() ?>uploads/sample_label_pdf/sample_8.pdf" height="200" width="300"></iframe>
							</div>
							<!--<div class="col-md-3" style="padding: 10px"><input type="checkbox" id="label_9" value="9" name="lable_id[]">-->
							<!--    <strong>Label 9</strong>-->
							<!--    <iframe src="<?= base_url() ?>uploads/sample_label_pdf/sample_9.pdf" height="200" width="300"></iframe>-->
							<!--</div> -->
							<div class="col-md-3" style="padding: 10px"><input type="checkbox" id="label_10" value="0" name="lable_id[]">
								<strong>Label 8</strong>
								<iframe src="<?= base_url() ?>uploads/sample_label_pdf/sample_0.pdf" height="200" width="300"></iframe>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group form-material">
								<?php if (isset($errors['lable_id[]'])) : ?>
									<label class="error"><?php echo $errors['lable_id[]']; ?></label>
								<?php endif; ?>
								<h4 class="example-">&nbsp;</h4>
								<button type="submit" id="assign_label" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Panel end -->
			<div class="panel" id="awb_panel" style="display:none;">
				<div class="panel-body container-fluid">
					<div class="awb_table">
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
