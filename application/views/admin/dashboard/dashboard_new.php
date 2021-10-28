<div class="page">
	<!-- start page content -->
	<div class="page-content">
		<div class="row">
			<div class="col-sm-12 col-lg-8">
				<!-- Whelcome Message div -->
				<div class="col-lg-12">
					<div class="panel">
						<!-- start panel body -->
						<div class="panel-body container-fluid">
							<div class="row row-lg">
								<div class="col-md-8 welcome_lable">
									<h2>Welcome <span class="users_text"> <?= $this->data['name']; ?></span></h2>
									<label class="dash_body">Grow up your business with Shipsecure
										Logistics</label>
								</div>
								<div class="col-md-4">
									<img src="<?= base_url('assets/images/dashboard/delever_boy.png') ?>" class="deliver_boy ">
								</div>
								<div class="col-md-8 welcome_lable">
									<!-- <h2>Welcome <span class="users_text"> <?= $this->data['name']; ?></span></h2> -->
									<h4><label class="error">To See Old Data till before 12-10-2021 : </label><a id="old-data" target="_blank" href="https://old.shipsecurelogistics.com/" class="btn btn-info">Click Me</a></h4>
								</div>
							</div>
						</div>
						<!-- end panel body -->
					</div>
				</div>
				<!-- Whelcome Message div end -->
				<!-- All orders -->
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title"><strong>Orders</strong></h3>
							<div class="panel-actions">
								<div id="today_orders_count" class="pull-right date_picker_btn">
									<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
									<span></span> <b class="caret"></b>
								</div>
							</div>
						</div>
						<!-- start panel body -->
						<div class="panel-body container-fluid">
							<ul class="nav nav-pills" role="tablist">
								<a href="<?= base_url('view-order'); ?>" target="_blank">
									<li class="nav-item orer_li">
										<img src="<?= base_url('assets/images/dashboard/all_orders_color.svg'); ?>" height="15px;" class="icons" alt="dashboard icon">
										<div class="dash-txt" id="all_order_count_result">
											<?= @$all_order_count_result; ?></div>
										<span class="dash-order-text">All Orders</span>
									</li>
								</a>
								<a href="<?= base_url('createdOrderList'); ?>" target="_blank">
									<li class="nav-item orer_li">
										<img src="<?= base_url('assets/images/dashboard/create_order_color.svg'); ?>" class="icons" alt="dashboard icon">
										<div class="dash-txt" id="created_order_count_result">
											<?= @$created_order_count_result; ?></div>
										<span class="dash-order-text">Create Orders</span>
									</li>
								</a>
								<a href="<?= base_url('Intransit-Order-List'); ?>" target="_blank">
									<li class="nav-item orer_li">
										<img src="<?= base_url('assets/images/dashboard/in_transists_color.svg'); ?>" class="icons" alt="dashboard icon">
										<div class="dash-txt" id="intransit_count_result">
											<?= @$intransit_count_result; ?></div>
										<span class="dash-order-text">In Transit</span>
									</li>
								</a>
								<a href="<?= base_url('ofd-Order-List'); ?>" target="_blank">
									<li class="nav-item orer_li">
										<img src="<?= base_url('assets/images/dashboard/ofd_color.svg'); ?>" class="icons" alt="dashboard icon">
										<div class="dash-txt" id="ofd_count_result"><?= @$ofd_count_result; ?></div>
										<span class="dash-order-text">OFD</span>
									</li>
								</a>
								<a href="<?= base_url('ndr-Order-List'); ?>" target="_blank">
									<li class="nav-item orer_li">
										<img src="<?= base_url('assets/images/dashboard/ndr_color.svg'); ?>" class="icons" alt="dashboard icon">
										<div class="dash-txt" id="ndr_count_result"><?= @$ndr_count_result; ?></div>
										<span class="dash-order-text">NDR</span>
									</li>
								</a>
								<a href="<?= base_url('delivered-Order-List'); ?>" target="_blank">
									<li class="nav-item orer_li">
										<img src="<?= base_url('assets/images/dashboard/delevier_color.svg'); ?>" class="icons" alt="dashboard icon">
										<div class="dash-txt" id="delivered_count_result">
											<?= @$delivered_count_result; ?></div>
										<span class="dash-order-text">Delivered</span>
									</li>
								</a>
								<a href="<?= base_url('rto-intransit-Order-List'); ?>" target="_blank">
									<li class="nav-item orer_li">
										<img src="<?= base_url('assets/images/dashboard/rto_intransis.svg'); ?>" class="icons" alt="dashboard icon">
										<div class="dash-txt" id="rto_intransit_count_result">
											<?= @$rto_intransit_count_result; ?></div>
										<span class="dash-order-text">RTO In Transit</span>
									</li>
								</a>
								<a href="<?= base_url('rto-delivered-Order-List'); ?>" target="_blank">
									<li class="nav-item orer_li">
										<img src="<?= base_url('assets/images/dashboard/rto_deleive_color.svg'); ?>" class="icons" alt="dashboard icon">
										<div class="dash-txt" id="rto_delivered_count_result">
											<?= @$rto_delivered_count_result; ?></div>
										<span class="dash-order-text">RTO Delivered</span>
									</li>
								</a>
							</ul>
						</div>
						<!-- end panel body -->
					</div>
				</div>
				<!-- All orders end -->
				<!-- Orders to Fullfill div -->
				<!-- <div class="col-lg-12">
					<div class="panel order_fulfill">

						<div class="panel-body container-fluid">
							<div class="row-lg row">
								<div class="col-md-12">
									<img src="<?= base_url('assets/images/dashboard/ndr-dashboard-group-13.svg'); ?>" class="Oval" alt="dashboard icon">
									<span class="to-txt-6 dash-amount" id="all_created_order_count"><?= @$all_created_order_count; ?></span>
									<span class="orders-to-fullfill-txt">Orders to Fullfill</span>
								</div>
							</div>
						</div>

					</div>
				</div> -->
				<!-- Orders to Fullfill div end -->
				<!-- COD Remittance div -->
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title hidden_lable">Out for Delivery</h3>
							<div class="panel-actions">
								<div id="cod_remittance_count" class="pull-right date_picker_btn">
									<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
									<span></span> <b class="caret"></b>
								</div>
							</div>
						</div>
						<!-- start panel body -->
						<div class="panel-body container-fluid">
							<div class="row-lg row">
								<div class="col-md-3 ">
									<img src="<?= base_url('assets/images/dashboard/cod.svg'); ?> " class="image_dash">
								</div>
								<div class="col-md-9">
									<div class="col-md-12">
										<span class="cod-remittance-title">COD Remittance</span>
									</div>
									<ul class="nav nav-pills" role="tablist">
										<li class="nav-item orer_li">
											<span class="cod-text">₹ </span>
											<span class="cod-text" id="remitted_amount"><i class="fa fa-rupee-sign"></i></span>
											<div class="dash-order-text dash-mt">Remitted Amount</div>
										</li>
										<li class="nav-item orer_li">
											<span class="cod-text"><?= $next_remmitance; ?></span>
											<div class="dash-order-text dash-mt">Next Remittance</div>
										</li>
										<li class="nav-item orer_li">
											<span class="cod-text">₹ </span> <span class="cod-text" id="unremitted_amount"><i class="fas fa-rupee-sign"></i></span>
											<div class="dash-order-text dash-mt">Unremitted Amount</div>
										</li>
									</ul>
									<hr>
									<ul class="nav nav-pills" role="tablist">
										<li class="nav-item orer_li">
											<div class="dash-order-text dash-mt">Avg.shipping cost: ₹ <span class="span-bill-amount" id="avg_shipping_cost"></span></div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<!-- end panel body -->
					</div>
				</div>
				<!-- COD Remittance div end -->
				<!-- Pending Actions div -->
				<!-- <div class="col-lg-12">
					<div class="panel order_fulfill">
						
						<div class="panel-body container-fluid">
							<div class="row-lg row">
								<div class="col-md-12">
									<img src="<?= base_url('assets/images/dashboard/ndr-dashboard-group-14.svg'); ?>" class="Oval" alt="dashboard icon">
									<span class="to-txt-6 dash-amount" id="all_created_order_count">0</span>
									<span class="orders-to-fullfill-txt">Pending Actions</span>
								</div>
							</div>
						</div>
						
					</div>
				</div> -->
				<!-- Pending Actions div end -->
				<!-- Out for Delivery div -->
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title hidden_lable">Out for Delivery</h3>
							<div class="panel-actions">
								<div id="ofd_count" class="pull-right date_picker_btn">
									<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
									<span></span> <b class="caret"></b>
								</div>
							</div>
						</div>
						<!-- start panel body -->
						<div class="panel-body container-fluid">
							<div class="row-lg row">
								<div class="col-md-3 ">
									<img src="<?= base_url('assets/images/dashboard/out-delivery.svg'); ?>" class="out-for-delivery-img">
								</div>
								<div class="col-md-9">
									<div class="col-md-12">
										<div class="out-delivery">
											<span class="Out-for-Delivery">Out for Delivery</span>
										</div>
									</div>
									<ul class="nav nav-pills" role="tablist">
										<li class="nav-item orer_li">
											<span class="ofd-no-1" id="total_ofd"><?= @$ofd_csount_result; ?></span>
											<div class="total-OFD">OFD</div>
										</li>
										<li class="nav-item orer_li">
											<span class="ofd-no-1" id="total_delivered"><?= @$delivered_count_result; ?></span>
											<div class="total-OFD">Delivered </div>
										</li>
										<li class="nav-item orer_li">
											<span class="ofd-no-1" id="total_rto"><?= @$rto_intransit_count_result + @$rto_delivered_count_result; ?></span>
											<div class="total-OFD">RTO</div>
										</li>
										<li class="nav-item orer_li">
											<span class="ofd-no-1" id="total_undelivered"><?= @$ndr_count_result; ?></span>
											<div class="total-OFD">Undelivered</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<!-- end panel body -->
					</div>
				</div>
				<!-- Out for Delivery div end -->
				<!-- Daily Shipments Count div -->
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title"><strong>Daily Shipments Count</strong></h3>
							<div class="panel-actions">
								<ul class="nav nav-pills">
									<li class="nav-item order_header_li order_header_drop">
										<select class="form-control select2 daily_shipment_logistic" name="" id="">

											<option value="0">All</option>
											<?php if (!empty($logistics_list)) {
												foreach ($logistics_list as $value) { ?>
													<option value="<?= $value['id'] ?>">
														<?= $value['logistic_name']; ?></option>
											<?php }
											} ?>
										</select>
									</li>
									<li class="nav-item order_header_li">
										<div id="daily_shipments_count" class="pull-right date_picker_btn">
											<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
											<span></span> <b class="caret"></b>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<!-- start panel body -->
						<div class="panel-body container-fluid">
							<div class="row-lg row daily_shipment">
								<div class="col-md-12 daily_shipment_table_data">
									<table id="daily_shipment_table" class="pop-of-prod-table no-footer dataTable table table-striped" style="overflow: hidden;" width="96%" role="grid">
										<thead class="pop-of-prod-table-head carrier-thead">
											<tr>
												<th class="text-center">Date</th>
												<th class="text-center">New Order</th>
												<th class="text-center">Pickup</th>
												<th class="text-center">In Transit</th>
												<th class="text-center">OFD</th>
												<th class="text-center">Delivered</th>
												<th class="text-center">Undelivered</th>
												<th class="text-center">RTO</th>
											</tr>
										</thead>
										<tbody>
											<tr class="odd">
												<td valign="top" colspan="8" class="dataTables_empty">
													<div class="text-center mt-4 mb-4 pt-2 pb-2"><img src="<?= base_url('assets/images/dashboard/search.svg'); ?>" class="no-record-found mb-2 dash-img-not-found">
														<p class="no-margin text-semibold font-16 tbody-nrf"> No Record
															Found</p>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- end panel body -->
					</div>
				</div>
				<!-- Daily Shipments Count div end -->
				<!-- Total Carrier Performance div -->
				<div class="col-lg-12">
					<div class="panel">
						<div class="panel-heading">
							<h3 class="panel-title"><img src="<?= base_url('assets/images/dashboard/ndr-dashboard-parcel.svg') ?>" class="parcel-copy total_carrier"><strong>Total Carrier Performance</strong></h3>
							<div class="panel-actions">
								<ul class="nav nav-pills">
									<li class="nav-item order_header_li">
										<div id="carrier_performance_count" class="pull-right date_picker_btn">
											<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
											<span></span> <b class="caret"></b>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<!-- start panel body -->
						<div class="panel-body container-fluid">
							<div class="row-lg row carrier_performance_count_div">
							</div>
						</div>
						<!-- end panel body -->
					</div>
				</div>
				<!-- Total Carrier Performance div end -->

			</div>
			<div class="col-sm-12 col-lg-4">
				<!-- Graph div -->
				<div class="col-lg-12">
					<!-- <div class="panel order_fulfill"> -->
					<!-- start panel body -->
					<!-- <div class="panel-body container-fluid"> -->
					<!-- <canvas id="exampleChartjsRadar" height="800" width="800" class="chartjs-render-monitor radar-canvas"></canvas> -->
					<!-- </div> -->
					<!-- end panel body -->
					<!-- </div> -->
					<div class="panel order_fulfill">
						<!-- start panel body -->
						<div class="panel-body container-fluid">
							<canvas id="exampleChartjsBar" height="800" width="800" class="chartjs-render-monitor radar-canvas"></canvas>
						</div>
						<!-- end panel body -->
					</div>
					<div class="panel order_fulfill">
						<br>
						<p class="text-center font-weight-bold h4">
							Cod Chart
						</p>
						<!-- start panel body -->
						<div class="panel-body container-fluid">
							<canvas id="exampleChartjsBar2" height="800" width="800" class="chartjs-render-monitor radar-canvas chart2"></canvas>
						</div>

						<!-- end panel body -->
					</div>
				</div>
				<!-- Graph div end -->
			</div>
		</div>
	</div>
	<!-- end page content -->
</div>