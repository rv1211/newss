<style type="text/css">
	.orderList {
		padding: 0.715rem 2.072rem;
	}

	.print_btn {
		margin-right: 15px;
	}

	.assign_label_choose_div.show {
		height: 185px !important;
		overflow-y: scroll !important;
	}

	.radio-btn {
		padding: 5px;
	}

	.radio-btn:first-child input[type=radio] {
		width: 17px;
		height: 17px;
	}

	.radio-btn:last-child input[type=radio] {
		transform: scale(1.5);
	}

	.export_btn_create {
		left: 155%;
		height: 36px;
		margin-top: -159px;
	}

	/* .order_nav {
		padding: -6.285rem 12.072rem;
	} */

	b {
		font-weight: 1000;
	}

	#order_intransit_filter {
		margin-top: -60px !important;
	}


	/* .export_btn_order_intransit {
		left: 380%;
		height: 40px;
		margin-top: -163px;
	} */

	/* .intransit_orders_export {
		margin-left: 980px !important;
		top: -5px !important;
	} */
</style>
<div class="page">
	<div class="page-header">
		<h1 class="page-title">Orders</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
			<li class="breadcrumb-item active">Orders</li>
		</ol>
	</div>
	<div class="page-content">
		<!-- Panel Basic -->

		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title"><span style="visibility: hidden;">sfs</span></h3>
				<div class="panel-actions">
					<button style="height: 36px;" type="button" class="btn btn-primary dropdown-toggle waves-effect waves-classic" id="exampleSizingDropdown2" data-toggle="dropdown" aria-expanded="false">
						Label Option
					</button>
					<?php if ($this->session->userdata('userType') == '1') { ?>
						<div class="dropdown-menu assign_label_choose_div" aria-labelledby="exampleSizingDropdown2" role="menu" x-placement="top-start" style="position: absolute; left: 0px; will-change: transform; transform: translate3d(0px, -204px, 0px); top: 0px;">
							<!-- <div class="scroller" style="display:flex">
								<div class="radio-btn">
									<input type="radio" name="radio_btn" checked="" value="1" data-name="first">
								</div>

								<div class="ifram">
									<a class="dropdown-item" href="javascript:void(0)" role="menuitem">
										<iframe src="<?php echo base_url() . "uploads/sample_label_pdf/sample_1.pdf"; ?>" frameborder="0">
										</iframe>
									</a>
								</div>
							</div>
							<hr>
							<div class="scroller" style="display:flex">
								<div class="radio-btn">
									<input type="radio" name="radio_btn" value="2" data-name="second">
								</div>

								<div class="ifram">
									<a class="dropdown-item" href="javascript:void(0)" role="menuitem">
										<iframe src="<?php echo base_url() . "uploads/sample_label_pdf/sample_2.pdf" ?>" frameborder="0">
										</iframe>
									</a>
								</div>
							</div>
							<hr>
							<div class="scroller" style="display:flex">
								<div class="radio-btn">
									<input type="radio" name="radio_btn" value="3" data-name="third">
								</div>

								<div class="ifram">
									<a class="dropdown-item" href="javascript:void(0)" role="menuitem">
										<iframe src="<?php echo base_url() . "uploads/sample_label_pdf/sample_3.pdf"; ?>" frameborder="0">
										</iframe>
									</a>
								</div>
							</div>
							<hr> -->
							<!-- <div class="scroller" style="display:flex">
                                <div class="radio-btn">
                                    <input type="radio" name="radio_btn" value="4" data-name="forth">
                                </div>

                                <div class="ifram">
                                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <iframe
                                            src="<?php echo base_url() . "uploads/sample_label_pdf/sample_4.pdf"; ?>"
                                            frameborder="0">
                                        </iframe>
                                    </a>
                                </div>
                            </div> -->
							<div class="scroller" style="display:flex">
								<div class="radio-btn">
									<input type="radio" name="radio_btn" checked value="5" data-name="fifth">
								</div>

								<div class="ifram">
									<a class="dropdown-item" href="javascript:void(0)" role="menuitem">
										<iframe src="<?php echo base_url() . "uploads/sample_label_pdf/sample_5.pdf"; ?>" frameborder="0">
										</iframe>
									</a>
								</div>
							</div>
							<!-- <div class="scroller" style="display:flex">
								<div class="radio-btn">
									<input type="radio" name="radio_btn" value="6" data-name="sixth">
								</div>
								<div class="ifram">
									<a class="dropdown-item" href="javascript:void(0)" role="menuitem">
										<iframe src="<?php echo base_url() . "uploads/sample_label_pdf/sample_6.pdf"; ?>" frameborder="0">
										</iframe>
									</a>
								</div>
							</div>
							<div class="scroller" style="display:flex">
								<div class="radio-btn">
									<input type="radio" name="radio_btn" value="7" data-name="seventh">
								</div>
								<div class="ifram">
									<a class="dropdown-item" href="javascript:void(0)" role="menuitem">
										<iframe src="<?php echo base_url() . "uploads/sample_label_pdf/sample_7.pdf"; ?>" frameborder="0">
										</iframe>
									</a>
								</div>
							</div>
							<div class="scroller" style="display:flex">
								<div class="radio-btn">
									<input type="radio" name="radio_btn" value="8" data-name="eighth">
								</div>
								<div class="ifram">
									<a class="dropdown-item" href="javascript:void(0)" role="menuitem">
										<iframe src="<?php echo base_url() . "uploads/sample_label_pdf/sample_8.pdf"; ?>" frameborder="0">
										</iframe>
									</a>
								</div>
							</div> -->
							<!-- <div class="scroller" style="display:flex">
                                <div class="radio-btn">
                                    <input type="radio" name="radio_btn" value="9" data-name="nineth">
                                </div>
                                <div class="ifram">
                                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <iframe
                                            src="<?php //echo base_url() . "uploads/sample_label_pdf/sample_9.pdf"; 
													?>"
                                            frameborder="0">
                                        </iframe>
                                    </a>
                                </div>
                            </div> -->
							<!-- <div class="scroller" style="display:flex">
								<div class="radio-btn">
									<input type="radio" name="radio_btn" value="0" data-name="tenth">
								</div>
								<div class="ifram">
									<a class="dropdown-item" href="javascript:void(0)" role="menuitem">
										<iframe src="<?php // echo base_url() . "uploads/sample_label_pdf/sample_0.pdf"; 
														?>" frameborder="0">
										</iframe>
									</a>
								</div>
							</div> -->

						</div><?php } else { ?>
						<div class="dropdown-menu assign_label_choose_div" aria-labelledby="exampleSizingDropdown2" role="menu" x-placement="top-start" style="position: absolute; left: 0px; will-change: transform; transform: translate3d(0px, -5px, 0px);">
							<?php if ($assign_labels) {
									foreach ($assign_labels as $key => $labels) { ?>
									<div class="scroller" style="display:flex">
										<div class="radio-btn">
											<input type="radio" name="radio_btn" <?php if ($key == '0') {
																						echo "checked";
																					} ?> value="<?php echo $labels['label_type']; ?>" data-name="<?php echo str_replace(array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0'), array('first', 'second', 'third', 'forth', 'fifth', 'sixth', 'seventh', 'eighth', 'nineth', 'tenth'), $labels['label_type']); ?>">
										</div>
										<div class="ifram">
											<a class="dropdown-item" href="javascript:void(0)" role="menuitem">
												<iframe src="<?php echo base_url() . "uploads/sample_label_pdf/sample_" . $labels['label_type'] . ".pdf"; ?>" frameborder="0">
												</iframe>
											</a>
										</div>
									</div>
									<hr />
								<?php }
								} else { ?>
								<b>No lable found</b>
							<?php } ?>
						</div>
					<?php } ?>
					<button type=" button print_btn" id="multi_print" class="btn btn-primary waves-effect waves-classic">Print Packing Slip</button>
					<button type="button print_btn" id="multi_print_manifest" class="btn btn-primary waves-effect waves-classic waves-effect waves-classic">Print Multiple Manifest</button>
					<!-- <button type="button" id="multiple_delete" class="btn btn-danger">Cancel Multiple</button> -->
				</div>
			</div>
			<div class="panel-body container-fluid">
				<div class="row row-lg">
					<div class="col-xl-12">
						<div class="form-group form-material">
							<!-- <div class="btn-group">
                    <button type="button print_btn" id="multi_print_manifest" class="btn btn-primary waves-effect waves-classic waves-effect waves-classic" style="float:right;margin-left:900px;">Print Multiple Manifest</button>
                  </div> -->
						</div>
						<!-- Example Tabs -->
						<div class="example-wrap">
							<div class="nav-tabs-horizontal" data-plugin="tabs">
								<ul class="nav nav-tabs" role="tablist">
									<?php require APPPATH . 'views/admin/order/tab_list.php'; ?>
								</ul>
								<div class="tab-content pt-20">
									<div class="tab-pane active" id="ofp_tab" role="tabpanel">
										<table class="table table-striped table-borderd" id="order_ofp">
											<thead>
												<tr>
													<th class="noExport"><input type="checkbox" class="all_manifested_order" id="select_all" name="select_all" value="1"></th>
													<th>Order ID</th>
													<th>Order Number</th>
													<th>Airwaybill Number</th>
													<th>Logistic Name</th>
													<th>Customer Name</th>
													<th>Customer Number</th>
													<th>Order Type</th>
													<th>Create Date</th>
													<th>Last Status Date</th>
													<th>Last Remarks</th>
													<th>Order Status</th>
													<?php if ($this->session->userdata('userType') == '1') { ?>
														<th>User</th>
													<?php } ?>

													<th class="noExport">Action</th>
													<th class="noExport">Order Tracking</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>

								</div>
							</div>
						</div>
						<!-- End Example Tabs -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Panel Basic -->
	</div>
</div>
<!-- End Page -->


<div class="modal fade modal-fade-in-scale-up" id="myModal" role="dialog">
	<div class="modal-dialog modal-simple modal-lg">
		<div class="modal-content">
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>
