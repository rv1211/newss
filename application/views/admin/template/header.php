<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="bootstrap material admin template">
	<meta name="author" content="">

	<title><?= $this->config->item('app_name'); ?></title>


	<link rel="apple-touch-icon" href="<?= base_url(); ?>assets/admin-asset/images/apple-touch-icon.png">
	<!-- <link rel="shortcut icon" href="<?= base_url(); ?>assets/admin-asset/images/favicon.ico"> -->
	<link rel="shortcut icon" href="<?= base_url(); ?>assets/front-end/img/favicon.png" type="image/x-icon">
	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/css/bootstrap-extend.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/css/site.min.css">

	<link rel="stylesheet" href="<?= base_url() ?>assets/admin-asset/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/admin-asset/global/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/admin-asset/global/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/admin-asset/global/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/admin-asset/global/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/admin-asset/global/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/admin-asset/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/admin-asset/global/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/admin-asset/examples/css/tables/datatable.css">

	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/animsition/animsition.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/asscrollable/asScrollable.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/switchery/switchery.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/intro-js/introjs.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/slidepanel/slidePanel.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/flag-icon-css/flag-icon.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/waves/waves.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/chartist/chartist.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/jvectormap/jquery-jvectormap.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/layout-grid/layout-grid.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/examples/css/dashboard/v1.css">

	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin-asset/global/vendor/dropify/dropify.css'); ?>">
	<!-- END CSS FOR FILE UPLOAD -->

	<!-- Datatable -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/examples/css/tables/datatable.css">
	<!-- datatable -->
	<!--dragable list  -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/nestable/nestable.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/sortable/sortable.css">
	<!-- dragble list end -->


	<!-- Fonts -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/fonts/font-awesome/font-awesome.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/fonts/material-design/material-design.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/fonts/brand-icons/brand-icons.min.css">
	<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
	<link rel='stylesheet' href='<?= base_url(); ?>assets/admin-asset/examples/css/charts/chartjs.css'>


	<!-- SELECT2 -->
	<link rel="stylesheet" href="<?= base_url(); ?>assets/admin-asset/global/vendor/select2/select2.css">
	<!-- Custom -->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/custom/css/custom-admin.css?v=1.3">

	<link rel="stylesheet" href="<?= base_url('assets/custom/css/dashboard.css?v=1.5') ?>">
	<!-- pincode seviceability Start -->

	<link rel="stylesheet" href="<?= base_url('assets/custom/css/pincode_serviceability.css?v=2') ?>">
	<!-- pincode seviceability end -->

	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/jquery/jquery.js"></script>
	<!-- Scripts -->
	<script src="<?= base_url(); ?>assets/admin-asset/global/vendor/breakpoints/breakpoints.js"></script>
	<script>
		Breakpoints();
	</script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</head>
<?php
$currentUrl = $_SERVER['REQUEST_URI'];
$page = basename($currentUrl);
?>

