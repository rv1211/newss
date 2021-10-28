<div class="page">
	<div class="page-header">
		<h1 class="page-title">Cod Remittance</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url(); ?>">home</a></li>
			<li class="breadcrumb-item active">Cod Remittance</li>
		</ol>
	</div>
	<div class="page-content">
		<div class="panel">
			<?php require APPPATH . 'views/admin/codremittance/cod_card.php'; ?>
		</div>
		<!-- Panel Basic -->
		<div class="panel">
			<div class="panel-body container-fluid">
				<div class="row row-lg" style="margin-top: 40px;">
					<div class="form-group form-material">
					</div>
					<div class="col-xl-12">

						<!-- Example Tabs -->
						<div class="example-wrap">
							<div class="nav-tabs-horizontal" data-plugin="tabs">
								<ul class="nav nav-tabs" role="tablist">
									<?php require APPPATH . 'views/admin/codremittance/cod_tab_list.php'; ?>
								</ul>
								<div class="tab-content pt-20">
									<div class="tab-pane active" id="all_tab" role="tabpanel">
										<table class="table table-striped table-borderd" id="cod_shipping_charge" width="100%">
											<thead>
												<tr>
													<th width="12%">Invoice No. </th>
													<th width="10%">Invoice Date </th>
													<th width="10%">Order Id </th>
													<th width="10%">AWB No. </th>
													<th width="10%">Logistics </th>
													<th width="10%">Order Status </th>
													<th width="10%">Order Date </th>
													<th width="10%">Zone</th>
													<th width="10%">Billing Weight</th>
													<th width="15%">Total Freight Charge</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th colspan="11">
														<center>
															<h3 style="color: #616161;">Coming Soon</h3>
															<center>
													</th>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<!-- End Page -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
