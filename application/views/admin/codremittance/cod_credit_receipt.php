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
			<div class="panel-body">
				<!-- Cod countes box  -->
				<div class="row">
					<div class="col-md-3">
						<div class="card card-inverse card1 ">
							<div class="card-block">
								<h5 class="card-title">TOTAL COD GENERATED</h5>
								<p class="card-text">
								<h3 class="d-inline text-white">&#8377; <?= $total_cod['Totalcod']; ?></h3>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-inverse card2 ">
							<div class="card-block">
								<h5 class="card-title">TOTAL BILL ADJUSTED</h5>
								<p class="card-text">
								<h3 class="d-inline text-white">&#8377; 00</h3>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-inverse card3 ">
							<div class="card-block">
								<h5 class="card-title">TOTAL REFUND ADJUSTED</h5>
								<p class="card-text">
								<h3 class="d-inline text-white">&#8377; 00</h3>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-inverse card4 ">
							<div class="card-block">
								<h5 class="card-title">TOTAL ADVANCED HOLD</h5>
								<p class="card-text">
								<h3 class="d-inline text-white">&#8377; 00</h3>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-inverse card1 ">
							<div class="card-block">
								<h5 class="card-title">TOTAL COD REMITTED</h5>
								<p class="card-text">
								<h3 class="d-inline text-white">&#8377; 00</h3>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-inverse card2 ">
							<div class="card-block">
								<h5 class="card-title">EARLY COD</h5>
								<p class="card-text">
								<h3 class="d-inline text-white">&#8377; 00</h3>
								</p>
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="card card-inverse card3 ">
							<div class="card-block">
								<h5 class="card-title">WALLET TRANFEREED</h5>
								<p class="card-text">
								<h3 class="d-inline text-white">&#8377; 00</h3>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-inverse card4 ">
							<div class="card-block">
								<h5 class="card-title">UNREMITTED COD</h5>
								<p class="card-text">
								<h3 class="d-inline text-white">&#8377; 00</h3>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="card card-inverse card1 ">
							<div class="card-block">
								<h5 class="card-title">NEXT REMITTANCE</h5>
								<p class="card-text">
								<h3 class="d-inline text-white">&#8377; 00</h3>
								</p>
							</div>
						</div>
					</div>
				</div>
				<!-- end cod countes box -->

			</div>
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
										<table class="table table-striped table-borderd" id="cod_credit_receipt" width="100%">
											<thead>
												<tr>
													<th width="12%">CN No. </th>
													<th width="10%">Date</th>
													<th width="10%">CN Generated </th>
													<th width="10%">CN Available </th>
													<th width="10%">CN Utilized </th>
													<th width="10%">CN Type</th>
													<th width="10%">Status </th>
													<th width="10%">Action</th>
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