<body class=" dashboard <?= $page == 'approve-pending' || $page == 'kyc-verification' || $page == 'profile' ? 'site-menubar-hide' : ''; ?>">



	<input type="hidden" name="baseurl" id="hiddenURL" value="<?= base_url(); ?>">
	<!-- <div class="example-loading example-well h-150 vertical-align text-center loader-style" id="loader" style="display: none;">
		<div class="loader vertical-align-middle loader-tadpole">
		</div>
	</div> -->
	<div class="se-pre-con" style="display: block;"></div>
	<div id="result_message" style="display: none;"></div>
	<div id="result_error_message" style="display: none;"></div>
	<?php if ($this->session->flashdata('message')) { ?>
		<div id="result" style="display: none;"></div>
	<?php } else if ($this->session->flashdata('error')) { ?>
		<div id="result_error" style="display: none;"></div>
	<?php } else {
	} ?>

	<script>
		$(window).on('load', function() {
			$(".se-pre-con").fadeOut("slow");
			// 
			$(".se-pre-con").removeAttr("style");
		});
	</script>
	<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

	<nav class="site-navbar navbar navbar-default navbar-inverse navbar-fixed-top navbar-mega" role="navigation">

		<div class="navbar-header">
			<button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided" data-toggle="menubar">
				<span class="sr-only">Toggle navigation</span>
				<span class="hamburger-bar"></span>
			</button>
			<button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse" data-toggle="collapse">
				<i class="icon md-more" aria-hidden="true"></i>
			</button>
			<div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
				<img class="navbar-brand-logo" src="<?= base_url(); ?>uploads/logo.png" title="Remark">
			</div>
			<button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search" data-toggle="collapse">
				<span class="sr-only">Toggle Search</span>
				<i class="icon md-search" aria-hidden="true"></i>
			</button>
		</div>
		<div class="navbar-container container-fluid">
			<!-- Navbar Collapse -->
			<div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
				<!-- Navbar Toolbar -->
				<ul class="nav navbar-toolbar">
					<?php if ($page != 'approve-pending' && $page != 'kyc-verification') { ?>
						<li class="nav-item hidden-float" id="toggleMenubar">
							<a class="nav-link" data-toggle="menubar" href="#" role="button">
								<i class="icon hamburger hamburger-arrow-left">
									<span class="sr-only">Toggle menubar</span>
									<span class="hamburger-bar"></span>
								</i>
							</a>
						</li>
					<?php } ?>
				</ul>
				<ul class="nav navbar-toolbar" style="margin-left: 35%;">
					<li class="nav-item" style="color: #cb9d49;font-weight:bold;font-size: 16px;margin-top: 21px;text-align: center;">
						<?= $this->session->userdata('userName') . ' ( ' . $this->session->userdata('userEmail') . ' )'; ?>
					</li>
				</ul>
				<!-- End Navbar Toolbar -->

				<!-- Navbar Toolbar Right -->
				<ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
					<li>
						<p style="color: black;font-weight: bold;font-size: 16px;margin-top: 18px;">
							<i class="fa fa-suitcase"></i>
							<?php $table_name = ($this->session->userdata('userType') == 4) ? 'sender_master' : 'user_master'; ?>
							<span id="header_wallet_credit_balance"><?php echo $this->db->select('wallet_balance')->from($table_name)->where('id', $this->session->userdata('userId'))->get()->row()->wallet_balance; ?></span>
						</p>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false" data-animation="scale-up" role="button">
							<span class="avatar avatar-online">
								<img src="<?= base_url(); ?>assets/admin-asset/global/portraits/5.jpg" alt="...">
								<i></i>
							</span>
						</a>
						<div class="dropdown-menu" role="menu">
							<?php $data = $this->db->select('um.name,um.user_mobile_no')->from('kyc_verification_master as kym')->join('user_master as um', 'kym.created_by = um.id')->where("kym.sender_id", $this->session->userdata('userId'))->get()->row(); ?>

							<a class="dropdown-item" href="#" role="menuitem">
								Manage By : <?php echo @$data->name;  ?></a>

							<a class="dropdown-item" href="#" role="menuitem">
								+91 <?php echo @$data->user_mobile_no;  ?></a>

							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?= base_url('profile'); ?>" role="menuitem"><i class="icon md-account" aria-hidden="true"></i> Profile</a>
							<div class="dropdown-divider"></div>
							<?php if ($this->session->userdata('userAllow') == '') { ?>
								<a class="dropdown-item" href="<?= base_url('wallet-transaction'); ?>" role="menuitem"><i class="icon md-mail-reply" aria-hidden="true"></i> My Wallet</a>
								<div class="dropdown-divider"></div>
							<?php } ?>
							<a class="dropdown-item" href="<?= base_url('logout'); ?>" role="menuitem"><i class="icon md-power" aria-hidden="true"></i> Logout</a>

						</div>
					</li>


				</ul>
				<!-- End Navbar Toolbar Right -->
			</div>
			<!-- End Navbar Collapse -->

			<!-- Site Navbar Seach -->
			<div class="collapse navbar-search-overlap" id="site-navbar-search">
				<form role="search">
					<div class="form-group">
						<div class="input-search">
							<i class="input-search-icon md-search" aria-hidden="true"></i>
							<input type="text" class="form-control" name="site-search" placeholder="Search...">
							<button type="button" class="input-search-close icon md-close" data-target="#site-navbar-search" data-toggle="collapse" aria-label="Close"></button>
						</div>
					</div>
				</form>
			</div>
			<!-- End Site Navbar Seach -->
		</div>
	</nav>
