<div class="page">
    <div class="page-header">
        <h4 class="page-title">Pre AWB Bulk order</h4>
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <h3 class="panel-title">
                        Pre Awb Bulk Order
                    </h3>
                </header>
                <div class="panel-body">
                    <p>
                        <!--  -->
                    </p>
                    <span id="message"></span>
                    <!-- <form class="form-horizontal fv-form fv-form-bootstrap4"  id="create_bulk_order" name="create_bulk_order"  action="<?php //echo base_url('insert_airway_bill'); 
                                                                                                                                            ?>" method="POST" enctype="multipart/form-data" autocomplete="off" novalidate="novalidate"> -->
                    <form id="pre_bulk_order" method="POST" name="pre_bulk_order" enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('insert-pre-bulk-order'); ?>" method="POST" autocomplete="off">
                        <div class="row row-lg">
                            <div class="col-lg-4">
                                <!-- address  -->
                                <div class="example-wrap">
                                    <h4 class="example-title"></h4>
                                    <div class="example">
                                        <label class="form-control-label">Pickup Address</label>
                                        <select class="form-control select2" name="pickup_address" id="pickup_address">
                                            <option value="">Please Select Pickup Address</option>
                                            <?php foreach ($all_pickup_address as $pickup_address) { ?>
                                                <option value="<?php echo $pickup_address['id']; ?>">
                                                    <?= $pickup_address['warehouse_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <?php if (isset($errors['pickup_address'])) { ?>
                                            <label class="error"><?= @$errors['pickup_address'] ?></label>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- End address -->
                            </div>

                        </div>

                        <div class="row row-lg">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input type="file" name="pre_bulk_import_file" id="pre_bulk_import_file" class="dropify-event" data-plugin="dropify" data-default-file="" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                </div>
                            </div>

                            <div class="col-md-6 my-auto">
                                <div class="form-group">
                                    <h4 class="sample_of_excel">
                                        <a href="<?php echo base_url('assets/pre_airway_bulk_order/sample/sample_pre_awb_bulk_order.xlsx'); ?>" download>
                                            <i class="fa fa-file-excel-o"></i> sample.xlsx
                                        </a>
                                        <small style="color: #f44336">(Note: For import excel format given)</small>
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 my-auto">

                                <div class="form-actions right text-center" id="pre_bulk">
                                    <input type="submit" name="pre_bulk_btn" id="pre_bulk_btns">
                                </div>
                            </div>
                        </div>

                        <!-- form end-->
                    </form>

                </div>
            </div>

            <!-- Table data -->
            <div class="panel">
                <!-- <header class="panel-heading">
            <div class="panel-actions"></div>
         </header> -->
                <div class="panel-body container-fluid">
                    <!-- <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable"> -->
                    <table class="table table-hover dataTable table-striped" id="pre_airway_order_bulk">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="checkAll" id="ckbCheckAll" name="check_all" value="">
                                </th>
                                <th>Order Number</th>
                                <th>Service</th>
                                <th>Created Date</th>
                                <th>Customer Name</th>
                                <th>Order Type</th>
                                <th>Remark</th>
                                <th></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="bulk_order_submit_on_check btn btn-primary" id="pre_awb_bulk_subm" value="Submit">Submit</button>
                            <!-- <button name="submit" class="bulk_order_submit_on_check" id="subm"> Submit </button> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Table data -->
        </div>
    </div>
</div>
</div>