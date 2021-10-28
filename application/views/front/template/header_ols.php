<div id="result_message" style="display: none;"></div>
<div id="result_error_message" style="display: none;"></div>
<?php if ($this->session->flashdata('message')) { ?>
	<div id="result" style="display: none;"></div>
<?php } else if ($this->session->flashdata('error')) { ?>
	<div id="result_error" style="display: none;"></div>
<?php } else {
} ?>
<div class="body_wrapper">
	<!-- header start -->
	<header class="header_area">
		<nav class="navbar navbar-expand-lg menu_one">
			<div class="container custom_container p0">
				<a class="navbar-brand" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>assets/front-end/img/logo.png" srcset="img/logo2x.png 2x" alt="logo"></a>
				<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="menu_toggle">
						<span class="hamburger">
							<span></span>
							<span></span>
							<span></span>
						</span>
						<span class="hamburger-cross">
							<span></span>
							<span></span>
						</span>
					</span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto menu">
						<li class="nav-item dropdown submenu mega_menu mega_menu_two">
							<a class="nav-link dropdown-toggle" href="<?= base_url(); ?>" aria-haspopup="true" aria-expanded="false">
								Home
							</a>
						</li>
						<li class="nav-item dropdown submenu mega_menu">
							<a class="nav-link dropdown-toggle" href="<?= base_url('about-us'); ?>" aria-haspopup="true" aria-expanded="false">
								About Us
							</a>
						</li>
						<li class="nav-item dropdown submenu mega_menu">
							<a class="nav-link dropdown-toggle" href="#" aria-haspopup="true" aria-expanded="false">
								Contact Us<?php  //base_url('contact-us'); 
											?>
							</a>
						</li> -->
					</ul>
					<?php if (@$this->session->userdata('userId') != '') { ?>
						<a class="btn_get btn_hover" href="<?= base_url('front-logout'); ?>">Logout</a>
					<?php } else { ?>
						<a class="btn_get btn_hover" href="<?= base_url('login'); ?>">Login</a>

					<?php } ?>
					<a class="btn_hover agency_banner_btn pay_btn pay_btn_two cus_mb-10" href="https://cms.packanddrop.com">Old Login</a>
				</div>
			</div>
		</nav>
	</header>
	<!-- header ends -->

	<div class="body_wrapper">
