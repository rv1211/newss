 <form class="form-horizontal fv-form fv-form-bootstrap4" id="kyc_verification_form" name="kyc_verification_form" action="<?php echo base_url('kyc-verification'); ?>" method="POST" enctype="multipart/form-data" autocomplete="off" novalidate="novalidate">
 	<div class="page">
 		<div class="page-header">
 			<h4 class="page-title">Kyc Verification</h4>
 			<div class="page-content">
 				<div class="panel">
 					<header class="panel-heading">
 						<h3 class="panel-title">
 							Complete Your KYC
 						</h3>
 					</header>
 					<div class="panel-body">
 						<p>Upload your personal or company documents for Verification</p>

 						<div class="example">
 							<div class="row">
 								<div class="col-md-6">
 									<div class="row">
 										<div class="col-md-12">
 											<div class="form-group form-material select_profile">
 												<label class="form-control-label">Select Profile Type</label>
 												<select class="form-control select2 rounded" name="profile_type" data-allow-clear="true" tabindex="-1" aria-hidden="true" id="profile_types">
 													<option value="">Select Profile Type</option>
 													<option value='0' <?php echo  set_select('profile_type', '0', TRUE); ?>>
 														Individual</option>
 													<option value='1' <?php echo  set_select('profile_type', '1', TRUE); ?>>
 														Company</option>
 												</select>
 												<?php if (isset($errors['profile_type'])) { ?>
 													<label class="error"><?= @$errors['profile_type'] ?></label>
 												<?php } ?>
 												<label id="profile_types-error" class="error" for="profile_types"></label>
 											</div>
 										</div>
 									</div>

 									<div class="row" id="company_div" style="display: block;">
 										<div class="col-md-12">
 											<div class="form-group form-material">
 												<label class="form-control-label">Company Type</label>
 												<select id="company_type" data-allow-clear="true" tabindex="-1" aria-hidden="true" name="company_type" class="form-control select2  rounded">
 													<option value="">Select Company Type</option>
 													<option value="0" <?php echo  set_select('company_type', '0', TRUE); ?>>Sole
 														Proprietorship</option>
 													<option value="1" <?php echo  set_select('company_type', '1', TRUE); ?>>
 														Partnership</option>
 													<option value="2" <?php echo  set_select('company_type', '2', TRUE); ?>>
 														Limited Liability Partnership</option>
 													<option value="3" <?php echo  set_select('company_type', '3', TRUE); ?>>
 														Public Limited Company</option>
 													<option value="4" <?php echo  set_select('company_type', '4', TRUE); ?>>
 														Private Limited Company</option>
 												</select>
 												<?php if (isset($errors['company_type'])) { ?>
 													<label class="error"><?= @$errors['company_type'] ?></label>
 												<?php } ?>
 												<label id="company_type-error" class="error" for="company_type"></label>
 											</div>
 										</div>
 										<div class="col-md-12">
 											<div class="form-group form-material">
 												<label class="form-control-label">Company Name</label>
 												<input type="text" name="company_name" value="<?php echo set_value('company_name'); ?>" class="form-control" placeholder="Company Name">
 												<?php if (isset($errors['company_name'])) { ?>
 													<label class="error"><?= @$errors['company_name'] ?></label>
 												<?php } ?>
 											</div>
 										</div>
 									</div>

 									<div class="row">
 										<div class="col-lg-12">
 											<div class="form-group form-material">
 												<label class="form-control-label">Pan Number</label>
 												<input type="text" class="form-control pan_number" name="pan_no" value="<?php echo set_value('pan_no'); ?>" placeholder="Pan Number" autocomplete="off" />
 												<?php if (isset($errors['pan_no'])) { ?>
 													<label class="error"><?= @$errors['pan_no'] ?></label>
 												<?php } ?>
 											</div>
 										</div>
 										<div class="col-lg-12">
 											<div class="form-group form-material">
 												<label class="form-control-label">Gst Number</label>
 												<input type="text" class="form-control gst_number" name="gst_no" value="<?php echo set_value('gst_no'); ?>" placeholder="gst Number" autocomplete="off" />
 												<?php if (isset($errors['gst_no'])) { ?>
 													<label class="error"><?= @$errors['gst_no'] ?></label>
 												<?php } ?>
 											</div>
 										</div>
 									</div>
 								</div>
 								<div class="col-md-6 kycdoc">
 									<img src="<?= base_url(); ?>/assets/front-end/img/Ekyc.svg" alt="KYC Document Upload">
 								</div>
 							</div>

 							<div class="row" id="company_div" style="display: block;">
 								<div class="col-md-6">
 								</div>
 							</div>
 						</div>
 					</div>
 				</div>

 				<div class="panel" style="height: auto;">
 					<header class="panel-heading">
 						<h3 class="panel-title panel-style">Billing Address Info</h3>
 					</header>
 					<div class="panel-body">
 						<div class="example pincode_add">
 							<div class="row">
 								<div class="col-md-4">
 									<div class="form-group form-material">
 										<label class="form-control-label">Pincode</label>
 										<input type="text" class="form-control pincode" value="<?php echo set_value('pincode'); ?>" id="kycpincode" name="pincode" placeholder="Pincode" autocomplete="off" />
 										<?php if (isset($errors['pincode'])) { ?>
 											<label class="error"><?= @$errors['pincode'] ?></label>
 										<?php } ?>
 									</div>
 								</div>
 								<div class="col-md-4">
 									<div class="form-group form-material">
 										<label class="form-control-label">City</label>
 										<input type="text" class="form-control city" name="city" value="<?php echo set_value('city'); ?>" placeholder="City" autocomplete="off" />
 										<?php if (isset($errors['city'])) { ?>
 											<label class="error"><?= @$errors['city'] ?></label>
 										<?php } ?>
 									</div>
 								</div>
 								<div class="col-md-4">
 									<div class="form-group form-material">
 										<label class="form-control-label">State</label>
 										<input type="text" class="form-control state" name="state" value="<?php echo set_value('state'); ?>" placeholder="State" autocomplete="off" />
 										<?php if (isset($errors['state'])) { ?>
 											<label class="error"><?= @$errors['state'] ?></label>
 										<?php } ?>
 									</div>
 								</div>
 							</div>
 						</div>
 						<div class="example">
 							<div class="form-group form-material add_1">
 								<label class="form-control-label">Address Line 1</label>
 								<input type="text" class="form-control address1" name="address_1" value="<?php echo set_value('address_1'); ?>" placeholder="Address Line 1" autocomplete="off" />
 								<?php if (isset($errors['address_1'])) { ?>
 									<label class="error"><?= @$errors['address_1'] ?></label>
 								<?php } ?>
 							</div>
 						</div>
 						<div class="example">
 							<div class="form-group form-material">
 								<label class="form-control-label">Address Line 2</label>
 								<input type="text" class="form-control address2" name="address_2" value="<?php echo set_value('address_2') ?>" placeholder="Address Line 2" autocomplete="off" />
 								<?php if (isset($errors['address_2'])) { ?>
 									<label class="error"><?= @$errors['address_2'] ?></label>
 								<?php } ?>
 							</div>
 						</div>
 					</div>
 				</div>

 				<div class="panel">
 					<div class="panel-heading">
 						<h3 class="panel-title"></h3>
 					</div>
 					<div class="panel-body container-fluid">
 						<div class="row row-lg">
 							<div class="col-lg-6">
 								<h3 class="example-title">Document 1</h3>
 								<div class="example">
 									<select class="form-control select2 rounded" name="doc1_id" data-allow-clear="true" tabindex="-1" aria-hidden="true">
 										<option value="">Select Address Proof</option>
 										<?php foreach ($document_list as $single_document_list) {
												if ($single_document_list['doc_type'] == '1') { ?>
 												<option value="<?php echo $single_document_list['id']; ?>">
 													<?php echo $single_document_list['document_name']; ?></option>
 										<?php }
											} ?>
 									</select>
 									<?php if (isset($errors['doc1_id'])) { ?>
 										<label class="error"><?= @$errors['doc1_id'] ?></label>
 									<?php } ?>
 									<label id="doc1_id-error" class="error" for="doc1_id"></label>
 								</div>
 							</div>
 							<div class="col-md-6">
 								<h3 class="example-title">Document 2</h3>
 								<div class="example">
 									<select class="form-control select2 rounded" name="doc2_id" data-allow-clear="true" tabindex="-1" aria-hidden="true">
 										<option value="">Select Identification Proof</option>
 										<?php foreach ($document_list as $single_document_list) {
												if ($single_document_list['doc_type'] == '2') { ?>
 												<option value="<?php echo $single_document_list['id']; ?>">
 													<?php echo $single_document_list['document_name']; ?></option>
 										<?php }
											} ?>
 									</select>
 									<?php if (isset($errors['doc2_id'])) { ?>
 										<label class="error"><?= @$errors['doc2_id'] ?></label>
 									<?php } ?>
 									<label id="doc2_id-error" class="error" for="doc2_id"></label>
 								</div>
 							</div>
 						</div>
 						<div class="row row-lg">
 							<div class="col-lg-3">
 								<h4 class="example-title"></h4>
 								<div class="example">
 									<input type="file" name="doc1_1_img" accept="image/*, application/pdf" id="doc1_1_img" data-plugin="dropify" data-default-file="" />
 								</div>
 								<?php if (isset($errors['doc1_1_img'])) { ?>
 									<label class="error"><?= @$errors['doc1_1_img'] ?></label>
 								<?php } ?>
 							</div>
 							<div class="col-lg-3">
 								<h4 class="example-title"></h4>
 								<div class="example">
 									<input type="file" name="doc1_2_img" accept="image/*, application/pdf" id="doc1_2_img" data-plugin="dropify" data-default-file="" />
 								</div>
 								<?php if (isset($errors['doc1_2_img'])) { ?>
 									<label class="error"><?= @$errors['doc1_2_img'] ?></label>
 								<?php } ?>
 							</div>
 							<div class="col-lg-3">
 								<h4 class="example-title"></h4>
 								<div class="example">
 									<input type="file" name="doc2_image1" accept="image/*, application/pdf" id="doc2_image1" data-plugin="dropify" data-default-file="" />
 								</div>
 								<?php if (isset($errors['doc2_image1'])) { ?>
 									<label class="error"><?= @$errors['doc2_image1'] ?></label>
 								<?php } ?>
 							</div>
 							<div class="col-lg-3">
 								<h4 class="example-title"></h4>
 								<div class="example">
 									<input type="file" name="doc2_image2" accept="image/*, application/pdf" id="doc2_image2" data-plugin="dropify" data-default-file="" />
 								</div>
 							</div>
 						</div>
 						<hr />
 						<!-- <div class="row row-lg">
 							<div class="col-lg-4">
 								<h3 class="example-title" style="margin-top: 10px;">PICKUP PROOF</h3>
 								<div class="example">
 									<select class="form-control select2 rounded" name="pickup_id" data-allow-clear="true" tabindex="-1" aria-hidden="true">
 										<option value="">Select Pickup Proof</option>
 										<?php foreach ($document_list as $single_document_list) {
												if ($single_document_list['doc_type'] == '3') { ?>
 												<option value="<?php echo $single_document_list['id']; ?>">
 													<?php echo $single_document_list['document_name']; ?></option>
 										<?php }
											} ?>
 									</select>
 									<?php if (isset($errors['pickup_id'])) { ?>
 										<label class="error"><?= @$errors['pickup_id'] ?></label>
 									<?php } ?>
 									<label id="pickup_id-error" class="error" for="pickup_id"></label>
 								</div>
 							</div>
 						</div>
 						<div class="row row-lg ">
 							<div class="col-lg-4">
 								<h3 class="example-title"></h3>
 								<div class="example">
 									<input type="file" name="pick_up_img" accept="image/*, application/pdf" id="pick_up_img" data-plugin="dropify" data-default-file="" />
 								</div>
 								<?php if (isset($errors['pick_up_img'])) { ?>
 									<label class="error"><?= @$errors['pick_up_img'] ?></label>
 								<?php } ?>
 							</div>
 						</div> -->

 						<div class="row">
 							<div class="col-xl-4 col-md-6">
 								<!-- Example Default -->
 								<h3 class="example-title">CANCELLED CHEQUE</h3>
 								<div class="example">
 									<?php foreach ($document_list as $single_document_list) {
											if ($single_document_list['doc_type'] == '4') { ?>
 											<input type="hidden" name="cancelled_cheque_id" id="cancelled_cheque_id" value="<?php echo $single_document_list['id']; ?>">
 									<?php }
										} ?>
 									<input type="file" name="cancelled_cheque_image" accept="image/*, application/pdf" id="cancelled_cheque_image" data-plugin="dropify" data-default-file="" />
 									<?php if (isset($errors['cancelled_cheque_image'])) { ?>
 										<label class="error"><?= @$errors['cancelled_cheque_image'] ?></label>
 									<?php } ?>
 								</div>
 								<!-- End Example Default -->
 							</div>
 							<div class="col-xl-6 col-md-12">
 								<h3 class="example-title">Bank Details</h3>
 								<div class="example">
 									<div class="col-md-12 form-group form-material">
 										<label class="form-control-label">Bank Name</label>
 										<input type="text" class="form-control bankname" name="bankname" value="<?php echo set_value('bankname'); ?>" placeholder="Enter Bank Name" autocomplete="off" />
 										<?php if (isset($errors['bankname'])) { ?>
 											<label class="error"><?= @$errors['bankname'] ?></label>
 										<?php } ?>
 									</div>
 									<div class="col-md-12 form-group form-material">
 										<label class="form-control-label">Benificiary Name</label>
 										<input type="text" class="form-control benificiary" name="benificiary" value="<?php echo set_value('benificiary'); ?>" placeholder="Enter Benificiary  Name" autocomplete="off" />
 										<?php if (isset($errors['benificiary'])) { ?>
 											<label class="error"><?= @$errors['benificiary'] ?></label>
 										<?php } ?>
 									</div>

 									<div class="col-md-6 form-group form-material">
 										<label class="form-control-label">Account No :</label>
 										<input type="text" class="form-control acno" name="acno" value="<?php echo set_value('acno'); ?>" placeholder="Enter Account No" autocomplete="off" />
 										<?php if (isset($errors['acno'])) { ?>
 											<label class="error"><?= @$errors['acno'] ?></label>
 										<?php } ?>
 									</div>
 									<div class="col-md-6  form-material">
 										<label class="form-control-label">IFSC Code :</label>
 										<input type="text" class="form-control ifsc" name="ifsc" value="<?php echo set_value('ifsc'); ?>" placeholder="Enter IFSC Code" autocomplete="off" />
 										<?php if (isset($errors['ifsc'])) { ?>
 											<label class="error"><?= @$errors['ifsc'] ?></label>
 										<?php } ?>
 									</div>
 								</div>
 							</div>

 							<!-- <div class="col-xl-4 col-md-6">
 								<h3 class="example-title">Document 3</h3>
 								<div class="example">
 									<?php //foreach ($document_list as $single_document_list) {
										//if ($single_document_list['doc_type'] == '5') { 
										?>
 											<input type="hidden" name="other_doc_id" id="other_doc_id" value="<?php //echo $single_document_list['id']; 
																												?>">
 									<?php //}
										// } 
										?>
 									<input type="file" name="other_document[]" multiple="true" accept="image/*, application/pdf" id="other_document" data-plugin="dropify" data-default-file="" />
 								</div>
 							</div> -->
 						</div>
 						<div class="row " style="float:right;">
 							<div class="animation-example animation-hover hover">
 								<button class="btn btn-primary pull-left legitRipple" id="add_kyc" type="submit">NEXT</button>
 							</div>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 </form>
