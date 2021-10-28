    <div class="footer text-muted">
    	<span style="float: left;">
    		Copyright &copy; <?php echo date("Y"); ?> ShipSecure
    	</span>
    	<span style="float: right; color: white">
    		&nbsp;&nbsp;Powered by <a href="https://quickbookintegration.com/" target="_blank" style="color: white !important">Quickbook Integration</a>
    	</span>
    </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pace.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.notifyBar.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/interactions.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/form_select2.js"></script>
    <!-- <script src="<?php echo base_url() ?>assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/custome.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->

    <!-- <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datatable/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datatable/buttons.flash.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datatable/jszip.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datatable/buttons.html5.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/admin-asset/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/admin_custom_code.js?v=17.23"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/form_validation.js?v=9"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/import-order.js?v=1.2"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js" integrity="sha512-hJsxoiLoVRkwHNvA5alz/GVA+eWtVxdQ48iy4sFRQLpDrBPn6BFZeUcW4R4kU+Rj2ljM9wHwekwVtsb0RY/46Q==" crossorigin="anonymous"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/js/admin-custom.js?v=1.6"></script>

    <script src="<?= base_url('assets/custom/js/customercredit.js?v=1.5') ?>"></script>
    <script src="<?= base_url(); ?>assets/custom/js/all_ssp_datatable_ajax.js?v=1.15"></script>
    <?php if ($currentUrl == 'dashboard-new') { ?>
    	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/js/admin_dashboard.js?v=1.8"></script>
    <?php  } ?>

    <script src="<?= base_url(); ?>assets/sortable/Sortable.js"></script>
    <script src="<?= base_url(); ?>assets/nestable/jquery.nestable.js"></script>
    <script src="<?php echo base_url('assets/admin-asset/global/vendor/chart-js/Chart.js') ?>"></script>

    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/logistic-validation.js?v=1.5"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/rule-validation.js?v=1.6"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/assing_awb.js?v=1.7"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/order-list.js?v=1.11"></script>


    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/admin-form-validation.js?v=1.8"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/kyc_validation.js?v=1.8"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/order-admin.js?v=1.8"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/metrocity-validation.js?v=1.5"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/import_pincode.js?v=1.6"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/reports.js"></script>


    <script src="<?php echo base_url(); ?>assets/admin-asset/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>




    <?php if ($currentUrl == 'next-cod-remittance-list' || $currentUrl == 'next-cod-remittance-all-data') { ?>
    	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/next_cod_remmitance.js?v=1"></script>
    <?php  } ?>


    <?php if ($currentUrl == 'dashboard-new') { ?>
    	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/graph.js?v=1.1"></script>
    <?php  } ?>

    <script src="<?= base_url(); ?>assets/admin-asset/global/vendor/timepicker/jquery.timepicker.min.js"></script>
    <script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datepair/datepair.min.js"></script>

    <!-- js bulk order -->
    <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/bulk_order.js?v=1.4"></script>
    <!-- JS BULK ORDER END -->


    <!-- manage Price -->
    <script src="<?php echo base_url('assets/custom/js/manage_price.js?v=1.54') ?>"></script>
    <!-- end manage price -->

    <script src="<?php echo base_url(); ?>assets/custom/admin-js/delete_pre_order.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/custom/admin-js/delete_order.js" type="text/javascript"></script>
    <?php
	$currentUrl = $_SERVER['REQUEST_URI'];
	/*if(strpos($currentUrl, 'view-order-new') == true){ ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/order_listing1.js?v=1.6"></script>
 */ ?>
    <script src="<?= base_url(); ?>assets/admin-asset/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>


    <?php if ($this->session->flashdata('message')) { ?>
    	<script type="text/javascript">
    		$("#result").fadeIn("slow").append("<?php echo $this->session->flashdata('message'); ?>");
    		setTimeout(function() {
    			$("#result").fadeOut("slow");
    		}, 4000);
    	</script>
    <?php } else { ?>
    	<script type="text/javascript">
    		$("#result_error").fadeIn("slow").append("<?php echo $this->session->flashdata('error'); ?>");
    		setTimeout(function() {
    			$("#result_error").fadeOut("slow");
    		}, 7000);
    	</script>
    <?php } ?>
    <script type="text/javascript">
    	$(function() {
    		$(document).ready(function() {
    			$('.example').DataTable({
    				"ordering": false
    			});
    		});
    	});
    	$(document).ready(function() {
    		$('.example1').DataTable({
    			dom: 'Bfrtip',
    			buttons: [
    				'excel'
    			]
    		});

    		/**
    		 * Change by dhara
    		 * Customer List
    		 */
    		$('.example_customer').DataTable({
    			"ordering": false,
    			dom: 'Bfrtip',
    			buttons: [{
    				extend: 'excel',
    				text: 'Excel',
    				className: 'btn btn-primary',
    				exportOptions: {
    					columns: [0, 1, 3, 4, 5, 6, 7]
    				},
    			}],
    			// "columnDefs": [
    			//   { "visible": false, "targets": [3,4,5,6] }
    			// ],
    			initComplete: function() {

    				this.api().columns().every(function() {
    					var column = this;
    					if (column.index() == 10) {
    						return;
    					}
    					if (column.index() == 0 || column.index() == 1 || column.index() == 2 || column.index() == 7 || column.index() == 6 || column.index() == 3 || column.index() == 4 || column.index() == 5 || column.index() == 8 || column.index() == 9) {
    						input = $('<input type="text" />').appendTo($(column.header())).on('keyup change', function() {
    							if (column.search() !== this.value) {
    								column.search(this.value)
    									.draw();
    							}
    						});
    						return;
    					}

    					var select = $('<select><option value=""></option></select>')
    						.appendTo($("#filters").find("th").eq(column.index()))
    						.on('change', function() {
    							var val = $.fn.dataTable.util.escapeRegex(
    								$(this).val());

    							column.search(val ? '^' + val + '$' : '', true, false)
    								.draw();
    						});

    					column.data().unique().sort().each(function(d, j) {
    						if (d != '')
    							select.append('<option value="' + d + '">' + d + '</option>')
    					});
    				});
    			}
    		});
    	});
    </script>
    <script type="text/javascript">
    	$(document).ready(function() {
    		$(document).bind("contextmenu", function(e) {
    			return false;
    		});

    		document.onkeydown = function(e) {
    			if (e.ctrlKey &&
    				(e.keyCode === 85 ||
    					e.keyCode === 123 ||
    					e.keyCode === 117)) {
    				return false;
    			} else if (e.keyCode == 123) {
    				return false;
    			} else if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
    				return false;
    			} else {
    				return true;
    			}
    		};

    		$('a').click(function(e) {
    			if (e.ctrlKey) {
    				return false;
    			}
    		});


    		$(':input').on('focus', function() {
    			$(this).attr('autocomplete', 'off');
    		});

    	});
    </script>

    </body>

    </html>
