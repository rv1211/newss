<div id="page" class="ed-page mobile-h2">
	<div class="banner">
		<div class="banner-item banner-item-style-1 custom-banner-section">
			<div class="row custom-row-0">
				<div id="page-hero" class="ed-page-hero">
					<section class="pt-md-4 pb-md-5 spec-section-1">
						<div class="overlay">
							<div class="hero-addon-b bg-light" style="transform: translateY(0px);"></div>
							<div class="hero-addon-a addon-shadow bg-white"></div>
						</div>
						<div class="container parallax-onscroll opacity-onscroll text-center" style="transform: translateY(0px); opacity: 1;">
							<h1 class="mb-2 translate-text translate-up mob-font-head is-animated" data-translate-delay="150"><span>Ecommerce Shipping Easier than ever.</span></h1>
						</div>
					</section>
				</div>
				<div class="col-xs-12 custom-banner-margin" style="background: linear-gradient(to right, #436E7B , #89D6D6);">
					<div class="banner-bg-1 container" style="margin-top: 0px;">
						<div class="contact-area custom-contact-area" style="padding-top: 5px;padding-bottom: 5px;">
							<div class="feature-item m-b-20 p-t-10 text-center">
								<?php if (@$error != '') {
									echo $error;
								} ?>
								<?php if (@$success != '') {
									echo $success;
								} ?>
								<div class="feature-body">
									<h4 class="section-title" style='font-size: 1.1rem; font-weight: 600;'>Signup below to get started.</h4>
								</div>
							</div>
							<form class="signupform" method="post" action="<?php echo base_url('sign-up'); ?>">
								<input autocomplete="off" class="form-control" id="name" type="text" required name="first_name" placeholder="Full name *" value="<?php echo @$_POST['name']; ?>" maxlength="50">
								<input autocomplete="off" class="form-control" id="contact_no" type="text" required name="user_phone" placeholder="Mobile *" data-parsley-type="digits" data-parsley-minlength="8" data-parsley-maxlength="10" minlength="8" maxlength="10" value="<?php echo @$_POST['phone']; ?>" />
								<input autocomplete="off" class="form-control" type="email" required name="user_email" placeholder="Email address *" maxlength="50" value="<?php echo @$_POST['email']; ?>">
								<input autocomplete="off" class="form-control" id="password" type="password" required name="user_password" placeholder="Password *" value="<?php echo @$_POST['password']; ?>">
								<input autocomplete="off" class="form-control" id="retype_password" type="password" required name="user_confirm_password" placeholder="Retype Password *" value="<?php echo @$_POST['retype_password']; ?>">
								<input autocomplete="off" class="form-control" id="website" type="text" name="website" placeholder="user_website" style="margin-bottom: 4px;" value="<?php echo @$_POST['website']; ?>" maxlength="50">
								<div>
									<br><input id="group1" class="form-check-input" style="margin-left:10px;vertical-align: text-top" id="agree_tnc" type="checkbox" checked required name="user_agreement">
									<label for="group1"><small class=""> Agree to <a href="<?php echo base_url('terms-conditions'); ?>" target="_blank">Terms Of Service</a> and <a href="<?php echo base_url('privacy-policy'); ?>" target="_blank">Privacy Policy</a></small></label>
									<br>
									<?php if (isset($errors['user_agreement'])) { ?>
										<span class="error" style="error"><?= @$errors['user_agreement']; ?></span>
									<?php } ?>
									<span id="agree_tnc-error" class="error"></span>
								</div>
								<button class="btn btn-grad custom-submit-button" id="signupbtn" type="submit" name="button" style="margin-top: 10px;">Signup Now</button>
								<div class="clearfix"></div>
								<div id="error_message" style="color:red">
									<ul>
										<?php if (isset($errors['first_name'])) { ?>
											<li><label class="error"><?= @$errors['first_name'] ?></label></li>
										<?php } ?>
										<?php if (isset($errors['user_phone'])) { ?>
											<li><label class="error"><?= @$errors['user_phone'] ?></label></li>
										<?php } ?>
										<?php if (isset($errors['user_website'])) { ?>
											<li><label class="error"><?= @$errors['user_website'] ?></label></li>
										<?php } ?>
										<?php if (isset($errors['user_email'])) { ?>
											<li><label class="error"><?= @$errors['user_email'] ?></label></li>
										<?php } ?>
										<?php if (isset($errors['user_password'])) { ?>
											<li><label class="error"><?= @$errors['user_password'] ?></label></li>
										<?php } ?>
										<?php if (isset($errors['user_confirm_password'])) { ?>
											<li><label class="error"><?= @$errors['user_confirm_password'] ?></label></li>
										<?php } ?>
									</ul>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="fetures section p-t-80" id="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 col-xs-12">
					<div class="section-header text-center">
						<h3 class="section-title">Why ShipSecure?</h3>
						<p class="section-text">Get hassle-free shipping solutions for your online business to expand your customer reach and increase timely deliveries.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-center">
					<div class="future-box">
						<div class="icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/dedicated-ndr-team.png" alt="Dedicated NDR Team" title="Dedicated NDR Team">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="future-title">Dedicated NDR Team</h4>
						<p class="future-text">Our dedicated NDR team will take care of all your hassle while keeping a focus on maximum and super-fast delivery.</p>
					</div>
				</div>
				<div class="col-sm-4 text-center">
					<div class="future-box">
						<div class="icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/multiple-carrier-partner.png" alt="Integrate multiple carriers" title="Integrate multiple carriers">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="future-title">Integrate multiple carriers</h4>
						<p class="future-text">Why depend on a single courier partner when you can choose from multiple options?</p>
					</div>
				</div>
				<div class="col-sm-4 text-center">
					<div class="future-box">
						<div class="icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/uniform-rates-for-all-carriers.png" alt="Uniform rates for all carriers" title="Uniform rates for all carriers">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="future-title">Uniform rates for all carriers</h4>
						<p class="future-text">Our fixed cost model is providing you with the best services at affordable price.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-center">
					<div class="future-box">
						<div class="icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/high-end-tech-support.png" alt="High-end Tech Support" title="High-end Tech Support">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="future-title">High-end Tech Support</h4>
						<p class="future-text">Automated shipping solutions while keeping the process simple.</p>
					</div>
				</div>
				<div class="col-sm-4 text-center">
					<div class="future-box">
						<div class="icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/seven-days-cod-settlement.png" alt="7 days COD settlement" title="7 days COD settlement">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="future-title">7 days COD settlement</h4>
						<p class="future-text">Cut down your long remittance cycle to just 7 days!</p>
					</div>
				</div>
				<div class="col-sm-4 text-center">
					<div class="future-box">
						<div class="icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/no-subscription-fees.png" alt="Zero monthly fees" title="Zero monthly fees">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="future-title">Zero monthly fees</h4>
						<p class="future-text">No subscription fees, No minimum order commitments. Our platform is FREE to use.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="how-it-works section p-t-80 p-b-80" id="how">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 col-xs-12">
					<div class="section-header text-center">
						<h3 class="section-title">How to Ship with us?</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="how-work">
					<div class="col-md-4 col-sm-6">
						<div class="how-work-item">
							<div class="how-work-icon">
								<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/zero-monthly-fees.png" alt="Register with us for FREE" title="Register with us for FREE">
								<div class="lds-ring">
									<div></div>
									<div></div>
									<div></div>
									<div></div>
								</div>
							</div>
							<h4 class="how-work-title">Register with us for FREE</h4>
							<p>Fill out the contact details and take the first step towards simplifying your shipping.</p>
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="how-work-item">
							<div class="how-work-icon">
								<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/service-activation.png" alt="Service Activation" title="Service Activation">
								<div class="lds-ring">
									<div></div>
									<div></div>
									<div></div>
									<div></div>
								</div>
							</div>
							<h4 class="how-work-title">Service Activation</h4>
							<p>Sign in to the terms of service to use best courier companies at discounted rates.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="how-work-item">
						<div class="how-work-icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/start-shipping.png" alt="Start Shipping" title="Start Shipping">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="how-work-title">Start Shipping</h4>
						<p>Don’t worry about your e-commerce logistics anymore. Get moving.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="how-work">
				<div class="col-md-offset-2 col-md-4 text-center p-b-10">
					<p class="m-0 custom-note">No monthly contracts</p>
				</div>
				<div class="col-md-4 text-center p-b-10">
					<p class="custom-note">No minimum order commitments</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="app-about primary-gradient-bg section section-padding " id="about-count">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="about m-b-20">
					<div class="section-header">
						<h3 class="section-title text-md-center-alt">About Us</h3>
					</div>
					<div class="about-text">
						<p style='font-size: 17px;'>ShipSecure provides fast and reliable services across the 26000+ pin codes using our multiple channel partners’ vast networks so that our clients can take advantage of express delivery and extensive coverage that meets and exceeds the industry standards. Experience the Flexible solutions, deliver a world-class consumer experience for retailers and e-commerce companies.</p>
						<p style='font-size: 17px;'>We provide solutions that encompass both people and services for all modes, with fully automated and complete transparency.</p>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 ">
				<div class="counter-items ">
					<div class="counter-item">
						<div class="counter-content">
							<div class="counter-icon"><i class="fa fa-truck"></i></div>
							<div class="counter-body">
								<h3 class="fact-number">9,850+</h3>
								<p class="fact-text">Daily Shipments</p>
							</div>
						</div>
					</div>
					<div class="counter-item small">
						<div class="counter-content">
							<div class="counter-icon"><i class="fa fa-users"></i></div>
							<div class="counter-body">
								<h3 class="fact-number">350+</h3>
								<p class="fact-text">Happy<br>customers</p>
							</div>
						</div>
					</div>
					<div class="counter-item small">
						<div class="counter-content">
							<div class="counter-icon"><i class="fa fa-map-marker"></i></div>
							<div class="counter-body">
								<h3 class="fact-number">24,500+</h3>
								<p class="fact-text">Pin codes</p>
							</div>
						</div>
					</div>
					<div class="counter-item small">
						<div class="counter-content">
							<div class="counter-icon"><i class="fa fa-smile-o"></i></div>
							<div class="counter-body">
								<h3 class="fact-number">40+</h3>
								<p class="fact-text">Team Members</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="how-it-works section what-we-offer p-t-80 pb-md-40" id="what">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-xs-12">
				<div class="section-header text-center">
					<h3 class="section-title">What we offer?</h3>
					<p class="section-text">Features that fit your business</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="how-work">
				<div class="col-md-4 col-sm-6">
					<div class="how-work-item">
						<div class="how-work-icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/serving-20000+pin-codes.png" alt="Serving 26,000+ pin codes" title="Serving 26,000+ pin codes">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="how-work-title">Serving 26,000+ pin codes</h4>
						<p>Expand your reach with more than 26,000 serviceable pin codes across India.</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="how-work-item">
						<div class="how-work-icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/weekly-cod-remittances.png" alt="Cash on delivery" title="Cash on delivery">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="how-work-title">Cash on delivery</h4>
						<p>Be it prepaid or cash on delivery order, we process your orders at the lowest rates.</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="how-work-item">
						<div class="how-work-icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/upload-bulk-orders.png" alt="Upload bulk orders" title="Upload bulk orders">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="how-work-title">Upload bulk orders</h4>
						<p>Save your time by processing orders in bulk. ShipSecure help you to manage large order flow with few clicks.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="how-work">
				<div class="col-md-4 col-sm-6">
					<div class="how-work-item">
						<div class="how-work-icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/seamless-api-integration.png" alt="Seamless API Integration" title="Seamless API Integration">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="how-work-title">Seamless API Integration</h4>
						<p>Our Smart API system is designed to keep the process transparent at every stage.</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="how-work-item">
						<div class="how-work-icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/real-time-tracking.png" alt="Real time tracking" title="Real time tracking">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="how-work-title">Real time tracking</h4>
						<p>Get the status of your shipment at real time on your dashboard and continuously improve customer service.</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="how-work-item">
						<div class="how-work-icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/specialized-in-e-commerce-shipping.png" alt="Specialized in e-commerce shipping" title="Specialized in e-commerce shipping">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="how-work-title">Specialized in e-commerce shipping</h4>
						<p>Sync your orders from e-commerce store and rest is all managed by us.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="how-work">
				<div class="col-md-4 col-sm-6">
					<div class="how-work-item">
						<div class="how-work-icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/automated-order-management.png" alt="Automated order management" title="Automated order management">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="how-work-title">Automated order management</h4>
						<p>No more manual creating shipments, sync your orders from e-commerce store and you are all ready!</p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<div class="how-work-item">
						<div class="how-work-icon">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="assets/front-end/images/one-point-support-activated.png" alt="One-point support activated 24×7" title="One-point support activated 24×7">
							<div class="lds-ring">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<h4 class="how-work-title">Single point of contact</h4>
						<p>For all your shipment and post-shipment queries, your dedicated point of contact is on toes.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- <?php include "footer.php"; ?> -->
