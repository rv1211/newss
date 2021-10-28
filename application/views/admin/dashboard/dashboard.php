<div class="page">
	<div class="page-content container-fluid">
		<div class="row">
			<div class="col-md-8">
				<!-- card 1  start -->
				<div class="col-md-12 dashboard1">
					<div class="card card-shadow cards_dashboard">
						<div class="card-block p-20 pt-10">
							<div class="clearfix">
								<div class="float-left dash_title">
									<div class="inline-block text1 mr-5">
										<h2>Welcome </h2>
									</div>
									<div class="inline-block text1 ml-5">
										<h2 class="users_text"> <?= $this->data['name']; ?></h2>
									</div>
									<div class="dash_body">
										<label>Grow up your business with Shipsecure
											Logistics</label>
									</div>
								</div>
								<div class="float-right">
									<img src="<?= base_url('assets/images/dashboard/delever_boy.png') ?>" class="deliver_boy">
									<img class="Group-17">
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- card 1  End -->
				<!-- card 2  Start -->
				<div class="col-md-12 mt--14 dash-ht-300">
					<div class="card card-shadow cards_dashboard">
						<div class="card-block">
							<div class="clearfix">
								<div class="float-left py-10 ds_ft">
									<h4 class="ds_h4" id="order_count_header">Orders</h4>
								</div>
								<div class="float-right py-10">
									<div id="today_orders_count" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
										<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
										<span></span> <b class="caret"></b>
									</div>
								</div>
							</div>
							<div class="dash-card2">
								<a href="<?= base_url('view-order'); ?>" target="_blank">
									<div class="serviceBox2">
										<div class="dash-box">
											<img src="<?= base_url('assets/images/dashboard/all_orders_color.svg'); ?>" class="icons" alt="dashboard icon">
											<div class="dash-txt" id="all_order_count_result">0</div>
											<span class="dash-order-text">All Orders</span>
										</div>
									</div>
								</a>
								<a href="<?= base_url('createdOrderList'); ?>" target="_blank">
									<div class="serviceBox2">
										<div class="dash-box">
											<img src="<?= base_url('assets/images/dashboard/create_order_color.svg'); ?>" class="icons" alt="dashboard icon">
											<div class="dash-txt" id="created_order_count_result">0</div>
											<span class="dash-order-text">Create Orders</span>
										</div>
									</div>
								</a>
								<a href="<?= base_url('Intransit-Order-List'); ?>" target="_blank">
									<div class="serviceBox2">
										<div class="dash-box">
											<img src="<?= base_url('assets/images/dashboard/in_transists_color.svg'); ?>" class="icons" alt="dashboard icon">
											<div class="dash-txt" id="intransit_count_result">0</div>
											<span class="dash-order-text">In Transit</span>
										</div>
									</div>
								</a>
								<a href="<?= base_url('ofd-Order-List'); ?>" target="_blank">
									<div class="serviceBox3">
										<div class="dash-box">
											<img src="<?= base_url('assets/images/dashboard/ofd_color.svg'); ?>" class="icons" alt="dashboard icon">
											<div class="dash-txt" id="ofd_count_result">0</div>
											<span class="dash-order-text">OFD</span>
										</div>
									</div>
								</a>
								<a href="<?= base_url('ndr-Order-List'); ?>" target="_blank">
									<div class="serviceBox4">
										<div class="dash-box">
											<img src="<?= base_url('assets/images/dashboard/ndr_color.svg'); ?>" class="icons" alt="dashboard icon">
											<div class="dash-txt" id="ndr_count_result">0</div>
											<span class="dash-order-text">NDR</span>
										</div>
									</div>
								</a>
								<a href="<?= base_url('delivered-Order-List'); ?>" target="_blank">
									<div class="serviceBox4">
										<div class="dash-box">
											<img src="<?= base_url('assets/images/dashboard/delevier_color.svg'); ?>" class="icons" alt="dashboard icon">
											<div class="dash-txt" id="delivered_count_result">0</div>
											<span class="dash-order-text">Delivered</span>
										</div>
									</div>
								</a>
								<a href="<?= base_url('rto-intransit-Order-List'); ?>" target="_blank">
									<div class="serviceBox4">
										<div class="dash-box">
											<img src="<?= base_url('assets/images/dashboard/rto_intransis.svg'); ?>" class="icons" alt="dashboard icon">
											<div class="dash-txt" id="rto_intransit_count_result">0</div>
											<span class="dash-order-text">RTO In Transit</span>
										</div>
									</div>
								</a>
								<a href="<?= base_url('rto-delivered-Order-List'); ?>" target="_blank">
									<div class="serviceBox4">
										<div class="dash-box">
											<img src="<?= base_url('assets/images/dashboard/rto_deleive_color.svg'); ?>" class="icons" alt="dashboard icon">
											<div class="dash-txt" id="rto_delivered_count_result">0</div>
											<span class="dash-order-text">RTO Delivered</span>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				<!-- card 2  End -->
				<!-- card 3 start -->
				<div class="col-md-12  mt--14 dash-ht-110">
					<div class="card card-shadow cards_dashboard">
						<div class="card-block p-20 pt-10">
							<div class="clearfix">
								<div class="float-left">
									<div class="dash-display-flex">
										<img src="<?= base_url('assets/images/dashboard/ndr-dashboard-group-13.svg'); ?>" class="Oval" alt="dashboard icon">
										<span class="to-txt-6 dash-amount" id="all_created_order_count">0</span>
										<span class="orders-to-fullfill-txt">Orders to Fullfill</span>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- card 3 End -->
				<!-- card 4 Start -->
				<div class="col-md-12 mt--14 dash-ht-300">
					<div class="card card-shadow cards_dashboard">
						<div class="card-block p-20 pt-10">
							<div class="float-right py-10">
								<div id="cod_remittance_count" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
									<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
									<span></span> <b class="caret"></b>
								</div>
							</div>
							<div class="clearfix">

								<div class="float-left dash-mg-30">
									<img src="<?= base_url('assets/images/dashboard/cod.svg'); ?> " class="image_dash">
								</div>
								<div class="dash-mg-30">
									<div class="cod1 dash-mlt-32">
										<span class="cod-remittance-title">COD Remittance</span>
									</div>
									<div class="Cod-1 dash-display-flex">
										<a>
											<div class="cod-1 dash-pd-30">
												<span class="cod-text"><i class="fa fa-rupee-sign"></i>₹
												</span><span class="cod-text" id="remitted_amount">0</span>
												<div class="dash-order-text dash-mt">Remitted Amount</div>
											</div>
										</a>
										<div class="cod-2 dash-pd-30">
											<span class="cod-text">Coming Soon</span>
											<div class="dash-order-text dash-mt">Next Remittance</div>
										</div>
										<a>
											<div class="cod-3 dash-pd-30">
												<span class="cod-text"><i class="fas fa-rupee-sign"></i>₹
												</span><span class="cod-text" id="unremitted_amount">0</span>
												<div class="dash-order-text dash-mt">Unremitted Amount</div>
											</div>
										</a>
									</div>
									<hr class="dash-hr">
									<div class="dash-display-flex dash-mlt-32">
										<!-- <a>
                                            <div class="cod-1 dash-pd-10">
                                                <div class="dash-order-text dash-mt">Bill Due : <span
                                                        class="span-order-amount">₹ 0</span></div>
                                            </div>
                                        </a> -->
										<a>
											<div class="cod-1 dash-pd-10">
												<div class="dash-order-text dash-mt">Avg.shipping cost: <span class="span-bill-amount">₹ </span><span class="span-bill-amount" id="avg_shipping_cost">0</span></div>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- card 4 End -->
				<!-- card 6 Start -->
				<div class="col-md-12  mt--14 dash-ht-110">
					<div class="card card-shadow cards_dashboard">
						<div class="card-block p-20 pt-10">
							<div class="clearfix">
								<div class="float-left">
									<div class="dash-display-flex">
										<img src="<?= base_url('assets/images/dashboard/ndr-dashboard-group-14.svg'); ?>" class="Oval" alt="dashboard icon">
										<span class="to-txt-6 dash-amount">0</span>
										<span class="orders-to-fullfill-txt">Pending Actions</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- card 6 End -->
				<!-- card 7 Start -->
				<div class="col-md-12  mt--14 dash-ht-230">
					<div class="card card-shadow cards_dashboard">
						<div class="card-block p-20 pt-10">
							<div class="row card-7">
								<div class="col-md-4">
									<img src="<?= base_url('assets/images/dashboard/out-delivery.svg'); ?>" class="out-for-delivery-img">
								</div>
								<div class="col-md-8">
									<div class="for-delivery">
										<div class="out-delivery">
											<span class="Out-for-Delivery">Out for Delivery</span>
										</div>
										<div class="card-7-dropdown">
											<div id="ofd_count" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
												<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
												<span></span> <b class="caret"></b>
											</div>
										</div>
									</div>
									<div class="ofd">
										<div class="ofd-1">
											<span class="ofd-no-1" id="total_ofd">0</span>
											<div class="total-OFD">OFD</div>
										</div>
										<div class="ofd-1">
											<span class="ofd-no-1" id="total_delivered">0</span>
											<div class="total-OFD">Delivered </div>
										</div>
										<div class="ofd-1">
											<span class="ofd-no-1" id="total_rto">0</span>
											<div class="total-OFD">RTO</div>
										</div>
										<div class="ofd-1">
											<span class="ofd-no-1" id="total_undelivered">0</span>
											<div class="total-OFD">Undelivered</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- card 7 End -->
				<!-- card 8 start -->
				<div class="col-md-12  mt--14 dash-ht-400">
					<div class="card card-shadow cards_dashboard">
						<div class="card-block p-20 pt-10">
							<div class="card-8-main">
								<span class="Popularities-of-Prod">Daily Shipments Count</span>
								<div class="col-md-12" style="display: flex;margin-left: 30%;top: -26px;">
									<div class="col-md-4">
										<select class="form-control select2 daily_shipment_logistic" name="" id="">
											<option value="0">Select logistic</option>
											<option value="0">All</option>
											<?php if (!empty($logistics_list)) {
												foreach ($logistics_list as $value) { ?>
													<option value="<?= $value['id'] ?>">
														<?= $value['logistic_name']; ?></option>
											<?php }
											} ?>
										</select>
									</div>
									<div>
										<div id="daily_shipments_count" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
											<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
											<span></span> <b class="caret"></b>
										</div>
									</div>
								</div>
							</div>
							<div class="">
								<div id="popular-product-itl-dashboard-table_wrapper" class="dataTables_wrapper no-footer">
									<div id="popular-product-itl-dashboard-table_processing" class="dataTables_processing">
									</div>
									<div id="daily_shipment" style="display:none">
										<div class="daily_shipment_table_data table-responsive">

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- card 8 End -->
				<!-- card 9 start -->
				<!-- <div class="col-md-12  mt--14 dash-ht-400">
                    <div class="card card-shadow cards_dashboard">
                        <div class="card-block p-20 pt-10">
                            <div class="card-8">
                                <span class="Popularities-of-Prod">Popularities of Products</span>
                                <div class="col-md-12" style="display: flex; margin-left: 140%;top: -25px;">
                                    <div class="col-md-6">
                                        <select class="form-control select2 " name="" id="">
                                            <option>Select Option</option>
                                            <option>Today</option>
                                            <option>Yesterday</option>
                                            <option>Last 7 Days</option>
                                            <option>Last 30 Days</option>
                                            <option>This Month</option>
                                            <option>Last Month</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <div id="popular-product-itl-dashboard-table_wrapper"
                                    class="dataTables_wrapper no-footer">
                                    <div id="popular-product-itl-dashboard-table_processing"
                                        class="dataTables_processing" style="display: none;"></div>
                                    <table id="popular-product-itl-dashboard-table"
                                        class="pop-of-prod-table no-footer dataTable" style="overflow: hidden;"
                                        width="96%" role="grid">
                                        <thead class="pop-of-prod-table-head carrier-thead">
                                            <tr role="row">
                                                <td class="Product">Product</td>
                                                <td class="Purchased-Quantity">Purchased Quantity</td>
                                                <td class="Revenue">Revenue</td>
                                            </tr>
                                        </thead>
                                        <tbody id="popular_product_body">
                                            <tr class="odd">
                                                <td valign="top" colspan="3" class="dataTables_empty">
                                                    <div class="text-center mt-4 mb-4 pt-2 pb-2"><img
                                                            src="<?= base_url('assets/images/dashboard/search.svg'); ?>"
                                                            class="no-record-found mb-2 dash-img-not-found">
                                                        <p class="no-margin text-semibold font-16 tbody-nrf"> No
                                                            Record
                                                            Found</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
				<!-- card 9 End -->
				<!-- card 11 start -->
				<div class="col-md-12 mt--14 dash-ht-200">
					<div class="card card-shadow cards_dashboard">
						<div class="card-block">
							<div class="row">
								<div class="col-md-1">
									<div class="tcp-total-case">
										<img src="<?= base_url('assets/images/dashboard/ndr-dashboard-parcel.svg') ?>" class="parcel-copy">
									</div>
								</div>
								<div class="col-md-5">
									<div style="padding: 10px;">
										<span class="Total-Carrier-Perfor">Total Carrier Performance</span>
									</div>
								</div>
								<div class="col-md-6">
									<div style="float: right;">
										<div id="carrier_performance_count" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
											<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
											<span></span> <b class="caret"></b>
										</div>
									</div>
								</div>
							</div>
							<div id="carrier_perofrmance" style="display:none">
								<div class="carrier_perofrmance_table_data">

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 dash-ml--26">
				<!-- card 1 Start -->
				<div class="col-md-12 mt--14 dash-ht-500">
					<div class="card card-shadow cards_dashboard">
						<div class="card-block">
							<canvas id="exampleChartjsRadar" height="1000" width="1000" class="chartjs-render-monitor radar-canvas"></canvas>
						</div>
					</div>
				</div>
				<!-- card 1 End -->
				<!-- card 2 Start -->
				<div class="col-md-12 mt--14 dash-ht-500">
					<div class="card card-shadow cards_dashboard">
						<div class="card-block">
							<canvas id="exampleChartjsRadar" height="1000" width="1000" class="chartjs-render-monitor radar-canvas"></canvas>
						</div>
					</div>
				</div>
				<!-- card 2 End -->
				<!-- card 3 Start -->
				<div class="col-md-12 mt--14 dash-ht-500">
					<div class="card card-shadow cards_dashboard">
						<div class="card-block">
							<canvas id="exampleChartjsRadar" height="1000" width="1000" class="chartjs-render-monitor radar-canvas"></canvas>
						</div>
					</div>
				</div>
				<!-- card 3 End -->
			</div>
		</div>
	</div>
</div>
