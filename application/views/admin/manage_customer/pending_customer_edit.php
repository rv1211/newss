<form class="form-horizontal fv-form fv-form-bootstrap4" id="add_logistic" name="add_logistic" action="<?php echo base_url('view-customer/' . $this->uri->segment(2)); ?>" method="POST" enctype="multipart/form-data" autocomplete="off" novalidate="novalidate">
	<div class="page">
		<div class="page-header">
			<h4 class="page-title">Kyc Verification</h4>
			<div class="page-content">
				<div class="panel">
					<header class="panel-heading">
						<h3 class="panel-title">
							Complete Your KYC <?= $edit_pending_customer['semail']; ?>
						</h3>
					</header>

					<div class="panel-body">
						<p>
							<!-- Upload your personal or company documents for Verification -->
						</p>
						<input type="hidden" id="custId" name="sender_id" value="<?php echo $this->uri->segment(2); ?>">
						<input type="hidden" name="kyc_id" name="kyc_id" value="<?php echo $edit_pending_customer['id'] ?>">
						<div class="row row-lg">
							<div class="col-lg-6">
								<div class="example-wrap">
									<h3 class="example-title"></h3>
									<div class="example">
										<div class="form-group form-material">
											<label class="form-control-label">Source</label>
											<!-- <select class="form-control select2-hidden-accessible rounded" name="source_id" data-plugin="select2"  data-allow-clear="true"  tabindex="-1" aria-hidden="true" name="source_id" > -->
											<select class="form-control select2 rounded" name="source_id" data-allow-clear="true" tabindex="-1" aria-hidden="true" name="source_id">
												<option value="">Please Select Source</option>
												<?php if (!empty($source_user_data)) :
													foreach ($source_user_data as $source_user) : ?>
														<option value="<?php echo @$source_user['id']; ?>" <?php if (@$edit_pending_customer['created_by'] == @$source_user['id']) {
																												echo "selected";
																											} ?>>
															<?php echo  @$source_user['name']; ?></option>
												<?php endforeach;
												endif; ?>
											</select>
											<?php if (isset($errors['source_id'])) { ?>
												<label class="error"><?= @$errors['source_id'] ?></label>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-6">
								<!-- Example Multi Balue -->
								<div class="example-wrap">
									<h4 class="example-title"></h4>
									<div class="example">
										<div class="form-group form-material">
											<label class="form-control-label">Logistic</label>
											<select class="form-control select2" name="logistic_id[]" id="logistic_id" multiple>
												<option>Please Select Logistic</option>
												<?php if (!empty($all_active_logistic)) :
													foreach (@$all_active_logistic as $active_logistics) : if (in_array(@$active_logistics['id'], $customer_logistics)) {
															$select = "selected";
														} else {
															$select = '';
														} ?>
														<option value="<?php echo @$active_logistics['id']; ?>" <?php echo $select; ?>>
															<?php echo  @$active_logistics['logistic_name']; ?></option>
												<?php endforeach;
												endif; ?>
											</select>
											<?php if (isset($errors['logistic_id[]'])) { ?>
												<label class="error"><?= @$errors['logistic_id[]'] ?></label>
											<?php } ?>
										</div>
									</div>
								</div>
								<!-- End Example Multi Balue -->
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="example-wrap">
									<h4 class="example-title"></h4>
									<div class="example">
										<div class="form-group form-material">
											<label class="form-control-label">Select Profile Type</label>
											<select class="form-control select2 rounded" name="profile_type" data-allow-clear="true" tabindex="-1" aria-hidden="true" id="profile_types">
												<option value="">Select Profile Type</option>
												<option value="1" <?php echo set_select('profile_type', "1", ($edit_pending_customer['profile_type'] == "1") ? TRUE : ''); ?>>
													Company</option>
												<option value="0" <?php echo set_select('profile_type', "0", ($edit_pending_customer['profile_type'] == "0") ? TRUE : ''); ?>>
													Individual</option>
											</select>
											<?php if (isset($errors['profile_type'])) { ?>
												<label class="error"><?= @$errors['profile_type'] ?></label>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="example-wrap">
									<h4 class="example-title"></h4>
									<div class="example">
										<div class="form-group form-material">
											<label class="form-control-label">Customer Password</label>
											<input type="password" id="password" name="customer_password" class="form-control" readonly value="<?php echo $edit_pending_customer['password']; ?>" style="position: relative;margin-left:19px">
											<div class="form-control-feedback1">
												<i class="fa fa-eye" id="togglePassword" style="bottom: 30px;margin-left: 480px"></i>
											</div>
											<!-- <a class="password_hide"><i class="fa fa-eye-slash" id="togglePassword" style="position: relative;bottom: 30px;margin-left: 480px"></i></a> -->
										</div>
									</div>
								</div>
							</div>
						</div>

						<?php if ($edit_pending_customer['profile_type'] == "1") {
							$stylediv = 'style="display: block"';
						} else {
							$stylediv = 'style="display: none"';
						} ?>
						<div class="row row-lg" id="company_div" <?= $stylediv; ?>>
							<div class="col-lg-6">
								<div class="example-wrap">
									<h4 class="example-title"></h4>
									<div class="example">
										<div class="form-group form-material">
											<label class="form-control-label">Company Type</label>
											<select id="company_type" data-allow-clear="true" tabindex="-1" aria-hidden="true" name="company_type" class="form-control select2">
												<option value="">Select Company Type</option>
												<option value="0" <?php echo set_select('company_type', "0", ($edit_pending_customer['company_type'] == "0") ? TRUE : ''); ?>>
													Sole Proprietorship</option>
												<option value="1" <?php echo set_select('company_type', "1", ($edit_pending_customer['company_type'] == "1") ? TRUE : ''); ?>>
													Partnership</option>
												<option value="2" <?php echo set_select('company_type', "2", ($edit_pending_customer['company_type'] == "2") ? TRUE : ''); ?>>
													Limited Liability Partnership</option>
												<option value="3" <?php echo set_select('company_type', "3", ($edit_pending_customer['company_type'] == "3") ? TRUE : ''); ?>>
													Public Limited Company</option>
												<option value="4" <?php echo set_select('company_type', "0", ($edit_pending_customer['company_type'] == "0") ? TRUE : ''); ?>>
													Private Limited Company</option>
											</select>
											<?php if (isset($errors['company_type'])) { ?>
												<label class="error"><?= @$errors['company_type'] ?></label>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="">
									<h4 class="example-title"></h4>
									<div class="example">
										<div class="form-group form-material">
											<label class="form-control-label">Company Name</label>
											<input type="text" name="company_name" class="form-control" placeholder="Company Name" value="<?php echo $edit_pending_customer['company_name']; ?>">
											<?php if (isset($errors['company_name'])) { ?>
												<label class="error"><?= @$errors['company_name'] ?></label>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="">
									<div class="example">
										<div class="form-group form-material">
											<label class="form-control-label">Pan Number</label>
											<input type="text" class="form-control pan_number" name="pan_no" value="<?= $edit_pending_customer['pan_no']; ?>" placeholder="Pan Number" autocomplete="off" />
											<?php if (isset($errors['pan_no'])) { ?>
												<label class="error"><?= @$errors['pan_no'] ?></label>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="example-wrap">
									<div class="example">
										<div class="form-group form-material">
											<label class="form-control-label">GSt Number</label>
											<input type="text" class="form-control gst_number" name="gst_no" value="<?php echo $edit_pending_customer['gst_no']; ?>" placeholder="gst Number" autocomplete="off" />
											<?php if (isset($errors['gst_no'])) { ?>
												<label class="error"><?= @$errors['gst_no'] ?></label>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel">
					<header class="panel-heading">
						<h3 class="panel-title panel-style">
							Billing Address Info
						</h3>
					</header>
					<div class="panel-body">
						<div class="example-wrap">
							<h4 class="example-title"></h4>
							<div class="example">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group form-material">
											<label class="form-control-label">Pincode</label>
											<input type="text" class="form-control pincode" name="pincode" id="kycpincode" value="<?php echo $edit_pending_customer['pincode']; ?>" placeholder="Pincode" autocomplete="off" />
											<?php if (isset($errors['pincode'])) { ?>
												<label class="error"><?= @$errors['pincode'] ?></label>
											<?php } ?>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group form-material">
											<label class="form-control-label">City</label>
											<input type="text" class="form-control city" name="city" placeholder="City" value="<?php echo $edit_pending_customer['city']; ?>" autocomplete="off" />
											<?php if (isset($errors['city'])) { ?>
												<label class="error"><?= @$errors['city'] ?></label>
											<?php } ?>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group form-material">
											<label class="form-control-label">State</label>
											<input type="text" class="form-control state" name="state" placeholder="State" value="<?php echo $edit_pending_customer['state']; ?>" autocomplete="off" />
											<?php if (isset($errors['state'])) { ?>
												<label class="error"><?= @$errors['state'] ?></label>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="example-wrap">
							<h4 class="example-title"></h4>
							<div class="example">
								<div class="form-group form-material">
									<label class="form-control-label">Address Line 1</label>
									<input type="text" class="form-control address1" name="address_1" placeholder="Address Line 1" value="<?php echo $edit_pending_customer['address_1']; ?>" autocomplete="off" />
									<?php if (isset($errors['address_1'])) { ?>
										<label class="error"><?= @$errors['address_1'] ?></label>
									<?php } ?>
								</div>
							</div>
							<div class="example">
								<div class="form-group form-material">
									<label class="form-control-label">Address Line 2</label>
									<input type="text" class="form-control address2" name="address_2" placeholder="Address Line 2" value="<?php echo $edit_pending_customer['address_2']; ?>" autocomplete="off" />
									<?php if (isset($errors['address_2'])) { ?>
										<label class="error"><?= @$errors['address_2'] ?></label>
									<?php } ?>
								</div>
							</div>
						</div>
						<!--  </div> -->
					</div>
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title"></h3>
						</div>
						<div class="panel-body container-fluid">
							<div class="row row-lg">
								<div class="col-lg-6">
									<div class="">
										<h3 class="example-title">Document 1</h3>
										<div class="example">
											<select class="form-control select2" name="doc1_id" data-allow-clear="true" tabindex="-1" aria-hidden="true" name="profile_type">
												<option value="">Select Address Proof</option>
												<?php foreach ($document_list as $single_document_list) {
													if ($single_document_list['doc_type'] == '1') { ?>
														<option value="<?php echo $single_document_list['id']; ?>" <?= (in_array('1', $kyc_doc_type) && $kyc_doc_list['1'][0]['doc_id'] == $single_document_list['id']) ? 'selected' : ''; ?>>
															<?php echo $single_document_list['document_name']; ?></option>
												<?php }
												} ?>
											</select>
											<label id="doc1_id-error" class="error" for="doc1_id"></label>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="">
										<h3 class="example-title">Document 2</h3>
										<div class="example">
											<select class="form-control select2  rounded" name="doc2_id" data-allow-clear="true" tabindex="-1" aria-hidden="true" name="profile_type">
												<option>Select Identification Proof</option>
												<?php foreach ($document_list as $single_document_list) {
													if ($single_document_list['doc_type'] == '2') { ?>
														<option value="<?php echo $single_document_list['id']; ?>" <?= (in_array('2', $kyc_doc_type) && $kyc_doc_list['2'][0]['doc_id'] == $single_document_list['id']) ? 'selected' : ''; ?>>
															<?php echo $single_document_list['document_name']; ?></option>
												<?php }
												} ?>
											</select>
											<label id="doc2_id-error" class="error" for="doc2_id"></label>
										</div>
									</div>
								</div>
							</div>
							<div class="row row-lg">
								<?php if (in_array('1', $kyc_doc_type)) {
									foreach ($kyc_doc_list['1'] as $docVal) {
								?>
										<div class="col-lg-3">
											<div class="example-wrap">
												<h4 class="example-title"></h4>
												<div class="example">
													<div id="doc_1_img_1_id_1">
														<?php $image1 = "./uploads/kyc_verification_document/doc1_image/" . $docVal['image'];
														$extension4 = (explode('.', $image1));
														$extension4 = end($extension4);
														if ($docVal['image'] != '' && file_exists($image1)) { ?>
															<button type="button" class="remove_btn doc_1_img1_btn edit btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light waves-effect waves-classic">
																<i class="icon md-delete" aria-hidden="true"></i>
															</button>
															<input type="hidden" name="doc1_img_names[]" value="<?php echo $docVal['image'] ?>">
															<input type="hidden" name="doc1_img_id[]" value="<?php echo $docVal['id'] ?>">

															<?php if ($extension4 != 'pdf') : ?>
																<img src="<?php echo base_url($image1); ?>" />
															<?php else : ?>
																<a href="<?= base_url('uploads/kyc_verification_document/doc1_image/') . $docVal['image'] ?>" target="_blank"><img src="<?php echo base_url('assets/custom/img/pdf.png') ?>" alt=""></a>
															<?php endif; ?>
														<?php } else { ?>
															<input type="file" name="doc1_1_img[]" accept="image/*, application/pdf" id="doc1_1_img" data-plugin="dropify" data-default-file="" />
														<?php } ?>
													</div>
													<div id="doc_1_img_1_id_2" style="display: none;">
														<input type="file" name="doc1_1_img[]" accept="image/*, application/pdf" id="doc1_1_img" data-plugin="dropify" data-default-file="" />
													</div>
												</div>
											</div>
										</div>
									<?php }
								} else { ?>
									<div class="col-lg-3">
										<div class="example-wrap">
											<h4 class="example-title"></h4>
											<div class="example">
												<div id="doc_1_img_1_id_1">
													<input type="file" name="doc1_1_img[]" accept="image/*, application/pdf" id="doc1_1_img" data-plugin="dropify" data-default-file="" />
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="example-wrap">
											<h4 class="example-title"></h4>
											<div class="example">
												<div id="doc_1_img_1_id_1">
													<input type="file" name="doc1_1_img[]" accept="image/*, application/pdf" id="doc1_1_img" data-plugin="dropify" data-default-file="" />
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if (in_array('2', $kyc_doc_type)) {
									foreach ($kyc_doc_list['2'] as $docVal) {
								?>
										<div class="col-lg-3">
											<div class="example-wrap">
												<h4 class="example-title"></h4>
												<div class="example">
													<div id="doc_1_img_2_id_1">
														<?php $image1 = "./uploads/kyc_verification_document/doc2_image/" . $docVal['image'];
														$extension1 = (explode('.', $image1));
														$extension1 = end($extension1);
														if ($docVal['image'] != '' && file_exists($image1)) { ?>
															<button type="button" class="remove_btn doc_3_btn_edit edit btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light waves-effect waves-classic">
																<i class="icon md-delete" aria-hidden="true"></i>
															</button>
															<input type="hidden" name="doc2_img_names[]" value="<?php echo $docVal['image'] ?>">
															<input type="hidden" name="doc2_img_id[]" value="<?php echo $docVal['id'] ?>">
															<?php if ($extension1 != 'pdf') : ?>
																<img src="<?php echo base_url($image1); ?>" />
															<?php else : ?>
																<a href="<?= base_url('/uploads/kyc_verification_document/doc2_image/') . $docVal['image'] ?>" target="_blank"><img src="<?php echo base_url('assets/custom/img/pdf.png') ?>" alt=""></a>
															<?php endif; ?>
														<?php } else { ?>
															<input type="file" name="doc2_1_img[]" accept="image/*, application/pdf" id="doc1_1_img" data-plugin="dropify" data-default-file="" />
														<?php } ?>
													</div>

													<div id="doc_1_img_2_id_2" style="display: none;">
														<input type="file" name="doc2_1_img[]" accept="image/*, application/pdf" id="doc1_1_img" data-plugin="dropify" data-default-file="" />
													</div>
												</div>
											</div>
										</div>
									<?php }
								} else { ?>
									<div class="col-lg-3">
										<div class="example-wrap">
											<h4 class="example-title"></h4>
											<div class="example">
												<div id="doc_1_img_1_id_1">
													<input type="file" name="doc2_1_img[]" accept="image/*, application/pdf" id="doc1_1_img" data-plugin="dropify" data-default-file="" />
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="example-wrap">
											<h4 class="example-title"></h4>
											<div class="example">
												<div id="doc_1_img_1_id_1">
													<input type="file" name="doc2_1_img[]" accept="image/*, application/pdf" id="doc1_1_img" data-plugin="dropify" data-default-file="" />
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
							<hr>
							<div class="row">
								<div class="col-xl-3 col-md-3">
									<!-- Example Default -->
									<div class="example-wrap">
										<h3 class="example-title">CANCELLED CHEQUE</h3>
										<div class="example">
											<div id="cc_id_1">
												<?php if (in_array('4', $kyc_doc_type) && $kyc_doc_list['4'][0]['image'] != '') { ?>
													<button type="button" id="cc_btn" class="edit btn-raised btn-sm btn btn-danger btn-floating waves-effect waves-classic waves-effect waves-light waves-effect waves-classic">
														<i class="icon md-delete" aria-hidden="true"></i>
													</button>
													<?php $cancelled_cheque_image = "./uploads/kyc_verification_document/cancelled_cheque_image/" . $kyc_doc_list['4'][0]['image'];
													$extension3 = (explode('.', $cancelled_cheque_image));
													$extension3 = end($extension3);
													if (file_exists($cancelled_cheque_image)) { ?>
														<input type="hidden" name="cc_img_name" value="<?php echo $kyc_doc_list['4'][0]['image'] ?>">
														<input type="hidden" name="cc_img_id" value="<?php echo $kyc_doc_list['4'][0]['id'] ?>">
														<?php if ($extension3 != 'pdf') : ?>
															<img src="<?php echo base_url($cancelled_cheque_image) ?>" />
														<?php else : ?>
															<a href="<?= base_url('/uploads/kyc_verification_document/cancelled_cheque_image/') . $kyc_doc_list['4'][0]['image']; ?>" target="_blank"><img src="<?php echo base_url('assets/custom/img/pdf.png') ?>" alt=""></a>
														<?php endif; ?>


													<?php } else { ?>
														<input type="file" name="cancelled_cheque_image" accept="image/*, application/pdf" id="cancelled_cheque_image" data-plugin="dropify" data-default-file="" />
													<?php }
												} else { ?>
													<input type="file" name="cancelled_cheque_image" accept="image/*, application/pdf" id="cancelled_cheque_image" data-plugin="dropify" data-default-file="" />
												<?php } ?>
											</div>
											<div id="cc_id_2" style="display: none;">
												<input type="file" name="cancelled_cheque_image" accept="image/*, application/pdf" id="cancelled_cheque_image" data-plugin="dropify" data-default-file="" />
											</div>
										</div>
									</div>
									<!-- End Example Default -->
								</div>
								<div class="col-xl-6 col-md-12">
									<h3 class="example-title">Bank Details</h3>
									<div class="example">
										<div class="col-md-12 form-group form-material">
											<label class="form-control-label">Bank Name</label>
											<input type="text" class="form-control bankname" name="bankname" value="<?php echo $edit_pending_customer['bankname']; ?>" placeholder="Enter Bank Name" autocomplete="off" />
											<?php if (isset($errors['bankname'])) { ?>
												<label class="error"><?= @$errors['bankname'] ?></label>
											<?php } ?>
										</div>
										<div class="col-md-12 form-group form-material">
											<label class="form-control-label">Benificiary Name</label>
											<input type="text" class="form-control benificiary" name="benificiary" value="<?php echo $edit_pending_customer['benificiary']; ?>" placeholder="Enter Benificiary  Name" autocomplete="off" />
											<?php if (isset($errors['benificiary'])) { ?>
												<label class="error"><?= @$errors['benificiary'] ?></label>
											<?php } ?>
										</div>

										<div class="col-md-6 form-group form-material">
											<label class="form-control-label">Account No :</label>
											<input type="text" class="form-control acno" name="acno" value="<?php echo $edit_pending_customer['account_no']; ?>" placeholder="Enter Account No" autocomplete="off" />
											<?php if (isset($errors['acno'])) { ?>
												<label class="error"><?= @$errors['acno'] ?></label>
											<?php } ?>
										</div>
										<div class="col-md-6  form-material">
											<label class="form-control-label">IFSC Code :</label>
											<input type="text" class="form-control ifsc" name="ifsc" value="<?php echo $edit_pending_customer['ifsc_code']; ?>" placeholder="Enter IFSC Code" autocomplete="off" />
											<?php if (isset($errors['ifsc'])) { ?>
												<label class="error"><?= @$errors['ifsc'] ?></label>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>

							<?php if (@$edit_pending_customer['status'] == '0') { ?>
								<h4 class="form-section">Rejection Reason</h4>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<textarea class="form-control" maxlength="250" placeholder="Rejection Reason" name="rejection_reason"></textarea>
											<?php if (isset($errors['rejection_reason'])) { ?>
												<label class="error"><?= @$errors['rejection_reason'] ?></label>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
						<br>
						<div class="form-actions right">
							<div class="animation-example animation-hover hover">
								<?php if (@$edit_pending_customer['status'] == '0') { ?>
									<button class="btn btn-primary pull-left legitRipple" id="add_kyc" name="approved" value="Approved" type="submit">Approved</button>
									<button class="btn btn-danger" type="submit" value="Reject" name="reject">Reject</button>
								<?php } else { ?>
									<button class="btn btn-primary pull-left legitRipple" id="add_kyc" name="submit" value="submit" type="submit">Save</button>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
	const togglePassword = document.querySelector('#togglePassword');
	const password = document.querySelector('#password');
	togglePassword.addEventListener('click', function(e) {
		// toggle the type attribute

		const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
		password.setAttribute('type', type);
		// toggle the eye slash icon
		this.classList.toggle('fa-eye-slash');
	});
</script>
