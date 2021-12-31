<div class="page">
	<!-- start page header -->
	<div class="page-header">
		<h1 class="page-title">Logistic Import</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
			<!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Create Order</a></li> -->
			<li class="breadcrumb-item active">Logistic Import</li>
		</ol>
	</div>
	<!-- end page header -->
	<!-- start page content -->
	<div class="page-content">
		<form action="<?= base_url('import-logistic'); ?>" name="logistic_import_form" method="POST" id="logistic_import_form" autocomplete="off" enctype="multipart/form-data">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">
						Import Logistic
						<hr>
					</h3>
				</div>
				<!-- end panel heading -->
				<div class="panel-body container-fluid">

					<div class="row row-lg">
						<div class="col-md-4">
							<div class="form-group form-material">
								<div class="example-wrap">
									<h5 class="">Choose file for import pincode</h5>
									<div class="example">
										<input type="file" name="logistic_excel" class="dropify-event" id="logistic_excel" data-plugin="dropify" data-default-file="" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
										<!-- <input type="file" name="logistic_excel" id="input-file-events" class="dropify-event" data-default-file="../../../global/photos/placeholder.png"> -->
									</div>
								</div>
								<?php if (isset($errors['logistic_excel'])) : ?>
									<label class="text-danger"><?= $errors['logistic_excel']; ?></label>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="row row-lg">
						<div class="col-md-1">
							<div class="form-group form-material">
								<button type="submit" id="import_btn" class="btn btn-primary waves-effect waves-classic waves-effect waves-classic excel">Import Excel</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end panel body -->
		</form>
	</div>
	<!-- end page content -->
</div>
