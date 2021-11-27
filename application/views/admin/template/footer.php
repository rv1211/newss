<?php $currentUrl = urlseg(1); ?>


<!-- Footer -->
<!-- <footer class="site-footer"> -->
<!-- <div class="site-footer-legal">© <?= date('Y'); ?></div>
      <div class="site-footer-right"></div> -->
<!-- </footer> -->
<!-- Core  -->

<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?= base_url(); ?>assets/custom/daterangepicker/js/moment.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?= base_url(); ?>assets/custom/daterangepicker/js/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/custom/daterangepicker/css/daterangepicker.css" />


<!-- end validation -->
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/switchery/switchery.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/babel-external-helpers/babel-external-helpers.js">
</script>

<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/popper-js/umd/popper.min.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/bootstrap/bootstrap.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/animsition/animsition.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/asscrollable/jquery-asScrollable.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/waves/waves.js"></script>




<!-- Plugins -->

<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/intro-js/intro.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/screenfull/screenfull.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/jvectormap/jquery-jvectormap.min.js"></script>
<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/jvectormap/maps/jquery-jvectormap-world-mill-en.js">
</script>
<?php if ($currentUrl == 'dashboard-new') { ?>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/chartist/chartist.min.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.js">
		<?php  } ?>
	</script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/matchheight/jquery.matchHeight-min.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/peity/jquery.peity.min.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/layout-grid/layout-grid.js"></script>

	<!-- Scripts -->
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Component.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Plugin.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Base.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Config.js"></script>

	<script src="<?= base_url(); ?>assets/admin-asset/js/Section/Menubar.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/js/Section/Sidebar.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/js/Section/PageAside.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/js/Plugin/menu.js"></script>

	<!-- Config -->
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/config/colors.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/js/config/tour.js"></script>
	<script>
		Config.set('assets', '<?= base_url(); ?>assets/admin-asset');
	</script>

	<!-- Data table  -->
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net/jquery.dataTables.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-bs4/dataTables.bootstrap4.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-fixedheader/dataTables.fixedHeader.js">
	</script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-fixedcolumns/dataTables.fixedColumns.js">
	</script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-rowgroup/dataTables.rowGroup.js">
	</script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-scroller/dataTables.scroller.js">
	</script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-responsive/dataTables.responsive.js">
	</script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-responsive-bs4/responsive.bootstrap4.js">
	</script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-buttons/dataTables.buttons.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-buttons/buttons.html5.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-buttons/buttons.flash.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-buttons/buttons.print.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-buttons/buttons.colVis.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-buttons-bs4/buttons.bootstrap4.js">
	</script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Plugin/datatables.js"></script>

	<!-- Page -->
	<script src="<?= base_url(); ?>assets/admin-asset/js/Site.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Plugin/asscrollable.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Plugin/slidepanel.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Plugin/switchery.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Plugin/matchheight.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Plugin/jvectormap.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Plugin/peity.js"></script>

	<script src="<?= base_url(); ?>assets/admin-asset/examples/js/dashboard/v1.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Plugin/select2.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Plugin/bootstrap-select.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/select2/select2.full.min.js"></script>
	<!-- <script src="<?= base_url(); ?>assets/admin-asset/examples/js/forms/validation.js"></script> -->


	<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js" integrity="sha512-hJsxoiLoVRkwHNvA5alz/GVA+eWtVxdQ48iy4sFRQLpDrBPn6BFZeUcW4R4kU+Rj2ljM9wHwekwVtsb0RY/46Q==" crossorigin="anonymous"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/js/Plugin.js"></script>


	<!-- Form Validation -->
	<script src="<?php echo base_url(); ?>assets/admin-asset/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/admin-asset/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
	<!-- Form Validation -->
	<!-- custom -->
	<!-- <script type="text/javascript" src="<?= base_url(); ?>assets/custom/js/admin-custom.js"></script> -->
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/js/admin-custom.js?v=1.6"></script>

	<script src="<?= base_url('assets/custom/js/customercredit.js?v=1.5') ?>"></script>
	<script src="<?= base_url(); ?>assets/custom/js/all_ssp_datatable_ajax.js?v=1.15"></script>
	<?php if ($currentUrl == 'dashboard-new') { ?>
		<script type="text/javascript" src="<?= base_url(); ?>assets/custom/js/admin_dashboard.js?v=1.8"></script>
	<?php  } ?>

	<!-- custom -->

	<script src="<?= base_url(); ?>assets/sortable/Sortable.js"></script>
	<script src="<?= base_url(); ?>assets/nestable/jquery.nestable.js"></script>
	<script src="<?php echo base_url('assets/admin-asset/global/vendor/chart-js/Chart.js') ?>"></script>
	<!-- common validation form admin -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/admin-form-validation.js?v=1.8"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/kyc_validation.js?v=1.8"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/order-admin.js?v=2.8"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/metrocity-validation.js?v=1.5"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/import_pincode.js?v=1.6"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/reports.js"></script>

	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/logistic-validation.js?v=1.5"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/rule-validation.js?v=1.6"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/assing_awb.js?v=1.7"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/order-list.js?v=1.11"></script>
	<?php if ($currentUrl == 'next-cod-remittance-list' || $currentUrl == 'next-cod-remittance-all-data') { ?>
		<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/next_cod_remmitance.js?v=1"></script>
	<?php  } ?>
	<?php if ($currentUrl == 'dashboard-new') { ?>
		<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/graph.js?v=1.1"></script>
	<?php  } ?>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/timepicker/jquery.timepicker.min.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datepair/datepair.min.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/datepair/jquery.datepair.min.js"></script>
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/bootstrap-datepicker/bootstrap-datepicker.js"></script>


	<!-- js bulk order -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/bulk_order.js?v=1.4"></script>

	<!-- manage Price -->
	<script src="<?php echo base_url('assets/custom/js/manage_price.js?v=1.54') ?>"></script>
	<!-- end manage price -->

	<!-- START Socket Code Start By Harshil  -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/js/codremittance_ajax.js?v=1.6"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/js/zship_awb.js?v=1.4"></script>
	<input disabled type="hidden" id="user_sock_type" value="<?php echo $this->session->userdata('userType'); ?>">
	<input disabled type="hidden" id="user_sock_id" value="<?php echo $this->session->userdata('userId'); ?>">
	<input disabled type="hidden" id="socket_url" value="<?php echo $this->config->item('socket_url'); ?>">
	<!-- <script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/socket.js"></script> -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/pickup_add.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/cus_api_setting.js?v=1"></script>
	<script src="<?php echo base_url(); ?>assets/custom/admin-js/delete_order.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/custom/admin-js/delete_pre_order.js" type="text/javascript"></script>

	<!-- END Socket Code Start By Harshil  -->
	<!-- pincode seviceability start -->
	<script type="text/javascript" src="<?= base_url(); ?>assets/custom/admin-js/pincode_serviceability.js?v=2"></script>
	<!-- pincode seviceability end -->
	<?php if ($this->session->flashdata('message')) { ?>
		<script type="text/javascript">
			$("#result").fadeIn("slow").append("<?php echo $this->session->flashdata('message'); ?>");
			setTimeout(function() {
				$("#result").fadeOut("slow");
			}, 4000);
		</script>
	<?php }
	if ($this->session->flashdata('error')) { ?>
		<script type="text/javascript">
			$("#result_error").fadeIn("slow").append("<?php echo $this->session->flashdata('error'); ?>");
			setTimeout(function() {
				$("#result_error").fadeOut("slow");
			}, 7000);
		</script>
	<?php } ?>
	<script>
		(function(document, window, $) {
			'use strict';
			var Site = window.Site;
			$(document).ready(function() {
				Site.run();
			});
		})(document, window, jQuery);
	</script>




	</body>

	</html>