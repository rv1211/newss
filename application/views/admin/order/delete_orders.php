<style type="text/css">
    .orderList {
        padding: 0.715rem 2.072rem;
    }

    .print_btn {
        margin-right: 15px;
    }
</style>
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Delete Orders</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Delete Orders</li>
        </ol>
    </div>
    <div class="page-content ">
        <!-- Panel Basic -->
        <div class="panel">
            <div class="panel-body container-fluid">
                <div class="row " style="margin-left:60%">
                    <div class="form-group form-material">
                        <div class="btn-group">
                            <button type="button print_btn" id="export_delete_orders" class="btn btn-primary waves-effect waves-classic" style="float:right;margin-left:44px;margin-right:14px;" disabled="true">Export
                                Orders</button>
                            <button type="button print_btn" id="delete_orders" class="btn btn-primary waves-effect waves-classic waves-effect waves-classic" disabled="true">Delete
                                Orders</button>

                            &nbsp;
                            <a type="button print_btn" href="<?php echo  base_url('refund_all_orders/');  ?>" class="btn btn-primary waves-effect waves-classic waves-effect waves-classic">
                                Refund All Orders</a>
                        </div>
                    </div>
                </div>

                <div class="row row-lg">
                    <div class="col-xl-12">
                        <!-- Example Tabs -->
                        <div class="example-wrap">
                            <div class="nav-tabs-horizontal" data-plugin="tabs">
                                <div class="tab-content pt-20">
                                    <div class="tab-pane active" id="created_tab" role="tabpanel">
                                        <table class="table table-striped table-borderd delete-order-table" id="delete_order_table">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="select-all-delete-order" id="" name="select_all" value="1"></th>
                                                    <th>Order Number</th>
                                                    <th>Airwaybill Number</th>
                                                    <th>API Name</th>
                                                    <th>Customer Name</th>
                                                    <th>Customer Email</th>
                                                    <th>Customer Number</th>
                                                    <th>Order Type</th>
                                                    <th>Processing Date</th>
                                                    <th>Payment Status</th>
                                                    <th>User</th>
                                                    <th>Refund</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($order_details)) {
                                                    foreach ($order_details as $row) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php if ($row['is_refund'] == 1 || $row['type'] == 1) : ?>
                                                                    <input type="checkbox" class="select-single-delete-order" id="" name="checkbox_delete_order" data-type="<?= $row['type']; ?>" data-id="<?= $row['order_no']; ?>">
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= $row['order_no']; ?></td>
                                                            <td><?= $row['awb_number']; ?></td>
                                                            <td><?= $row['apiname']; ?></td>
                                                            <td><?= $row['name']; ?></td>
                                                            <td><?= $row['email']; ?></td>
                                                            <td><?= $row['mobile_no']; ?></td>
                                                            <td><?php if ($row['order_type'] == '1') {
                                                                    echo 'COD';
                                                                } else {
                                                                    echo 'PREPAID';
                                                                }; ?></td>
                                                            <td><?= $row['updated_date']; ?></td>
                                                            <td><?= $row['paid_amount']; ?></td>
                                                            <td><?= $row['user']; ?></td>
                                                            <td>
                                                                <?php if ($row['is_refund'] == 0 && $row['type'] == 0) : ?>
                                                                    <a class='btn btn-info' href='<?php echo  base_url('refund-created-order/' . $row['id']);  ?>'>Refund</a>
                                                                <?php endif; ?>
                                                            </td>

                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <span>No Orders Found </span> <?php } ?>
                                            </tbody>
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