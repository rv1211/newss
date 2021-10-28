<li class="nav-item" role="presentation"><a
        class="nav-link orderList <?= $this->uri->segment(1) == 'Pre-awb-onprocess-order-list' ?'active' :''?>"
        href="<?php echo base_url('Pre-awb-onprocess-order-list'); ?>" aria-controls="all_tab" role="tab">On Process
        {<span><?php echo $order_count['get_pre_awb_onprocess_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a
        class="nav-link orderList <?= $this->uri->segment(1) == 'Pre-awb-view-order' ?'active' :''?>"
        href="<?php echo base_url('Pre-awb-view-order');?>" aria-controls="all_tab"
        role="tab">All{<span><?php echo $order_count['get_all_pre_awb_order_list']?></span>}</a></li>
<li class="nav-item" role="presentation"><a
        class="nav-link orderList <?= $this->uri->segment(1) == 'Pre-awb-created-order-list' ?'active' :''?>"
        href="<?php echo base_url('Pre-awb-created-order-list');?>" aria-controls="created_tab"
        role="tab">Created{<span><?php echo $order_count['get_pre_awb_created_order_list']?></span>}</a></li>
<li class="nav-item" role="presentation"><a
        class="nav-link orderList <?= $this->uri->segment(1) == 'Pre-awb-Intransit-Order-List' ?'active' :''?>"
        href="<?php echo base_url('Pre-awb-Intransit-Order-List');?>" aria-controls="intransit_tab"
        role="tab">InTransit{<span><?php echo $order_count['get_pre_awb_intransit_order_list']?></span>}</a></li>
<li class="nav-item" role="presentation"><a
        class="nav-link orderList <?= $this->uri->segment(1) == 'Pre-awb-ofd-Order-List' ?'active' :''?>"
        href="<?php echo base_url('Pre-awb-ofd-Order-List');?>" aria-controls="ofd_tab"
        role="tab">OFD{<span><?php echo $order_count['get_pre_awb_ofd_order_list']?></span>}</a></li>
<li class="nav-item" role="presentation"><a
        class="nav-link orderList <?= $this->uri->segment(1) == 'Pre-awb-ndr-Order-List' ?'active' :''?>"
        href="<?php echo base_url('Pre-awb-ndr-Order-List');?>" aria-controls="ndr_tab"
        role="tab">NDR{<span><?php echo $order_count['get_pre_awb_ndr_order_list']?></span>}</a></li>
<li class="nav-item" role="presentation"><a
        class="nav-link orderList <?= $this->uri->segment(1) == 'Pre-awb-delivered-Order-List' ?'active' :''?>"
        href="<?php echo base_url('Pre-awb-delivered-Order-List');?>" aria-controls="delivered_tab"
        role="tab">Delivered{<span><?php echo $order_count['get_pre_awb_delivered_order_list']?></span>}</a></li>
<li class="nav-item" role="presentation"><a
        class="nav-link orderList <?= $this->uri->segment(1) == 'Pre-awb-rto-intransit-Order-List' ?'active' :''?>"
        href="<?php echo base_url('Pre-awb-rto-intransit-Order-List');?>" aria-controls="rto_intransit_tab"
        role="tab">RTO Intransit{<span><?php echo $order_count['get_pre_awb_rtointransit_order_list']?></span>}</a></li>
<li class="nav-item" role="presentation"><a
        class="nav-link orderList <?= $this->uri->segment(1) == 'Pre-awb-rto-delivered-Order-List' ?'active' :''?>"
        href="<?php echo base_url('Pre-awb-rto-delivered-Order-List');?>" aria-controls="rto_delivered_tab"
        role="tab">RTO Delivered{<span><?php echo $order_count['get_pre_awb_rtodelivered_order_list']?></span>}</a>
</li>
<li class="nav-item" role="presentation"><a
        class="nav-link orderList <?= $this->uri->segment(1) == 'Pre-awb-error-order-list' ?'active' :''?>"
        href="<?php echo base_url('Pre-awb-error-order-list'); ?>" aria-controls="rto_delivered_tab" role="tab">Error
        Order {<span><?php echo $order_count['get_pre_awb_error_order_list'] ?></span>}</a></li>
<li class="nav-item" role="presentation"><a
        class="nav-link orderList <?= $this->uri->segment(1) == 'Pre-awb-waiting-order-list' ?'active' :''?>"
        href="<?php echo base_url('Pre-awb-waiting-order-list'); ?>" aria-controls="rto_delivered_tab"
        role="tab">Waiting Order {<span><?php echo $order_count['get_pre_awb_waiting_order_list'] ?></span>}</a></li>