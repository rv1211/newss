<!DOCTYPE html>
<html lang="en">

<head>
	<title> ShipSecure </title>
	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-WDN65K8');
	</script>
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url() ?>assets/front-end/images/favicon.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="assets/front-end/images/favicon.png">
	<meta name="theme-color" content="#ffffff">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-site-verification" content="XJx-VSCFyv1RzK4JwX6oHRnZ0Yuw3m3jAc_ab9ZfVtk" />
	<meta name="msvalidate.01" content="8497F941C87C0F1C459E65A60FB40863" />
	<meta name="title" content="India's fastest e-commerce logistics solution  | ShipSecure">
	<meta name="description" content="Fastest e-commerce shipping solution in India. COD available for 26000+ pin codes. Choose from multiple courier partners like FedEx, Delhivery, Xpressbees, etc. with No shipping limits. Try us, it's free.">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front-end/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/front-end/css/style.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front-end/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front-end/css/jquery.notifyBar.css">
	<link href="<?php echo base_url(); ?>assets/front-end/css/parsley.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/front-end/css/style2.css" rel="stylesheet">
	<script src='<?php echo base_url(); ?>assets/front-end/js/jquery.min.js'></script>
	<style type="text/css">
		.se-pre-con {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url(<?php echo base_url(); ?>assets/front-end/images/xXYX1tf.gif) center no-repeat #010101b3;
		}

		.pre-loader {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url(<?php echo base_url(); ?>assets/front-end/images/logo.jpg) center no-repeat #fff;
		}

		#result {
			position: absolute;
			top: 88px;
			width: 30%;
			right: 0px;
			height: auto;
			z-index: 105;
			text-align: center;
			font-weight: normal;
			padding-top: 20px;
			padding-bottom: 20px;
			font-size: 14px;
			font-weight: bold;
			color: white;
			background-color: #7fd07ff2;
		}

		#result_message {
			position: fixed;
			top: 88px;
			width: 30%;
			right: 0px;
			height: auto;
			z-index: 105;
			text-align: center;
			font-weight: normal;
			padding-top: 20px;
			padding-bottom: 20px;
			font-size: 14px;
			font-weight: bold;
			color: white;
			background-color: #7fd07ff2;
		}

		#result_error {
			position: absolute;
			top: 88px;
			width: 30%;
			right: 0px;
			height: auto;
			z-index: 105;
			text-align: center;
			font-weight: normal;
			padding-top: 20px;
			padding-bottom: 20px;
			font-size: 14px;
			font-weight: bold;
			color: white;
			background-color: #d9534f;
		}

		#result_error_message {
			position: fixed;
			top: 88px;
			width: 30%;
			right: 0px;
			height: auto;
			z-index: 105;
			text-align: center;
			font-weight: normal;
			padding-top: 20px;
			padding-bottom: 20px;
			font-size: 14px;
			font-weight: bold;
			color: white;
			background-color: #d9534f;
		}
	</style>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-176145737-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-176145737-1');
	</script>
</head>

<body>
	<div class="se-pre-con" style="display: none;"></div>
	<div class="main-container">
		<header class="main-header menu-dark mobile-header-light mobile-menu-dark" style="padding-top: 10px; padding-bottom: 7px; background: #fff;">
			<div class="header-container container" style="padding-left: 0; padding-right: 0;">
				<div class="brand-block">
					<a class="logo-block col-xs-6 col-md-6 p-0" href="<?php echo base_url(); ?>">
						<img class="logo-light" src="<?php echo base_url(); ?>assets/front-end/images/logo.png" alt="ShipSecure" style="/*width:100px;*/ height: 48px; ">
						<img class="logo-dark" src="<?php echo base_url(); ?>assets/front-end/images/logo.png" alt="ShipSecure" style="/*width:100px;*/ height: 48px; ">
					</a>
					<li id='client-login-mob'><a href="<?php echo base_url('login'); ?>" class="btn btn-white btn-sm btn-shadow btn-rounded-circle">Login</a></li>
					<button type="button" class="nav-toggle">
						<span></span>
						<span></span>
						<span></span>
					</button>
				</div>
				<div class="nav-block-custom">
					<nav class="main-nav">
						<ul>
							<li class="dropdown"><a href="<?php echo base_url() ?>">Home</a></li>
							<li><a href="<?php echo base_url('about'); ?>">About</a></li>
							<li><a href="<?php echo base_url('contact'); ?>">Contact</a></li>
							<!-- <li><a href="blog.html" target="_blank">Blog</a></li> -->
							<li><a href="<?php echo base_url('track-order'); ?>">Track Order</a></li>
							<!-- <li><a href="<?php //echo base_url('get-quote'); 
													?>" >Get Quote</a></li> -->
							<?php if (isset($_SESSION['name'])) { ?>
								<li id='client-login-desk'><a href="<?php echo base_url('logout'); ?>" class="btn btn-white btn-sm btn-shadow btn-rounded-circle"> Logout</a></li>
							<?php } else { ?>
								<li><a href="<?php echo base_url('register'); ?>" class="btn btn-sm btn-shadow btn-rounded-circle btn-grad">Signup</a></li>
								<li id='client-login-desk'><a href="<?php echo base_url('login'); ?>" class="btn btn-white btn-sm btn-shadow btn-rounded-circle"> Login</a></li>
							<?php } ?>
						</ul>
					</nav>
				</div>
			</div>
		</header>
		<a href="#" class="function-btn backtotop scrollto"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
		<input type="hidden" name="hiddenurl" id="hiddenUrl" value="<?php echo base_url(); ?>">


		<div id="result_message" style="display: none;"></div>
		<div id="result_error_message" style="display: none;"></div>
		<?php if ($this->session->flashdata('message')) { ?>
			<div id="result" style="display: none;"></div>
		<?php } else if ($this->session->flashdata('error')) { ?>
			<div id="result_error" style="display: none;"></div>
		<?php } else {
		} ?>
