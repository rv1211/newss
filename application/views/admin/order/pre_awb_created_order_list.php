<style type="text/css">
.orderList {
    padding: 0.715rem 2.072rem;
}

.assign_label_choose_div.show {
    height: 392px !important;
    overflow-y: scroll !important;
}

.radio-btn {
    padding: 5px;
}

.radio-btn:first-child input[type=radio] {
    width: 17px;
    height: 17px;
}

.radio-btn:last-child input[type=radio] {
    transform: scale(1.5);
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
                <div class="row " style="margin-left:60%">
                    <div class="btn-group">
                        <button style="height:40px;" type="button"
                            class="btn btn-info dropdown-toggle waves-effect waves-classic" id="exampleSizingDropdown2"
                            data-toggle="dropdown" aria-expanded="false">
                            Label Option
                        </button>
                        <?php if($this->session->userdata('userType') == '1'){ ?>
                        <div class="dropdown-menu assign_label_choose_div" aria-labelledby="exampleSizingDropdown2"
                            role="menu" x-placement="top-start"
                            style="position: absolute; left: 0px; will-change: transform; transform: translate3d(0px, -204px, 0px); top: 0px;">
                            <div class="scroller" style="display:flex">
                                <div class="radio-btn">
                                    <input type="radio" name="radio_btn" checked="" value="1" data-name="first">
                                </div>

                                <div class="ifram">
                                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <iframe
                                            src="<?php echo base_url() . "uploads/sample_label_pdf/sample_1.pdf"; ?>"
                                            frameborder="0">
                                        </iframe>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="scroller" style="display:flex">
                                <div class="radio-btn">
                                    <input type="radio" name="radio_btn" value="2" data-name="second">
                                </div>

                                <div class="ifram">
                                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <iframe src="<?php echo base_url() . "uploads/sample_label_pdf/sample_2.pdf"?>"
                                            frameborder="0">
                                        </iframe>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="scroller" style="display:flex">
                                <div class="radio-btn">
                                    <input type="radio" name="radio_btn" value="3" data-name="third">
                                </div>

                                <div class="ifram">
                                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <iframe
                                            src="<?php echo base_url() . "uploads/sample_label_pdf/sample_3.pdf"; ?>"
                                            frameborder="0">
                                        </iframe>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="scroller" style="display:flex">
                                <div class="radio-btn">
                                    <input type="radio" name="radio_btn" value="4" data-name="forth">
                                </div>

                                <div class="ifram">
                                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <iframe
                                            src="<?php echo base_url() . "uploads/sample_label_pdf/sample_4.pdf"; ?>"
                                            frameborder="0">
                                        </iframe>
                                    </a>
                                </div>
                            </div>
                            <hr>
                        </div><?php }else{ ?>
                        <div class="dropdown-menu assign_label_choose_div" aria-labelledby="exampleSizingDropdown2"
                            role="menu" x-placement="top-start"
                            style="position: absolute; left: 0px; will-change: transform; transform: translate3d(0px, -5px, 0px);">
                            <?php if ($assign_labels) {
                                    foreach ($assign_labels as $key => $labels) { ?>
                            <div class="scroller" style="display:flex">
                                <div class="radio-btn">
                                    <input type="radio" name="radio_btn" <?php if ($key == '0') {
                                                                                        echo "checked";
                                                                                    } ?>
                                        value="<?php echo $labels['label_type']; ?>"
                                        data-name="<?php echo str_replace(array('1', '2', '3', '4'), array('first', 'second', 'third', 'forth'), $labels['label_type']); ?>">
                                </div>

                                <div class="ifram">
                                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <iframe
                                            src="<?php echo base_url() . "uploads/sample_label_pdf/sample_" . $labels['label_type'] . ".pdf"; ?>"
                                            frameborder="0">
                                        </iframe>
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <?php }
                                } else { ?>
                            <b>No lable found</b>
                            <?php } ?>
                        </div>
                        <?php } ?>

                    </div>
                    <div class="form-group form-material">
                        <div class="btn-group">
                            <button type="button print_btn" id="multi_print"
                                class="btn btn-primary waves-effect waves-classic"
                                style="float:right;margin-left:44px;margin-right:14px;">Multiple Print</button>
                            <button type="button print_btn" id="multi_print_manifest"
                                class="btn btn-primary waves-effect waves-classic waves-effect waves-classic">Print
                                Multiple Manifest</button>
                        </div>
                    </div>
                </div>
                <div class="row row-lg">

                    <div class="col-xl-12">
                        <!-- Example Tabs -->
                        <div class="example-wrap">
                            <div class="nav-tabs-horizontal" data-plugin="tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <!-- <li class="nav-item" role="presentation"><a class="nav-link orderList" href="<?php echo base_url('Pre-awb-onprocess-order-list'); ?>" aria-controls="all_tab" role="tab">On Process {<span><?php echo $order_count['get_pre_awb_onprocess_order_list'] ?></span>}</a></li> -->
                                    <!-- <li class="nav-item" role="presentation"><a class="nav-link orderList" href="<?php echo base_url('Pre-awb-view-order');?>" aria-controls="all_tab" role="tab">All{<span><?php echo $order_count['get_all_pre_awb_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList active"  href="<?php echo base_url('Pre-awb-created-order-list');?>" aria-controls="created_tab" role="tab">Created{<span><?php echo $order_count['get_pre_awb_created_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList"  href="<?php echo base_url('Pre-awb-Intransit-Order-List');?>" aria-controls="intransit_tab" role="tab">InTransit{<span><?php echo $order_count['get_pre_awb_intransit_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList"  href="<?php echo base_url('Pre-awb-ofd-Order-List');?>" aria-controls="ofd_tab" role="tab">OFD{<span><?php echo $order_count['get_pre_awb_ofd_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList"  href="<?php echo base_url('Pre-awb-ndr-Order-List');?>" aria-controls="ndr_tab" role="tab">NDR{<span><?php echo $order_count['get_pre_awb_ndr_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList"  href="<?php echo base_url('Pre-awb-delivered-Order-List');?>" aria-controls="delivered_tab" role="tab">Delivered{<span><?php echo $order_count['get_pre_awb_delivered_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList"  href="<?php echo base_url('Pre-awb-rto-intransit-Order-List');?>" aria-controls="rto_intransit_tab" role="tab">RTO Intransit{<span><?php echo $order_count['get_pre_awb_rtointransit_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList" href="<?php echo base_url('Pre-awb-rto-delivered-Order-List');?>" aria-controls="rto_delivered_tab" role="tab">RTO Delivered{<span><?php echo $order_count['get_pre_awb_rtodelivered_order_list']?></span>}</a></li>
                      <li class="nav-item" role="presentation"><a class="nav-link orderList" href="<?php echo base_url('Pre-awb-error-order-list'); ?>" aria-controls="rto_delivered_tab" role="tab">Error Order {<span><?php echo $order_count['get_pre_awb_error_order_list'] ?></span>}</a></li> -->
                                    <?php require APPPATH.'views/admin/order/pre_awb_order_tab.php';?>

                                </ul>
                                <div class="tab-content pt-20">

                                    <div class="tab-pane active" id="created_tab" role="tabpanel">
                                        <table class="table table-striped table-borderd" id="preawb_createorder_list">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="all_manifested_order"
                                                            id="select_all" name="select_all" value="1"></th>
                                                    <th>Order ID</th>
                                                    <th>Order Number</th>
                                                    <th>Airwaybill Number</th>
                                                    <th>Logistic Name</th>
                                                    <th>Customer Name</th>
                                                    <th>Customer Number</th>
                                                    <th>Order Type</th>
                                                    <th>Create Date</th>
                                                    <th>Last Status Date</th>
                                                    <th>Last Remarks</th>
                                                    <th>Order Status</th>
                                                    <?php if($this->session->userdata('userType') == '1'){ ?>
                                                    <th>User</th>
                                                    <?php }?>
                                                    <th>Print label</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Example Tabs -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Panel Basic -->
    </div>
</div>
<!-- End Page -->