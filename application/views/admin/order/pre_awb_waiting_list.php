<style type="text/css">
.orderList {
    padding: 0.715rem 2.072rem;
}
</style>

<div class="page">
    <div class="page-header">
        <h1 class="page-title">Orders</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Orders</li>
        </ol>
    </div>
    <div class="page-content ">
        <!-- Panel Basic -->
        <div class="panel">
            <div class="panel-body container-fluid">
                <!-- <div class="row">
          <div class="col-md-12">
            <button type="button" id="print_shipment_manifest" class="btn btn-info print_shipment_manifest" autocomplete="off">Print Manifest</button><br><br>
          </div>
        </div> -->
                <div class="row row-lg">
                    <div class="col-xl-12">

            <!-- Example Tabs -->
            <div class="example-wrap">
              <div class="nav-tabs-horizontal" data-plugin="tabs">
                <ul class="nav nav-tabs" role="tablist">
                      <!-- <li class="nav-item" role="presentation"><a class="nav-link orderList" href="<?php echo base_url('Pre-awb-onprocess-order-list'); ?>" aria-controls="all_tab" role="tab">On Process {<span><?php echo $order_count['get_pre_awb_onprocess_order_list'] ?></span>}</a></li> -->
                      <!-- <li class="nav-item" role="presentation"><a class="nav-link orderList" href="<?php echo base_url('Pre-awb-view-order');?>" aria-controls="all_tab" role="tab">All{<span><?php echo $order_count['get_all_pre_awb_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList"  href="<?php echo base_url('Pre-awb-created-order-list');?>" aria-controls="created_tab" role="tab">Created{<span><?php echo $order_count['get_pre_awb_created_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList"  href="<?php echo base_url('Pre-awb-Intransit-Order-List');?>" aria-controls="intransit_tab" role="tab">InTransit{<span><?php echo $order_count['get_pre_awb_intransit_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList"  href="<?php echo base_url('Pre-awb-ofd-Order-List');?>" aria-controls="ofd_tab" role="tab">OFD{<span><?php echo $order_count['get_pre_awb_ofd_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList"  href="<?php echo base_url('Pre-awb-ndr-Order-List');?>" aria-controls="ndr_tab" role="tab">NDR{<span><?php echo $order_count['get_pre_awb_ndr_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList"  href="<?php echo base_url('Pre-awb-delivered-Order-List');?>" aria-controls="delivered_tab" role="tab">Delivered{<span><?php echo $order_count['get_pre_awb_delivered_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList "  href="<?php echo base_url('Pre-awb-rto-intransit-Order-List');?>" aria-controls="rto_intransit_tab" role="tab">RTO Intransit{<span><?php echo $order_count['get_pre_awb_rtointransit_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList" href="<?php echo base_url('Pre-awb-rto-delivered-Order-List');?>" aria-controls="rto_delivered_tab" role="tab">RTO Delivered{<span><?php echo $order_count['get_pre_awb_rtodelivered_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList active" href="<?php echo base_url('Pre-awb-error-order-list'); ?>" aria-controls="rto_delivered_tab" role="tab">Error Order {<span><?php echo $order_count['get_pre_awb_error_order_list'] ?></span>}</a></li> -->
                      <?php require APPPATH.'views/admin/order/pre_awb_order_tab.php';?>
                </ul>
                <div class="tab-content pt-20">
                  <div class="tab-pane active" id="all_tab" role="tabpanel">
                    <table class="table table-striped table-borderd" id="pre_awb_waiting_order_table">
                      <thead>
                        <tr>
                          <th><input type="checkbox" class="all_manifested_order" id="select_all" name="select_all" value="1"></th>
                                  <th>Order ID</th>
                                  <th>Order Number</th>
                                  <th>Airwaybill Number</th>
                                  <th>Logistic Name</th>
                                  <th>Customer Name</th>
                                  <th>Customer Number</th>
                                  <th>Order Type</th>
                                  <th>Create Date</th>
                                  <th>Remarks</th>
                                  <?php if($this->session->userdata('userType') == '1'){ ?>
                                    <th>User</th>
                                  <?php }?>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                </div>
                <!-- End Page -->