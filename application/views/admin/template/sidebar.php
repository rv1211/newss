<?php
$currentUrl = $_SERVER['REQUEST_URI'];
$page = basename($currentUrl);
// dd($_SESSION);
?>

<div class="site-menubar">
	<div class="site-menubar-body">
		<div>
			<div>
				<ul class="site-menu" data-plugin="menu">
					<li class="site-menu-item zoomin frame<?= $page == 'dashboard' ? 'active' : ''; ?>">
						<a class="animsition-link" href="<?= base_url('dashboard-new'); ?>">
							<img src="<?= base_url('assets/images/sidebar/dashboard.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon">

							<!-- <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i> -->
							<span class="site-menu-title">Dashboard</span>
						</a>
					</li>
					<?php if ($this->session->userdata('userAllow') == '') { ?>
						<!-- start Single create order -->
						<li class="site-menu-item has-sub zoomin frame <?= ($page == 'create-single-order' || $page == 'view-order' || $page == 'bulk-order' || $page == 'delete-order' || $page == 'onprocessOrderList' || $page == 'createdOrderList' || $page == 'Intransit-Order-List' || $page == 'ofd-Order-List' || $page == 'ndr-Order-List' || $page == 'rto-intransit-Order-List' || $page == 'delivered-Order-List' || $page == 'rto-delivered-Order-List' || $page == 'error-order-list' || $page == 'waiting-order-list') ? 'active' : ''; ?>">
							<a href="javascript:void(0)">
								<img src="<?= base_url('assets/images/sidebar/order1.svg'); ?>" class="site-menu-icon-side btn6" alt="dashboard icon">

								<!-- <i class="site-menu-icon icon fa-cart-plus" aria-hidden="true"></i> -->
								<span class="site-menu-title">Order</span>
							</a>
							<ul class="site-menu-sub">
								<li class="site-menu-item <?= ($page == 'view-order' || $page == 'onprocessOrderList' || $page == 'createdOrderList' || $page == 'Intransit-Order-List' || $page == 'ofd-Order-List' || $page == 'ndr-Order-List' || $page == 'rto-intransit-Order-List' || $page == 'delivered-Order-List' || $page == 'rto-delivered-Order-List' || $page == 'error-order-list' || $page == 'waiting-order-list') ? 'active' : ''; ?>">
									<a class="animsition-link" href="<?= base_url('createdOrderList'); ?>">
										<span class="site-menu-title">View Order</span>
									</a>
								</li>
								<?php if ($this->session->userdata('userType') == '4') { ?>
									<li class="site-menu-item <?= $page == 'create-single-order' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('create-single-order') ?>">
											<span class="site-menu-title">Create Order</span>
										</a>
									</li>

									<li class="site-menu-item <?= $page == 'bulk-order' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('bulk-order') ?>">
											<span class="site-menu-title">Create bulk orders</span>
										</a>
									</li>
									<?php
									// dd($_SESSION);
									if ($this->session->userdata('is_preawb_allow') == '1') {
									?>
										<li class="site-menu-item">
											<a class="animsition-link" href="<?= base_url('create-single-order-awbno') ?>">
												<span class="site-menu-title">Pre AWB single</span>
											</a>
										</li>
										<li class="site-menu-item">
											<a class="animsition-link" href="<?= base_url('pre-bulk-order-awb') ?>">
												<span class="site-menu-title">Pre AWB bulk</span>
											</a>
										</li>
									<?php } ?>
								<?php }
								if ($this->session->userdata('userType') == '1' || $this->session->userdata('userType') == '2' || $this->session->userdata('userType') == '3') { ?>
									<li class="site-menu-item <?= $page == 'delete-order' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('delete-order') ?>">
											<span class="site-menu-title">Delete orders</span>
										</a>
									</li>
								<?php } ?>
							</ul>
						</li>
					<?php } ?>
					<?php if ($this->session->userdata('userType') == '1' || $this->session->userdata('userType') == '2') {

					?>
						<li class="site-menu-item has-sub zoomin frame <?= ($page == 'customer-list' || $page == 'customer-api-setting' || $page == 'kyc-pending-customer' || $page == 'approve-customer' || $page == 'rejected-customer' || $page == 'manage-user') ? 'active' : ''; ?>">
							<a href="javascript:void(0)">
								<img src="<?= base_url('assets/images/sidebar/subscriber.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon">

								<!-- <i class="site-menu-icon icon fa-users" aria-hidden="true"></i> -->
								<span class="site-menu-title">Customers </span>
							</a>
							<ul class="site-menu-sub">
								<li class="site-menu-item <?= $page == 'customer-list' ? 'active' : ''; ?>">
									<a class="animsition-link" href="<?= base_url('customer-list') ?>">
										<span class="site-menu-title">Customer List</span>
									</a>
								</li>
								<?php if ($this->session->userdata('userType') == '1') : ?>
									<li class="site-menu-item <?= $page == 'kyc-pending-customer' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('kyc-pending-customer') ?>">
											<span class="site-menu-title">Pending Customer</span>
										</a>
									</li>
									<li class="site-menu-item <?= $page == 'approve-customer' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('approve-customer'); ?>">
											<span class="site-menu-title">Approve Customer</span>
										</a>
									</li>
									<li class="site-menu-item <?= $page == 'rejected-customer' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('rejected-customer'); ?>">
											<span class="site-menu-title">Rejected Customer</span>
										</a>
									</li>
									<li class="site-menu-item <?= $page == 'manage-user' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('manage-user'); ?>">
											<span class="site-menu-title">Manage User</span>
										</a>
									</li>
									<li class="site-menu-item <?= $page == 'customer-api-setting' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('customer-api-setting') ?>">
											<span class="site-menu-title">Api Setting</span>
										</a>
									</li>
								<?php endif; ?>
								<!-- <li class="site-menu-item <?= $page == 'customer-pre-awb' ? 'active' : ''; ?>">
									<a class="animsition-link" href="<?= base_url('customer-pre-awb') ?>">
										<span class="site-menu-title">Pre Awb dashboard </span>
									</a>
								</li> -->
							</ul>
						</li>
						<li class="site-menu-item has-sub zoomin frame <?= ($page == 'customer-allow-credit' || $page == 'user-wallet-balance' || $page == 'customer-used-credit') ? 'active' : ''; ?> ">
							<a href="javascript:void(0)">
								<img src="<?= base_url('assets/images/sidebar/finance.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon">

								<!-- <i class="site-menu-icon fas fa-credit-card" aria-hidden="true"></i> -->
								<span class="site-menu-title">Settings</span>
							</a>

							<ul class="site-menu-sub">
								<?php if ($this->session->userdata('userType') == '1') : ?>
									<li class="site-menu-item <?= $page == 'customer-allow-credit' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('customer-allow-credit') ?>">
											<span class="site-menu-title">Allow credit</span>
										</a>
									</li>
								<?php endif; ?>
								<li class="site-menu-item <?= $page == 'user-wallet-balance' ? 'active' : ''; ?>">
									<a class="animsition-link" href="<?= base_url('user-wallet-balance') ?>">
										<span class="site-menu-title">User wallet</span>
									</a>
								</li>
								<li class="site-menu-item <?= $page == 'customer-used-credit' ? 'active' : ''; ?>">
									<a class="animsition-link" href="<?= base_url('customer-used-credit') ?>">
										<span class="site-menu-title">Customer Used Credit</span>
									</a>
								</li>
							</ul>
						</li>
						<?php if ($this->session->userdata('userType') == '1') : ?>
							<li class="site-menu-item has-sub zoomin frame <?= ($page == 'import-pincode' || $page == 'airway-bill' || $page ==    'import-ndr-report') || $page == 'generate-pincode-ecom' || $page == 'generate-awb' || $page == 'genrate-awb-xpress' || $page == 'assign_airwaybill' || $page == 'add-rule' ? 'active' : ''; ?>">
								<a href="javascript:void(0)" class=" waves-effect waves-classic"><img src="<?= base_url('assets/images/sidebar/hero.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon" style="font-width:50px;">
									<span class="site-menu-title"> Awb & Rule </span>
								</a>
								<ul class="site-menu-sub">
									<li class="site-menu-item has-sub <?= ($page == 'import-pincode' || $page == 'airway-bill' || $page == 'import-ndr-report') || $page == 'generate-pincode-ecom' ? 'active' : ''; ?>">
										<a href="javascript:void(0)" class=" waves-effect waves-classic">
											<span class="site-menu-title">Import</span>
											<span class="site-menu-arrow"></span>
										</a>
										<ul class="site-menu-sub">
											<li class="site-menu-item">
												<a class="animsition-link waves-effect waves-classic" href="<?= base_url('import-pincode'); ?>">
													<span class="site-menu-title">Pincode Import</span>
												</a>
											</li>
											<li class="site-menu-item">
												<a class="animsition-link waves-effect waves-classic" href="<?= base_url('airway-bill'); ?>">
													<span class="site-menu-title">Import Airwaybill</span>
												</a>
											</li>
											<li class="site-menu-item">
												<a class="animsition-link waves-effect waves-classic" href="<?= base_url('weight-missmatch'); ?>">
													<span class="site-menu-title">Import WeightMissmatch</span>
												</a>
											</li>
											<li class="site-menu-item">
												<a class="animsition-link waves-effect waves-classic" href="<?= base_url('weight-missmatch-list'); ?>">
													<span class="site-menu-title">WeightMissmatch List</span>
												</a>
											</li>
											<li class="site-menu-item">
												<a class="animsition-link waves-effect waves-classic" href="<?= base_url('generate-pincode-ecom'); ?>">
													<span class="site-menu-title">Generate Ecom Pincode</span>
												</a>
											</li>

										</ul>
									</li>
									<li class="site-menu-item has-sub <?= ($page == 'generate-awb' || $page == 'genrate-awb-xpress' || $page == 'assign_airwaybill' ? 'active' : ''); ?>">
										<a href="javascript:void(0)" class=" waves-effect waves-classic">
											<span class="site-menu-title">AWB</span>
											<span class="site-menu-arrow"></span>
										</a>
										<ul class="site-menu-sub">
											<li class="site-menu-item">
												<a class="animsition-link waves-effect waves-classic" href="<?= base_url('generate-awb'); ?>">
													<span class="site-menu-title">Zship AWB</span>
												</a>
											</li>
											<li class="site-menu-item">
												<a class="animsition-link waves-effect waves-classic" href="<?= base_url('udaan-generate-awb'); ?>">
													<span class="site-menu-title">Udaan AWB</span>
												</a>
											</li>
											<li class="site-menu-item">
												<a class="animsition-link waves-effect waves-classic" href="<?= base_url('genrate-awb-xpress'); ?>">
													<span class="site-menu-title">Xpress AWB</span>
												</a>
											</li>
											<li class="site-menu-item">
												<a class="animsition-link waves-effect waves-classic" href="<?= base_url('genrate-awb-xpressair'); ?>">
													<span class="site-menu-title">XpressAIR AWB</span>
												</a>
											</li>
											<li class="site-menu-item">
												<a class="animsition-link waves-effect waves-classic" href="<?= base_url('ecom-generate-awb'); ?>">
													<span class="site-menu-title">Ecom AWB</span>
												</a>
											</li>
											<li class="site-menu-item">
												<a class="animsition-link waves-effect waves-classic" href="<?= base_url('assign_airwaybill'); ?>">
													<span class="site-menu-title">Assign Airwaybill</span>
												</a>
											</li>

										</ul>
									</li>
									<li class="site-menu-item <?= ($page == 'add-rule' ? 'active' : ''); ?>">
										<a class="animsition-link" href="<?= base_url('manage-logistic/add-rule') ?>">
											<span class="site-menu-title">Add Rule</span>
										</a>
									</li>
								</ul>
							</li>
							<li class="site-menu-item has-sub zoomin frame <?= ($page == 'manage-logistic' || $page == 'shipping-price' || $page == 'manage-price' || $page == 'manage-metrocity') ? 'active' : ''; ?>">
								<a href="javascript:void(0)">
									<img src="<?= base_url('assets/images/sidebar/price.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon">

									<!-- <i class="site-menu-icon fa-cogs" aria-hidden="true"></i> -->
									<span class="site-menu-title">Shipping Price</span>
								</a>
								<ul class="site-menu-sub">
									<li class="site-menu-item <?= $page == 'manage-logistic' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('manage-logistic') ?>">
											<span class="site-menu-title">Logistics</span>
										</a>
									</li>
									<li class="site-menu-item <?= $page == 'shipping-price' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('shipping-price') ?>">
											<span class="site-menu-title">Shipping Price</span>
										</a>
									</li>
									<li class="site-menu-item <?= $page == 'manage-price' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('manage-price') ?>">
											<span class="site-menu-title">Manage Price</span>
										</a>
									</li>
									<li class="site-menu-item <?= $page == 'manage-metrocity' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('manage-metrocity'); ?>">
											<span class="site-menu-title">Metrocity</span>
										</a>
									</li>
								</ul>

							</li>
						<?php endif; ?>
					<?php } ?>
					<li class="site-menu-item zoomin frame <?= $page == 'pickup-address' ? 'active' : ''; ?>">
						<a class="animsition-link" href="<?= base_url('pickup-address') ?>">
							<img src="<?= base_url('assets/images/sidebar/pickup-address.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon">
							<!-- <i class="site-menu-icon icon fa-map-marker" aria-hidden="true"></i> -->
							<span class="site-menu-title">Pickup Address</span>
						</a>
					</li>
					<?php if ($this->session->userdata('userType') == '1') { ?>
						<li class="site-menu-item zoomin frame <?= $page == 'assign-lable' ? 'active' : ''; ?>">
							<a class="animsition-link" href="<?= base_url('assign-lable'); ?>">
								<img src="<?= base_url('assets/images/sidebar/labels.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon">
								<!-- <i class="site-menu-icon md-view-dashboard" aria-hidden="true"></i> -->
								<span class="site-menu-title">Packing Slip</span>
							</a>
						</li>
						<!-- End assign AWB -->
					<?php } ?>
					<?php if (($this->session->userdata('userType') == '4') && ($this->session->userdata('userAllow') == '')) { ?>
						<!-- start logistic priority -->
						<li class="site-menu-item zoomin frame <?= $page == 'logistic-priority' ? 'active' : ''; ?>">
							<a class="animsition-link" href="<?= base_url('logistic-priority'); ?>">
								<i class="site-menu-icon icon fa-list-ul" aria-hidden="true"></i>
								<span class="site-menu-title">Logistic Priority</span>
							</a>
						</li>
						<!-- start logistic priority -->
					<?php } ?>
					<!-- start logistic priority -->
					<li class="site-menu-item has-sub zoomin frame <?= $page == 'daily-booking-report' ? 'active' : ''; ?>">
						<a href="javascript:void(0)">
							<img src="<?= base_url('assets/images/sidebar/reports.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon">
							<span class="site-menu-title">Reports</span>
						</a>
						<ul class="site-menu-sub">
							<?php if (($this->session->userdata('userType') == '1') && ($this->session->userdata('userAllow') == '')) { ?>
								<li class="site-menu-item <?= $page == 'daily-booking-report' ? 'active' : ''; ?>">
									<a class="animsition-link" href="<?= base_url('daily-booking-report') ?>">
										<span class="site-menu-title">Daily Booking</span>
									</a>
								</li>
							<?php } ?>
							<li class="site-menu-item <?= $page == 'intransit-booking-report' ? 'active' : ''; ?>">
								<a class="animsition-link" href="<?= base_url('intransit-booking-report') ?>">
									<span class="site-menu-title">InTransit Booking</span>
								</a>
							</li>
							<li class="site-menu-item <?= $page == 'delivery-booking-report' ? 'active' : ''; ?>">
								<a class="animsition-link" href="<?= base_url('delivery-booking-report') ?>">
									<span class="site-menu-title">Delivery Booking</span>
								</a>
							</li>
							<li class="site-menu-item <?= $page == 'rto-booking-report' ? 'active' : ''; ?>">
								<a class="animsition-link" href="<?= base_url('rto-booking-report') ?>">
									<span class="site-menu-title">RTO Booking</span>
								</a>
							</li>
							<li class="site-menu-item <?= $page == 'cod-booking-report' ? 'active' : ''; ?>">
								<a class="animsition-link" href="<?= base_url('cod-booking-report') ?>">
									<span class="site-menu-title">COD Booking</span>
								</a>
							</li>
							<li class="site-menu-item <?= $page == 'all-booking-report' ? 'active' : ''; ?>">
								<a class="animsition-link" href="<?= base_url('all-booking-report') ?>">
									<span class="site-menu-title">ALL Booking</span>
								</a>
							</li>
							<li class="site-menu-item <?= $page == 'ndr -booking-report' ? 'active' : ''; ?>">
								<a class="animsition-link" href="<?= base_url('ndr-booking-report') ?>">
									<span class="site-menu-title">NDR Booking</span>
								</a>
							</li>
							<!-- <li class="site-menu-item <?= $page == 'invoice' ? 'active' : ''; ?>">
								<a class="animsition-link" href="<?= base_url('invoice') ?>">
									<span class="site-menu-title">Invoice</span>
								</a>
							</li> -->
						</ul>
					</li>
					<?php if ((($this->session->userdata('userType') == '1') || ($this->session->userdata('userType') == 4)) && ($this->session->userdata('userAllow') == '')) { ?>
						<li class="site-menu-item has-sub zoomin frame <?= ($page == 'cod-remittance-list' || $page == 'all-cod-remittance-list') ? 'active' : ''; ?>">
							<a href="javascript:void(0)">
								<img src="<?= base_url('assets/images/sidebar/cod.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon">
								<span class="site-menu-title">COD Remittance</span>
							</a>
							<ul class="site-menu-sub">
								<?php if ($this->session->userdata('userType') == '1') : ?>
									<li class="site-menu-item <?= $page == 'cod-remittance-list' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('cod-remittance-list') ?>">
											<span class="site-menu-title">Remittance</span>
										</a>
									</li>
									<li class="site-menu-item <?= $page == 'all-cod-remittance-list' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?= base_url('all-cod-remittance-list') ?>">
											<span class="site-menu-title">All Cod Remittance List</span>
										</a>
									</li>
								<?php endif; ?>
								<li class="site-menu-item has-sub <?= ($page == 'cod-remittance' || $page == 'cod-shipping-charges' || $page == 'cod-wallet-transactions') || $page == 'cod-bill-summary' ? 'active' : ''; ?>">
									<a href="javascript:void(0)" class=" waves-effect waves-classic">
										<span class="site-menu-title">Cod</span>
										<span class="site-menu-arrow"></span>
									</a>
									<ul class="site-menu-sub">
										<li class="site-menu-item">
											<a class="animsition-link waves-effect waves-classic" href="<?= base_url('cod-remittance'); ?>">
												<span class="site-menu-title">Cod Remittance</span>
											</a>
										</li>
										<!-- <li class="site-menu-item">
											<a class="animsition-link waves-effect waves-classic" href="<?= base_url('cod-shipping-charges'); ?>">
												<span class="site-menu-title">Shipping Charges</span>
											</a>
										</li> -->
										<li class="site-menu-item">
											<a class="animsition-link waves-effect waves-classic" href="<?= base_url('cod-wallet-transactions'); ?>">
												<span class="site-menu-title">Wallet Transactions</span>
											</a>
										</li>
										<!-- <li class="site-menu-item">
											<a class="animsition-link waves-effect waves-classic" href="<?= base_url('cod-bill-summary'); ?>">
												<span class="site-menu-title">Bill Summary</span>
											</a>
										</li> -->
									</ul>
								</li>
								<?php if ($this->session->userdata('userType') == '1') : ?>
									<li class="site-menu-item <?php echo $page == 'next-cod-remittance-list' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?php echo base_url('next-cod-remittance-list') ?>">
											<span class="site-menu-title">Next Cod Remittance</span>
										</a>
									</li>
									<li class="site-menu-item <?php echo $page == 'next-cod-remittance-all-data' ? 'active' : ''; ?>">
										<a class="animsition-link" href="<?php echo base_url('next-cod-remittance-all-data') ?>">
											<span class="site-menu-title">Next Cod Remittance List</span>
										</a>
									</li>
								<?php endif; ?>

							</ul>
						</li>
					<?php } ?>
					<li class="site-menu-item zoomin frame <?php echo $page == 'plan' ? 'active' : ''; ?>">
						<a class="animsition-link" href="<?php echo base_url('plan'); ?>" target="_blank">
							<img src="<?= base_url('assets/images/sidebar/e-way-bill.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon">
							<span class="site-menu-title">Plan <br /></span>
						</a>
					</li>
					<li class="site-menu-item zoomin frame <?php echo $page == 'pincode-serviceability' ? 'active' : ''; ?>">
						<a class="animsition-link" href="<?php echo base_url('pincode-serviceability'); ?>">
							<img src="<?= base_url('assets/images/sidebar/location.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon">
							<span class="site-menu-title">Pincode <br /></span>
						</a>
					</li>
					<li class="site-menu-item zoomin frame <?php echo $page == 'rate-calculator' ? 'active' : ''; ?>">
						<a class="animsition-link" href="<?php echo base_url('rate-calculator'); ?>">
							<img src="<?= base_url('assets/images/sidebar/wallet.svg'); ?>" class="site-menu-icon-side" alt="dashboard icon">
							<span class="site-menu-title">Rate Calculator<br /></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>