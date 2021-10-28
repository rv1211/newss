<div id="page" class="ed-page">
	<div id="page-hero" class="ed-page-hero">
		<section class="pt-md-4 pb-md-6">
			<div class="overlay">
				<div class="hero-addon-b bg-light"></div>
				<div class="hero-addon-a addon-shadow bg-white"></div>
			</div>
			<div class="container text-center">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<h1 class="mb-2 translate-text mob-font-head"><span>Contact Us</span></h1>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div id="page-content" class="ed-page-content">
		<section class="pt-md-6 pb-md-6">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-3 col-md-offset-2 col-sm-offset-1">
						<ul class="nav nav-tabs custom-tabs">
							<li class='active'><a href="#existing_user" class="newclass" data-toggle="tab">Know about your shipments</a></li>
							<li><a href="#new_user" data-toggle="tab" class="newclass">New Customer?</a></li>
						</ul>
						<div class="tab-content custom-tab-content">
							<div class="tab-pane active" id="existing_user">
								<!-- <?php if ($error != '') {
											echo $error;
										}
										if ($success != '') {
											echo $success;
										} ?> -->
								<h4 style="padding-bottom: 15px;" class="text-center">Have an Enquiry related to your shipments?</h4>
								<form id="form_existing_user1" class="enquiryform" method="post" action="<?php echo base_url('Home/save_contact'); ?>">
									<input class="form-control custom-contact-input" id="name" type="text" required name="name" placeholder="Full name *">
									<input class="form-control custom-contact-input" id="email" type="text" required name="email" placeholder="Email address *">
									<input class="form-control custom-contact-input" id="contact_no" type="text" name="contact_no" placeholder="Mobile *" />
									<input type="text" name="tracking_number" placeholder="Enter Airwaybill Number *" required class="form-control custom-contact-input required" style="border: 1px solid #1874c1;" data-parsley-required="true"><br />
									<div id="imgdiv" style="display: flex;">
										<div id="captchaimage"><?php echo $captchaimage ?></div><!-- <img id="img" src="captcha.php"/> --><img id="reload" src="reload.png" style="float: right; margin-left: 10px;cursor: pointer;" />
									</div>
									<input type="text" name="captcha" placeholder="Enter Captcha code *" class="form-control custom-contact-input">
									<input type="hidden" name="captcha_word" id="captcha_word" value="<?php echo @$_SESSION['captcha_word']; ?>">
									<div id="response"></div><br />
									<div class="col-md-12 text-center">
										<button class="btn btn-primary btn-border footer-btn" type="submit" id="button" name="button">Submit</button>
									</div>
								</form>
							</div>

							<div class="tab-pane " id="new_user">

								<div class='col-lg-12 text-center'>

									<h4 style="padding-bottom: 15px;" class="text-center">Signup Now to use our services</h4>

									<a href="<?php echo base_url('register'); ?>" class="btn btn-grad btn-shadow">Signup</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
