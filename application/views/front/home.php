<style type="text/css">
	.price_box {
		background-color: #ffffff;
		padding: 10px;
		border: 1px solid #000;
	}

	#price_show {
		margin-top: 10px;
	}

	.table {
		border-color: #bfb9b9;
	}

	#getpriceModal .table-price-box>tbody>tr>td {
		border-color: #bfb9b9;
		padding: 5px
	}

	#getpriceModal .table-price-box>thead>tr>th {
		border-color: #bfb9b9;
		padding: 5px
	}

	#getpriceModal .table-price-box>tfoot>tr>td {
		border-color: #bfb9b9;
		padding: 5px
	}

	.price_box1 {
		margin-bottom: 10px;
	}

	.modal_buttons {
		padding: 50px;
		text-align: center;
		border: 1px solid #eee;
	}

	#getpriceModal .modal-dialog {
		width: 500px
	}

	#getpriceModal .modal-content {
		margin-top: 35%;
	}

	#getpriceModal .modal-header {
		padding: 6px;
	}

	#tallModal {
		top: 25%;
	}

	#getpriceModal {
		background-color: #404040cc;
		opacity: inherit;
	}

	span.amount,
	.selectable-item,
	.example-title {
		display: none;
	}
</style>
<div id="page" class="ed-page mobile-h2">
	<div>
		<marquee style="color: red;margin-bottom: -7px;">Dear customer, please consider that in case of missing/damage of your parcels the refund will be given within 45 working days and the maximum refund amount will be upto RS 2000/- INR<span style="margin-left: 25px"></span>All Customer kindly note that please pay your attention while filling the weight of your parcel. Incase of putting wrong / less weight, we will deduct the penalty or charges as applicable your acocunt.</marquee>
		<!-- <br>
        <center>
        <blink  style="color:#4ac8ec; font-size: 20px; font-weight: bold;">if any query about cod remittance then contact to 9638717047</blink>
        </center> -->
	</div>
	<div id="page-hero" class="ed-page-hero">
		<section class="fullscreen-element pt-6 pb-6 mobile-pt-3 mobile-pb-3" style="padding-bottom: 0px">
			<div class="overlay">
				<div class="hero-addon-a addon-shadow">
					<div class="addon-inner">
						<div class="overlay-inner" style=" background: linear-gradient(to right, #46717F , #89D6D6);"></div>
					</div>
				</div>
			</div>
			<div class="fe-container">
				<div class="fe-content align-middle">
					<div class="container text-center parallax-onscroll opacity-onscroll" style="margin-bottom: -65px">
						<div class="row">
							<div class="col-md-5 col-sm-12">
								<h1 class='text-white mb-2 mobile-h1'><span>Best E-commerce shipping solution in India</span></h1>
								<h2 class="text-white mb-4 mobile-h1" id='subhead-mob'><span class='spec-section-2'>Your 3PL Partner for all your shipping problems</span></h2>
								<h2 class="text-white mb-4 mobile-h1" id='subhead-desk'><span class='spec-section-2'>Your logistics partner for shipping solutions. Get fastest delivery, least returns.</span></h2>
								<?php if (@$this->session->userdata('id') == '') { ?>
									<center><a href="<?php echo base_url('register'); ?>" class="btn btn-white btn-shadow btn-rounded mb-2">Signup Now</a></center>
								<?php } ?>
								<!-- <img src="<?php echo base_url(); ?>assets/front-end/images/itl-image.jpg" style="width: 500px; margin-bottom: 20px;" id='home-left-section-img' alt='itl-image'> -->
								<img src="<?php echo base_url(); ?>assets/front-end/images/homepage-image.png" style="width: 500px;" id='home-left-section-img' alt=''>
								<!-- <center><a href="//www.shipsecure.com/contact" class="btn btn-outline-white scrollto">Ask Us</a></center> -->
							</div>
							<div class="col-md-5 col-sm-12">
								<!--<video autoplay loop>
								  <source src="//www.shipsecure.com/images/video/itl_video.mp4" type="video/mp4">
								Your browser does not support the video tag.
								</video>-->
								<!-- <img src="<?php echo base_url(); ?>assets/front-end/images/itl-image.jpg" style="width: 500px;" id='home-right-section-img' alt='itl-image'> -->
								<img src="<?php echo base_url(); ?>assets/front-end/images/homepage-image.png" style="width: 500px;" id='home-right-section-img' alt=''>
							</div>
							<div class="col-md-2 col-sm-12">
								<div class="signupform">
									<div class="price_box1">
										<input type="text" class="form-control price_box" placeholder="Pickup Pincode" name="pickup_pincode" id="pickup_pincode">
										<span class="error"></span>
									</div>
									<div class="price_box1">
										<input type="text" class="form-control price_box" placeholder="Receive Pincode" name="receive_pincode" id="receive_pincode">
										<span class="error"></span>
									</div>
									<div class="price_box1">
										<input type="text" class="form-control price_box" name="physical_weight" id="physical_weight" placeholder="Physical Weight(In KG)">
										<span class="error"></span>
									</div>
									<button type="button" class="btn btn-sm btn-shadow btn-rounded-circle btn-grad" id="get_price">Get price</button>
									<div id="price_show" style="display: none;">
										<table class="table table-xs table-bordered table-price-box" id="rate_table_div" width="100%">
											<tbody id="table_data">
												<!-- <tr>
													<td>
														<img src="<?php echo base_url(); ?>assets/front-end/images/delhivery.png" style="width:40px;">
													</td>
													<td style="text-align:right" width="50%" class="shipp_rate">&#2352;
														<span id="delhivery_rate">0.00</span>
													</td>
												</tr>
												<tr>
													<td style="text-align:right">
														<b>GST (18%)</b>
													</td>
													<td style="text-align:right">
														<b class="total_gst">&#2352;
															<span id="total_gst" >0</span>
														</b>
													</td>
												</tr>
												<tr>
													<td style="text-align:right">
														<b>Total <br><small>(incl. GST)</small></b>
													</td>
													<td style="text-align:right">
														<b class="total_rate">&#2352;
															<span id="total_summary">0</span>
														</b>
													</td>
												</tr> -->
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2">18% GST will Add on price</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	<div id="page-content" class="ed-page-content">
		<section class="pt-md-4 pb-md-4">
			<div class="overlay">
				<div class="overlay-inner" style="background-color:#E8E3DD !important"></div>
			</div>
			<div class="container">
				<div class="row">

					<div class="col-sm-8 text-center">
						<h4 style="color:#5A8E9A;margin-bottom: 0px;"><span>PROUD MOMENT</span></h4>
						<p class="lead  is-animated" style="margin-bottom: 5px;color: #000;"><span>A budding year old Startup now among <b>YOUR STORY'S TOP 30</b></span></p>
						<a href="#" target="_blank" class="btn btn-sm btn-primary btn-shadow btn-rounded mb-2" id='know-more-desk'>Know More</a>
					</div>
					<div class="col-sm-4 text-center">
						<a href="#" target="_blank" class=" mb-2" target="_blank">
							<img src="<?php echo base_url(); ?>assets/front-end/images/TechSparks18Deck.png" class='fix-temp' alt='Tech Sparks 2018'>
						</a>
						<a href="#" target="_blank" class="btn btn-sm btn-primary btn-shadow btn-rounded mb-2" id='know-more-mob'>Know More</a>

					</div>
				</div>
			</div>
		</section>
	</div>
	<div id="page-content-1" class="ed-page-content">
		<section class="pt-md-7 pb-md-4">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 text-center">
						<h2 class="mb-2 "><span>Ease of shipping solution</span></h2>
						<p class="lead mb-4-5 "><span>ShipSecure is the third party logistic service provider to make your ecommerce shipping process easier than ever.</span></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<div class="feature-block mb-5">
							<div class="feature-block-icon mb-3 text-primary">
								<div class='text-center image-center'>
									<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/locationE2.jpg" alt='Serviceable Pin Codes'>
									<div class="lds-ring">
										<div></div>
										<div></div>
										<div></div>
										<div></div>
									</div>
								</div>
							</div>
							<center>
								<h3 class="h4 mb-2 "><span>26000+ serviceable pin codes</span></h3>
							</center>
							<center>
								<p class=""><span>ShipSecure is providing more than 26000 serviceable pin codes across India and help you to select the best courier partner to reach your doorstep.</span></p>
							</center>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="feature-block mb-5 mb-sm-0">
							<div class="feature-block-icon mb-3 text-primary">
								<div class='text-center image-center'>
									<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/multiple_shipping_partners.jpg" alt='Multiple Shipping Partners'>
									<div class="lds-ring">
										<div></div>
										<div></div>
										<div></div>
										<div></div>
									</div>
								</div>
							</div>
							<center>
								<h3 class="h4 mb-2 "><span>Multiple shipping partners</span></h3>
								<p class=""><span>At ShipSecure, explore the services of multiple carrier partners using a single platform and select a best shipping partner based on their rates.</span></p>
							</center>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="feature-block mb-5">
							<div class="feature-block-icon mb-3 text-primary">
								<div class='text-center image-center'>
									<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/automated_shipping.jpg" alt='Automated Shipping'>
									<div class="lds-ring">
										<div></div>
										<div></div>
										<div></div>
										<div></div>
									</div>
								</div>
							</div>
							<center>
								<h3 class="h4 mb-2 "><span>Automated shipping processes</span></h3>
								<p class=""><span>We have developed a panel with features like marketplace store sync, automated label generation and pickup request as merchant to simplify your shipment process.</span></p>
							</center>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<div class="feature-block mb-5">
							<div class="feature-block-icon mb-3 text-primary">
								<div class='text-center image-center'>
									<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/no_platform_setup_fees.jpg" alt='No Platform Setup Fees'>
									<div class="lds-ring">
										<div></div>
										<div></div>
										<div></div>
										<div></div>
									</div>
								</div>
							</div>
							<center>
								<h3 class="h4 mb-2 "><span>No platform setup fees</span></h3>
								<p class=""><span>You don’t need to pay any setup fees to integrate the multiple platforms, ShipSecure charges a minimum rate on your shipping that too without any hidden charges.</span></p>
							</center>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="feature-block mb-5">
							<div class="feature-block-icon mb-3 text-primary">
								<div class='text-center image-center'>
									<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/upload orders in bulk.jpg" alt='Bulk Uploads'>
									<div class="lds-ring">
										<div></div>
										<div></div>
										<div></div>
										<div></div>
									</div>
								</div>
							</div>
							<center>
								<h3 class="h4 mb-2 "><span>Upload bulk orders</span></h3>
								<p class=""><span>Save your valuable time and enjoy our bulk order uploading feature for free. ShipSecure help you to manage large order flow with a single click.</span></p>
							</center>
						</div>
					</div>
					<div class="col-md-4 col-sm-4">
						<div class="feature-block">
							<div class="feature-block-icon mb-3 text-primary">
								<div class='text-center image-center'>
									<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/api_integration.jpg" alt='API Integration'>
									<div class="lds-ring">
										<div></div>
										<div></div>
										<div></div>
										<div></div>
									</div>
								</div>
							</div>
							<center>
								<h3 class="h4 mb-2 "><span>API Integration</span></h3>
								<p class=""><span>ShipSecure allows you to access the dashboard from whatever platform you use. The main feature it provides is it imports all your orders and sync with the system.</span></p>
							</center>
						</div>
					</div>
				</div>
			</div>
	</div>
	</section>
	<section class="pb-md-7">
		<div class="overlay">
			<div class="overlay-inner bg-light"></div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-9 col-md-offset-3 col-sm-12">
					<h2 class="mb-4-5 col-sm-12 "><span>Why ShipSecure?</span></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/banner1.jpg" style="margin-left: 55px;min-height: 500px;" id='iTL_resp' alt='Why ShipSecure'>
					<div class="lds-ring">
						<div></div>
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="col-md-12 mb-4-5">
						<h4 class="h4">Auto update and sync pin codes</h4>
						<p>ShipSecure comes with multiple features making your eCommerce shipping ease.
							We offer you 26000+ serviceable pin codes across India. You can easily sync all your orders and pin codes.
							Get the status of all your shipment orders that is updated automatically.</p>
					</div>
					<div class="col-md-12 mb-4-5">
						<h4 class="h4">Multiple courier partners</h4>
						<p>Our platform enables the merchant to set the priority for using the couriers. You can select the best partner for your shipping needs from the range of shipping partner available.
							Now no need to depend on a single courier partner when you can choose from multiple options.
						</p>
					</div>
					<div class="col-md-12 mb-4-5">
						<h4 class="h4">Daily MIS reports</h4>
						<p>Generate order and shipping information in the form of reports on a daily basis. </p>
					</div>
					<div class="col-md-12 mb-4-5">
						<h4 class="h4">Best shipping price</h4>
						<p>Shipping with multiple courier companies at lowest shipping rates.
							Save Money when you ship using ShipSecure. The rates we allocate on your behalf are some of the best available in the market.
						</p>
					</div>
					<div class="col-md-12 mb-4-5">
						<h4 class="h4">Ship faster and safer</h4>
						<p>Faster shipping services as per the requirements of the customers.
							Safety of your package is our responsibility. Security handling facility which gives the safe and secure delivery.
						</p>
					</div>
					<div class="col-md-12">
						<h4 class="h4">Enjoy happy customer base</h4>
						<p>We always listen to what our Customers are saying. Our main aim to keep the customer satisfied with service is non-negotiable.</p>
					</div>
				</div>

			</div>
		</div>
	</section>
	<section class="pt-md-7 pb-md-7 lozad" data-background-image="<?php echo base_url(); ?>assets/front-end/images/background.jpg" style='z-index: -1;'>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h2 class=" text-center mb-4-5"><span style="color: #ffffff;">Sales Channel Integrations</span></h2>
				</div>
				<div class="col-sm-12 text-center">
					<img class="text-center lozad" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/channel-partners-3.png" alt='Channel Partners'>
					<div class="lds-ring">
						<div></div>
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- <section class="pt-md-4-5 pb-md-4-5">
			<div class="container">
			<div class="row">
					<div class="col-sm-12 text-center">
						<h2 class="mb-3  mob-p-b"><span>Brands using ShipSecure</span></h2>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-xs-6 text-center">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/client-1.jpg" alt='Urban Monkey'>
							<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
					</div>
					<div class="col-md-2 col-xs-6 text-center">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/client-2.jpg" alt='Go Cherish'>
							<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
					</div>
					<div class="col-md-2 col-xs-6 text-center">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/client-3.jpg" alt='Madish'>
							<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
					</div>
					<div class="col-md-2 col-xs-6 text-center">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/client-4.jpg" alt='Strictly Designer'>
							<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
					</div>
					<div class="col-md-2 col-xs-6 text-center">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/client-5-E.jpg" alt='Nicci'>
							<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
					</div>
					<div class="col-md-2 col-xs-6 text-center">
							<img class='lozad' src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCAzIDInPjwvc3ZnPg==" data-src="<?php echo base_url(); ?>assets/front-end/images/client-6.jpg" style='width: 100%; max-width:195px;' alt='dmo'>
							<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
					</div>
				</div>
			</div>
		</section> -->
</div>
</div>
<div class="modal fade" id="getpriceModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 style="text-align: left; display: initial; padding: 5px; vertical-align: sub;"> Price List</h4>
				<button type="button" class="close" data-dismiss="modal">X</button>
				<!-- <a href="<?php echo base_url('view-order'); ?>" class="close" >x</a> -->
			</div>
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="tallModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">X</button>
			</div> -->
			<div class="modal-body">
				<div width="100%">
					<center><img src="<?= base_url(); ?>assets/front-end/images/udaan-express-homepage-image.jpeg"></center>
				</div>

				<hr>
				<h4>Udaan is live now enjoy with one more shipping solution</h4>
			</div>
		</div>
	</div>
</div>
<?php //include "footer.php"; 
?>
<!-- <script type="text/javascript">
	$(document).ready(function() {
  $('#tallModal').modal('show');
});
</script> -->
<?php //include "footer.php"; 
?>
