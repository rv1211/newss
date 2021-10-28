<style type="text/css">
	.orderList {
		padding: 0.715rem 2.072rem;
	}

	.print_btn {
		margin-right: 15px;
	}

	#waitingorder_list_filter {
		margin-top: -60px !important;
	}

	/* .export_btn_waitingorder_list {
    left: 380%;
    height: 40px;
    margin-top: -163px;
} */

	/* .waiting_orders_export{
    margin-left: 980px  !important;
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
	<div class="page-content ">
		<!-- Panel Basic -->
		<div class="panel">
			<div class="panel-body container-fluid">
				<div class="row " style="margin-left:70%">
					<div class="form-group form-material">
						<!-- <div class="btn-group">
                    <button type="button print_btn" id="multi_print" class="btn btn-primary waves-effect waves-classic" style="float:right;margin-left:200px;">Multiple Print</button>
                    
                  </div> -->
					</div>
				</div>
				<div class="row row-lg" style="margin-top:20px;">
					<div class="col-xl-12">
						<!-- Example Tabs -->
						<div class="example-wrap">
							<div class="nav-tabs-horizontal" data-plugin="tabs">
								<ul class="nav nav-tabs" role="tablist">
									<?php require APPPATH . 'views/admin/order/tab_list.php'; ?>
								</ul>
								<div class="tab-content pt-20">

									<div class="tab-pane active" id="created_tab" role="tabpanel">
										<table class="table table-striped table-borderd" id="waitingorder_list">
											<thead>
												<tr>
													<th class="noExport"><input type="checkbox" class="waiting_list_order" id="select_all" name="select_all" value="1"></th>
													<th>Order ID</th>
													<th>Order Number</th>
													<th>Airwaybill Number</th>
													<th>Logistic Name</th>
													<th>Customer Name</th>
													<th>Customer Number</th>
													<th>Order Type</th>
													<th>Create Date</th>
													<th>Remarks</th>
													<?php if ($this->session->userdata('userType') == '1') { ?>
														<th>User</th>
													<?php } ?>
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
