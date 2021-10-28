<style type="text/css">
.orderList {
    padding: 0.715rem 2.072rem;
}

.all_orders_export {
    top: -42px !important;
    margin-left: 183px !important;
    margin-bottom: -20px !important;
}

#order_table_filter {
    margin-top: -60px !important;
}

/* .export_btn_order_table {
    left: 380%;
    height: 40px;
    margin-top: -163px;
} */
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
                <div class="row row-lg" style="margin-top: 40px;">
                    <div class="form-group form-material">
                        
                    </div>
                    <div class="col-xl-12">

                        <!-- Example Tabs -->
                        <div class="example-wrap">
                            <div class="nav-tabs-horizontal" data-plugin="tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php require APPPATH.'views/admin/order/tab_list.php';?>
                                </ul>
                                <div class="tab-content pt-20">
                                    <div class="tab-pane active" id="all_tab" role="tabpanel">
                                        <table class="table table-striped table-borderd" id="order_table">
                                            <thead>
                                                <tr>
                                                    <th class="noExport"><input type="checkbox" class="all_manifested_order"
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
                                                        <th>Intransit Days count</th>
                                                        <th>User</th>
                                                    <?php } ?>
                                                    <th class="noExport">Order Tracking</th>

                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- End Page -->
<div class="modal fade modal-fade-in-scale-up" id="myModal" role="dialog">
    <div class="modal-dialog modal-simple modal-lg">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>