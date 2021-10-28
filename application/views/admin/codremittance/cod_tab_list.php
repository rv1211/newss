<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == 'cod-remittance' ? 'active' : '' ?>" href="<?php echo base_url('cod-remittance'); ?>" aria-controls="all_tab" role="tab">Remittance
	</a>
</li>
<!-- <li class="nav-item" role="presentation"><a class="nav-link orderList <?php  //echo  $this->uri->segment(1) == 'cod-shipping-charges' ? 'active' : '' 
																			?>" href="<?php  // echo base_url('cod-shipping-charges'); 
																						?>" aria-controls="all_tab" role="tab">Shipping Charges
    </a>
</li> -->
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == 'cod-wallet-transactions' ? 'active' : '' ?>" href="<?php echo base_url('cod-wallet-transactions'); ?>" aria-controls="all_tab" role="tab">Wallet Transactions
	</a>
</li>
<!-- <li class="nav-item" role="presentation"><a class="nav-link orderList <?php  // echo  $this->uri->segment(1) == 'cod-bill-summary' ? 'active' : '' 
																			?>" href="<?php echo base_url('cod-bill-summary'); ?>" aria-controls="all_tab" role="tab">Bill Summary
    </a>
</li> -->
<!-- <li class="nav-item" role="presentation"><a
        class="nav-link orderList <?php //echo $this->uri->segment(1) == 'cod-credit-receipt' ?'active' :''
									?>"
        href="<?php //echo base_url('cod-credit-receipt'); 
				?>" aria-controls="all_tab" role="tab">Credit Receipt
    </a>
</li> -->
