<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == 'onprocessOrderList' ? 'active' : '' ?>" href="<?php echo base_url('onprocessOrderList'); ?>" aria-controls="all_tab" role="tab">On Process
		{<span><?php echo $order_count['get_onprocess_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "view-order"  ? "active" : " "; ?>" href="<?php echo base_url('view-order'); ?>" aria-controls="all_tab" role="tab">All{<span><?php echo $order_count['get_all_order_list']; ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "createdOrderList"  ? "active" : " "; ?>" href="<?php echo base_url('createdOrderList'); ?>" aria-controls="created_tab" role="tab">Created{<span><?php echo $order_count['get_created_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "ofp-Order-List"  ? "active" : " "; ?>" href="<?php echo base_url('ofp-Order-List'); ?>" aria-controls="intransit_tab" role="tab">OFP{<span><?php echo $order_count['get_ofp_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "Intransit-Order-List"  ? "active" : " "; ?>" href="<?php echo base_url('Intransit-Order-List'); ?>" aria-controls="intransit_tab" role="tab">InTransit{<span><?php echo $order_count['get_intransit_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "ofd-Order-List"  ? "active" : " "; ?>" href="<?php echo base_url('ofd-Order-List'); ?>" aria-controls="ofd_tab" role="tab">OFD{<span><?php echo $order_count['get_ofd_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "ndr-Order-List"  ? "active" : " "; ?>" href="<?php echo base_url('ndr-Order-List'); ?>" aria-controls="ndr_tab" role="tab">NDR{<span><?php echo $order_count['get_ndr_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "delivered-Order-List"  ? "active" : " "; ?>" href="<?php echo base_url('delivered-Order-List'); ?>" aria-controls="delivered_tab" role="tab">Delivered{<span><?php echo $order_count['get_delivered_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "rto-intransit-Order-List"  ? "active" : " "; ?>" href="<?php echo base_url('rto-intransit-Order-List'); ?>" aria-controls="rto_intransit_tab" role="tab">RTO
		Intransit{<span><?php echo $order_count['get_rtointransit_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "rto-delivered-Order-List"  ? "active" : " "; ?>" href="<?php echo base_url('rto-delivered-Order-List'); ?>" aria-controls="rto_delivered_tab" role="tab">RTO
		Delivered{<span><?php echo $order_count['get_rtodelivered_order_list '] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "error-order-list"  ? "active" : " "; ?>" href="<?php echo base_url('error-order-list'); ?>" aria-controls="rto_delivered_tab" role="tab">Error{<span><?php echo $order_count['get_error_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "waiting-order-list"  ? "active" : " "; ?>" href="<?php echo base_url('waiting-order-list'); ?>" aria-controls="waiting_list_order " role="tab">Waiting
		Order{<span><?php echo $order_count['get_waiting_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a class="nav-link orderList <?= $this->uri->segment(1) == "notpicked-Order-List"  ? "active" : " "; ?>" href="<?php echo base_url('notpicked-Order-List'); ?>" aria-controls="notpicked_list_order" role="tab">Not Picked{<span><?php echo $order_count['get_notpicked_order_list'] ?></span>}</a></li>
