<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login | ShipSecure</title>
	<!-- <meta name="robots" content="noindex,nofollow"> -->
	<!-- Google Tag Manager -->
	<!-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WDN65K8');</script> -->
	<!-- End Google Tag Manager -->
	<link rel="icon" type="image/png" sizes="96x96" href="assets/front-end/images/favicon.png">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="assets/front-end/images/favicon.png">
	<meta name="theme-color" content="#ffffff">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-site-verification" content="XJx-VSCFyv1RzK4JwX6oHRnZ0Yuw3m3jAc_ab9ZfVtk" />
	<meta name="msvalidate.01" content="8497F941C87C0F1C459E65A60FB40863" />
	<meta name="title" content="India's fastest e-commerce logistics solution  | ShipSecure">
	<meta name="description" content="Fastest e-commerce shipping solution in India. COD available for 26000+ pin codes. Choose from multiple courier partners like FedEx, Delhivery, Xpressbees, etc. with No shipping limits. Try us, it's free.">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front-end/css/styles.css">
	<link href="<?php echo base_url(); ?>assets/front-end/css/font-awesome.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front-end/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/front-end/css/style.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front-end/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front-end/css/bootstrap1.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front-end/css/jquery.notifyBar.css">
	<link href="<?php echo base_url(); ?>assets/front-end/css/core1.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/front-end/css/component1.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/front-end/css/style1.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url(); ?>assets/front-end/css/colors1.css" rel="stylesheet" type="text/css">
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
</head>

<body class="login-container  pace-done">

	<div id="result_message" style="display: none;"></div>
	<div id="result_error_message" style="display: none;"></div>
	<?php if ($this->session->flashdata('message')) { ?>
		<div id="result" style="display: none;"></div>
	<?php } else if ($this->session->flashdata('error')) { ?>
		<div id="result_error" style="display: none;"></div>
	<?php } else {
	} ?>
	<div class="page-container">
		<div class="page-content">
			<div class="content-wrapper">
				<div class="content">
					<div class="row col-md-offset-1 col-md-10">
						<div class="col-md-6 col-lg-6 no-padding hidden-xs hidden-sm" style="text-align:right">
							<img src="<?php echo base_url(); ?>assets/front-end/images/login.jpg" style="width:500px;height:500px">
						</div>
						<div class="col-md-6 col-lg-6 col-sm-12  col-xs-12 no-padding " style="text-align: left;">
							<div class="panel panel-body" style="margin-bottom: 0px;border: none; border-radius: 0px;width:500px;height:500px">
								<div class="text-center">
									<!--<img src="//manage.shipsecure.com/assets/front-end/images/login-logo.png" style="width:150px;margin-top: 30px;margin-bottom: 50px">-->
									<a href="<?php echo base_url(); ?>" target="_blank">
										<img src="<?php echo base_url(); ?>assets/front-end/images/logo.png" style="height:50px; margin-bottom: 10px">
									</a>
								</div>
								<!-- <?php if ($error != '') { ?> <div class="text-center" style="border: 1px solid red;margin: 0px 8%;"><?php echo $error; ?></div>  <?php } ?>
                                    <?php if ($success != '') { ?> <div class="text-center" style="border: 1px solid green;margin: 0px 8%;"><?php echo $success; ?></div>  <?php } ?> -->
								<div class="text-center" style="margin: 0px 8%;">
									<form method="POST" action="<?= base_url('login/user'); ?>" id="login_form" data-parsley-validate>
										<h5 class="text-center content-group" style="">Login to your SSL account </h5>
										<div class="form-group has-feedback has-feedback-left">
											<input type="email" class="form-control" placeholder="Enter Email" name="user_email" id="email" data-parsley-required="true">
											<div class="form-control-feedback">
												<i class="fa fa-user text-muted"></i>
											</div>
										</div>
										<style type="text/css">
											.has-feedback-right .form-control-feedback1 {
												right: 0px;
												left: auto;
											}

											.form-control-feedback1 {
												width: 16px;
												color: #333333;
												z-index: 3;
											}

											.form-control-feedback1 {
												position: absolute;
												top: 0;
												right: 0;
												z-index: 2;
												display: block;
												width: 38px;
												height: 38px;
												line-height: 38px;
												cursor: pointer;
											}
										</style>
										<div class="form-group has-feedback has-feedback-left has-feedback-right">
											<input type="password" class="form-control" placeholder="Enter Password" name="user_password" id="password" data-parsley-required="true">

											<div class="form-control-feedback">
												<i class="fa fa-lock text-muted"></i>
											</div>
											<div class="form-control-feedback1">
												<i class="fa fa-eye" id="togglePassword"></i>
											</div>
										</div>
										<div class="form-group">
											<button style="background-color:#000000!important;color:#fff; " type="submit" class="bg-teal btn-block legitRipple" name="button">LOGIN <i class="fa fa-circle-right2 position-right"></i></button>
										</div>
										<div class="text-center"> New Customer?
											<a href="<?php echo base_url('register'); ?>">Signup Here</a>
										</div>
									</form>
								</div>
								<div class="text-center" style="padding-top: 20px;">
									<small class="text-muted"> Copyright &copy; <?php echo date("Y"); ?> ShipSecure. All Rights Reserved.<br> <span style="color: white">Powered by <a href="https://quickbookintegration.com/" target="_blank" style="color: white !important">Quickbook Integration</a></span></small>
								</div>
							</div>
						</div>
					</div>
					<!-- Footer -->
					<!-- <div class="_hj-f5b2a1eb-9b07_hotjar_buddy _hj-f5b2a1eb-9b07_icon _hj-f5b2a1eb-9b07_icon_emotion_default _hj-f5b2a1eb-9b07_bottom_position_launcher" data-emotion-score="3">
                          <span class="path1"></span><span class="path2"></span>
                        </div> -->
					<div class="footer text-muted">
						<span style="float: left;">
							&copy; 2019. <a href="#">ShipSecure</a>
						</span>
						<span style="float: right;">
							&nbsp;&nbsp; Powered by <a href="https://quickbookintegration.com/" target="_blank">Quickbook Integration.</a>
						</span>
					</div>
					<!-- /footer -->
					<script async src="https://www.googletagmanager.com/gtag/js?id=UA-100370319-4"></script>
					<script>
						window.dataLayer = window.dataLayer || [];

						function gtag() {
							dataLayer.push(arguments);
						}
						gtag('js', new Date());
						gtag('config', 'UA-100370319-4');
					</script>
					<!-- <script src='https://code.responsivevoice.org/responsivevoice.js'></script> -->
					<!--
                        <script type="text/javascript" src="//manage.shipsecure.com/assets/front-end/js/chat-bot/jquery.ui.touch-punch.js"></script>
                        <script type="text/javascript" src="//manage.shipsecure.com/assets/front-end/js/chat-bot/VPJpaW.js"></script>
                        <script>
                          $(document).ready(function ()
                          {
                            $(window).load(first_msg(''));
                          });
                        </script>
                        -->
				</div>
			</div>
		</div>
	</div>

	<script src='<?php echo base_url(); ?>assets/front-end/js/jquery.min.js'></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/front-end/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/front-end/js/jquery.validate.min.js" defer></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/front-end/js/parsley.min.js" defer></script>
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
		const togglePassword = document.querySelector('#togglePassword');
		const password = document.querySelector('#password');
		togglePassword.addEventListener('click', function(e) {
			// toggle the type attribute
			const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
			password.setAttribute('type', type);
			// toggle the eye slash icon
			this.classList.toggle('fa-eye-slash');
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
