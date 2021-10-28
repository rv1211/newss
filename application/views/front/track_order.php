<!-- Page -->
<style type="text/css">
	.panel {
		margin-bottom: 20px;
		border-color: #ddd;
		color: #333;
	}

	.panel-heading {
		background-color: #fff;
		border-bottom: 1px solid #ddd;
	}
</style>
<div id="page" class="ed-page">
	<!-- Page Hero -->
	<div id="page-hero" class="ed-page-hero">
		<section class="pt-md-4 pb-md-5 spec-section-1">
			<div class="overlay">
				<div class="hero-addon-b bg-light"></div>
				<div class="hero-addon-a addon-shadow bg-white"></div>
			</div>
			<div class="container parallax-onscroll opacity-onscroll text-center">
				<h1 class="mb-2 translate-text mob-font-head"><span>Track Order </span></h1>
			</div>
		</section>
	</div>
	<!-- Page Content -->
	<div id="page-content" class="ed-page-content">
		<section class="pt-md-6 pb-md-6">
			<div class="container">
				<center><img src="<?php echo base_url(); ?>assets/front-end/images/track_order.jpeg" alt="Track Order" style="width: 275px;margin-bottom: 32px;"></center>
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<blockquote style="padding: 40px;">
							<h4 class="text-center mb-4">ENTER THE AIRWAYBILL NUMBER</h4>
							<form method="post" name="track-form" action="<?php echo base_url('track-order#track_detail_div'); ?>" data-parsley-validate>
								<div class="form-group">
									<div class="row">
										<div class="col-md-12">

											<input type="text" name="tracking_number" id="tracking_number" placeholder="Enter Airwaybill No." class="form-control fc-bordered required" style="border: 1px solid #1874c1;" data-parsley-required="true" value="<?php echo @$tracking_number; ?>" required>
											<span class="error"></span>
										</div>
										<div class="col-md-12 text-center mt-4">
											<button class="btn btn-primary btn-border btn-shadow spec-section-3" type="submit">Track Result</button>
										</div>
									</div>
								</div>
							</form>
						</blockquote>
					</div>
				</div>
				<?php if ($track_data != "") { ?>
					<div class="panel panel-white" id="track_detail_div">
						<?php echo $track_data; ?>
					</div>
				<?php } ?>

				<!-- <div class="panel panel-white">
                    <div class="panel-heading">
                        <h6 class="panel-title">Track order Result</h6>
                    </div>
                    <form class="steps-async wizard clearfix" id="steps-uid-1">
                        <div class="steps clearfix" id="track_order_result">
                            <div class="col-md-12" style="margin-left: 10px;padding-bottom: 10px;">
                                Order status for (2250113796015) is <strong>Not Picked</strong><br>
                                <div id="">
                                    Current order location: <strong>Bhiwandi_Mankoli_GW (Maharashtra)</strong><br>
                                    Date: <strong>04-07-2020</strong> - Time: <strong>19:04:12</strong>
                                </div>
                            </div>
                            <ul role="tablist" id="order_status">
                                <li role="tab" class="current done" aria-disabled="false" aria-selected="false">
                                    <a id="steps-uid-1-t-0" aria-controls="steps-uid-1-p-0" class="inactiveLink"><span class="number">1</span>
                                        Pending
                                    </a>
                                </li>
                                <li role="tab" class="current done" aria-disabled="false" aria-selected="false">
                                    <a id="steps-uid-1-t-1" aria-controls="steps-uid-1-p-1" class="inactiveLink"><span class="number">2</span>
                                        Processing
                                    </a>
                                </li>
                                <li role="tab" class="current " aria-disabled="false" aria-selected="false">
                                    <a id="steps-uid-1-t-1" aria-controls="steps-uid-1-p-1" class="inactiveLink"><span class="number">3</span> Pick Up Done
                                    </a>
                                </li>
                                <li role="tab" class="current " aria-disabled="false" aria-selected="false">
                                    <a id="steps-uid-1-t-1" aria-controls="steps-uid-1-p-1" class="inactiveLink"><span class="number">4</span>
                                      In Transit
                                  </a>
                                </li>
                                <li role="tab" class="current " aria-disabled="false" aria-selected="false">
                                    <a id="steps-uid-1-t-1" aria-controls="steps-uid-1-p-1" class="inactiveLink"><span class="number">5</span>  Out For Delivery
                                    </a>
                                </li>
                                <li role="tab" class="current " aria-disabled="false" aria-selected="true">
                                    <a id="steps-uid-1-t-3" aria-controls="steps-uid-1-p-3" class="inactiveLink"><span class="current-info audible">current step: </span><span class="number">6</span> Delivered
                                    </a>
                                </li>
                                <li role="tab" class="current " aria-disabled="false" aria-selected="false">
                                    <a id="steps-uid-1-t-2" aria-controls="steps-uid-1-p-2" class="inactiveLink"><span class="number">7</span>
                                        Cancelled
                                    </a>
                                </li>
                            </ul>
                            <hr>
                            <div class="col-md-12" style="margin-left: 5px;padding-bottom: 10px;">
                                <div class="col-md-4 col-md-offset-4">
                                    <strong>Receiver Address</strong><br>
                                    <div class="receiver-address">Ashok Prajapati,<br> Eva Lady, Shop No.02, Sejheercembear, Thikrul, Alibagh, Maharashtra,<br> alibagh - 402201,<br> maharashtra,<br> India</div>
                                </div>
                            </div>
                            <div class="col-md-12" id="scan-content-div" style="padding-left:0px;padding-right:0px;border-top: 1px solid #BBB;">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Scan Date</th>
                                                <th>Scan</th>
                                                <th>Location</th>
                                                <th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>05-03-2020 10:20:35.</td>
                                                <td>Manifested</td>
                                                <td>Bhiwandi_Mankoli_GW (Maharashtra)</td>
                                                <td>Consignment Manifested</td>
                                            </tr><tr>
                                                <td>05-03-2020 16:21:33.</td>
                                                <td>Manifested</td>
                                                <td>Bhiwandi_Mankoli_GW (Maharashtra)</td>
                                                <td>Seller cancelled the order</td>
                                            </tr><tr>
                                                <td>04-07-2020 19:04:12.</td>
                                                <td>Not Picked</td>
                                                <td>Bhiwandi_Mankoli_GW (Maharashtra)</td>
                                                <td>Package not picked/received from client</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> -->



			</div>
		</section>
	</div>
</div>
