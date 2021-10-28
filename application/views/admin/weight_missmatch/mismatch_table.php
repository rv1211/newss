    <style>
    	@media (min-width: 992px) {
    		.modal-lg {
    			max-width: 1440px !important;
    		}
    	}
    </style>

    <!-- Page -->
    <div class="modal fade modal-fade-in-scale-up example-modal-xl ndr" id="ndr_order_comment" aria-hidden="true" aria-labelledby="example-modal-xl" role="dialog" tabindex="-1">
    	<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">×</span>
    				</button>
    			</div>
    			<div class="modal-body modal-body-missmatch">
    				<div class="ndr_comment">
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="page">
    	<div class="page-header">
    		<h1 class="page-title">Missmatch List</h1>
    		<ol class="breadcrumb">
    			<li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
    			<li class="breadcrumb-item active">Missmatch List</li>
    		</ol>
    	</div>

    	<div class="page-content">
    		<!-- Panel Basic -->
    		<div class="panel">

    			<header class="panel-heading">
    				<div class="panel-actions"></div>
    				<h3 class="panel-title">Missmatch List</h3>
    			</header>
    			<div class="panel-body">
    				<!-- <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable"> -->
    				<table class="table table-hover dataTable table-striped" id="missmatch_list_table">
    					<thead>
    						<tr>
    							<th>Date</th>
    							<th>Logistic</th>
    							<th>Action</th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php foreach ($mismatch_history as $record) : ?>
    							<tr>
    								<td><?php echo $record['date']; ?></td>
    								<td><?php echo $record['logistic_name']; ?></td>
    								<td><button class="btn btn-primary  view_missmatch_detail" data-toggle="modal" data-target=".example-modal-xl" id="<?php echo $record['id'] ?>">View</button></td>
    							</tr>
    						<?php endforeach; ?>
    					</tbody>
    				</table>
    			</div>
    		</div>
    		<!-- End Panel Basic -->



    	</div>

    	<!-- Extra large modal -->
    </div>


    <!-- End Page -->
