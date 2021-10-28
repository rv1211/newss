<div class="page">
    <div class="page-header">
        <h4 class="page-title">Bulk order</h4>
        <div class="page-content">
            <div class="panel">
                <header class="panel-heading">
                    <h3 class="panel-title">
                        Create Bulk Order
                    </h3>
                </header>

                <div class="panel-body">
                    <p>
                        <!--  -->
                    </p>
                    <span id="message"></span>

                    <!-- <form class="form-horizontal fv-form fv-form-bootstrap4"  id="create_bulk_order" name="create_bulk_order"  action="<?php //echo base_url('insert_airway_bill'); 
                                                                                                                                            ?>" method="POST" enctype="multipart/form-data" autocomplete="off" novalidate="novalidate"> -->
                    <form id="add_bulk_order" name="bulk_order_form" method="POST" enctype="multipart/form-data" class="form-horizontal" action="<?php echo base_url('create-bulk-order'); ?>" method="POST" autocomplete="off">
                        <div class="row row-lg">
                            <div class="col-lg-4">
                                <!-- Logistic  -->
                                <div class="example-wrap">
                                    <h4 class="example-title"></h4>
                                    <div class="example">
                                        <label class="form-control-label">Pickup Address</label>
                                        <select class="form-control select2" name="pickup_address" id="pickup_address">
                                            <option value="">Please Select Pickup Address</option>
                                            <?php
                                            foreach ($all_pickup_address as $pickup_address) { ?>
                                                <option value="<?php echo $pickup_address['id']; ?>">
                                                    <?= $pickup_address['warehouse_name']; ?>
                                                </option>
                                            <?php
                                            } ?>
                                        </select>
                                        <?php if (isset($errors['pickup_address'])) { ?>
                                            <label class="error"><?= @$errors['pickup_address'] ?></label>
                                        <?php } ?>

                                    </div>
                                </div>
                                <!-- End Logistics -->
                            </div>
                        </div>

                        <div class="row row-lg justify-content-center">
                            <div class="col-lg-4">

                                <!-- -->
                                <div class="form-group">
                                    <!-- <input type="file" id="import_file" name="import_file" class="form-control"> -->
                                    <input type="file" name="import_file" id="import_file" class="dropify-event" data-plugin="dropify" data-default-file="" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />

                                </div>

                            </div>

                            <div class="col-md-6 my-auto">
                                <div class="form-group">
                                    <h4 class="sample_of_excel">
                                        <a href="<?php echo base_url('/assets/import_bulk_order/sample/simple_bulk-order-sample.xlsx'); ?>" download>
                                            <!-- <img src="" alt="W3Schools" width="104" height="142"> -->
                                            <i class="fa fa-file-excel-o"></i> sample.xlsx
                                        </a>
                                        <small style="color: #f44336">(Note: For import excel format given)</small>
                                    </h4>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-4 my-auto">
                                <!-- <div class="animation-example animation-hover hover" > -->
                                <div class="form-actions right" id="create_bulk_order_submit_button_div">
                                    <input type="submit" name="importfile_btn" id="importfile_btn" value="ImportFile">
                                </div>
                            </div>
                        </div>

                        <!-- form end-->
                    </form>

                </div>
                <div class="panel">
                    <div class="panel-body container-fluid">
                        <div class="row row-lg">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" id="delete_nultiple_bulk_order" style="margin-left: 877px;top: 64px;">Delete Order</button>
                                <button type="button" class="btn btn-danger" id="delete_nultiple_bulk_order_all" style="margin-left: 500px;top: 64px;">Delete ALL Order</button>

                                <div class="form-group form-material">
                                    <h4 class="example-">Bulk order List</h4>

                                    <table class="table table-striped table-borderd" id="bulk_order_table">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="Bulk_checkAll" id="Bulk_ckbCheckAll" name="bulk_check_all" value=""></th>
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
                                </div>
                            </div>

                            <div class="row ml-1">
                                <div class="col-md-12">
                                    <button type="submit" class="bulk_order_submit_on_check btn btn-primary" id="subm_bulk_simple" value="Submit">Submit</button>
                                    <!-- <button name="submit" class="bulk_order_submit_on_check" id="subm"> Submit </button> -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>