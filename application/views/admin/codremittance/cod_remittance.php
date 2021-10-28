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
										<table class="table table-striped table-borderd" id="cod_remittance" width="100%">
											<thead>
												<tr>
													<th>Remitted Date</th>
													<th>Remitted Amount</th>
													<th>Note</th>
													<th>Action</th>
													<th>Customer</th>
												</tr>
											</thead>
											<tbody></tbody>
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
<div class="modal fade modal-fade-in-scale-up" id="myModal" role="dialog">
	<div class="modal-dialog modal-simple modal-lg">
		<div class="modal-content">
			<div class="modal-body cod-modal-body">
			</div>
		</div>
	</div>
</div>
