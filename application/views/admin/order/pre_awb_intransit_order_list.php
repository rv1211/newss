<style type="text/css">
.orderList {
    padding: 0.715rem 2.072rem;
}

.order_nav {
    padding: -6.285rem 12.072rem;
}

b {
    font-weight: 1000;
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
                <div class="row row-lg">
                    <div class="form-group form-material">
                        <!-- <div class="btn-group">
                    <button type="button print_btn" id="multi_print_manifest" class="btn btn-primary waves-effect waves-classic waves-effect waves-classic" style="float:right;margin-left:900px;">Print Multiple Manifest</button>
                  </div> -->
                    </div>
                    <div class="col-xl-12">
                        <!-- Example Tabs -->
                        <div class="example-wrap">
                            <div class="nav-tabs-horizontal" data-plugin="tabs">
                                <ul class="nav nav-tabs" role="tablist">

                                    <?php require APPPATH.'views/admin/order/pre_awb_order_tab.php';?>

                                </ul>
                                <div class="tab-content pt-20">

                                    <div class="tab-pane active" id="intransit_tab" role="tabpanel">
                                        <table class="table table-striped table-borderd" id="pre_awb_order_intransit">
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
                                                    <?php if ($this->session->userdata('userType') == '1') { ?>
                                                    <th>User</th>
                                                    <?php } ?>
                                                    <th>Action</th>
                                                    <th>Order Tracking</th>
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

<!-- start model -->
<div class="modal fade modal-fade-in-scale-up" id="myModal" role="dialog">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>

    </div>
</div>
<!-- End model -->