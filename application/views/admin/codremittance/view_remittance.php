<div class="page">
    <div class="page-header">
        <h1 class="page-title">Cod Remittance</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>">home</a></li>
            <li class="breadcrumb-item active">Cod Remittance</li>
        </ol>
    </div>
    <div class="page-content">
        <div class="panel">
            <div class="panel-body">
                <!-- Cod countes box  -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-inverse card1 ">
                            <div class="card-block">
                                <h5 class="card-title">TOTAL COD GENERATED</h5>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; <?= $total_cod['Totalcod']; ?></h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-inverse card2 ">
                            <div class="card-block">
                                <h5 class="card-title">TOTAL BILL ADJUSTED</h5>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-inverse card3 ">
                            <div class="card-block">
                                <h5 class="card-title">TOTAL REFUND ADJUSTED</h5>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-inverse card4 ">
                            <div class="card-block">
                                <h5 class="card-title">TOTAL ADVANCED HOLD</h5>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-inverse card1 ">
                            <div class="card-block">
                                <h5 class="card-title">TOTAL COD REMITTED</h5>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-inverse card2 ">
                            <div class="card-block">
                                <h5 class="card-title">EARLY COD</h5>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card card-inverse card3 ">
                            <div class="card-block">
                                <h5 class="card-title">WALLET TRANFEREED</h5>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-inverse card4 ">
                            <div class="card-block">
                                <h4 class="card-title">TOTAL BILL DEDUCTED</h4>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-inverse card1 ">
                            <div class="card-block">
                                <h4 class="card-title">TOTAL PAID COD </h4>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-inverse bg-danger">
                            <div class="card-block">
                                <h4 class="card-title">TOTAL COD </h4>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end cod countes box -->

                <!-- secound tab -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-inverse bg-info">
                            <div class="card-block">
                                <h4 class="card-title">REMANING COD</h4>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-inverse bg-dark">
                            <div class="card-block">
                                <h4 class="card-title">WALLET DEDUCTED</h4>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card card-inverse bg-success">
                            <div class="card-block">
                                <h4 class="card-title">TOTAL COD TO ADJUSTED </h4>
                                <p class="card-text">
                                <h3 class="d-inline text-white">&#8377; 00</h3>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end secound tab -->



                <div class="portlet-body form">
                    <div class="form-body">
                        <form class="horizontal-form" id="cod_remittance_form" method="POST"
                            enctype="multipart/form-data" action="<?php echo base_url('cod-remittance-list'); ?>">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-control-label">Customers :</label>
                                    <select name="customer_id" id="cod_remittance_customer_id"
                                        class="form-control select2" required="required">
                                        <option value="" selected>Select Customer</option>
                                        <?php foreach ($customer_list as $single_customer) {
                                            if ($single_customer['id'] == @$customer_id) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            } ?>
                                        <option value="<?php echo $single_customer['id']; ?>" <?php echo $selected; ?>>
                                            <?php echo $single_customer['name']; ?> -
                                            <?php echo $single_customer['email']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label class="form-control-label">From Date</label>
                                        <input type="date" name="from_date" id="cod_remittance_from_date"
                                            class="form-control" required="required" value="<?php echo @$from_date; ?>"
                                            placeholder="Select From Date..">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class=" form-group">
                                        <label class="form-control-label">To Date</label>
                                        <input type="date" name="to_date" id="cod_remittance_to_date"
                                            class="form-control " required="required" value="<?php echo @$to_date; ?>"
                                            placeholder="Select To Date..">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Action</label>
                                        <button type="submit" name="submit" value="Get List"
                                            class="btn btn-primary form-control" id="get_remittance_list">Get
                                            List</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php if (@$customer_id != "" && @$from_date != "" && @$to_date != "") { ?>
                        <hr>
                        <div class=" row">
                            <div class="col-md-12">
                                <div class="form-group form-material">
                                    <table class="table" id="cod_remittance_list_table" width="100%">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="check_all_cod_remittance_order"></th>
                                                <th>Order ID</th>
                                                <th>Airwaybill Number</th>
                                                <th>COD Amount</th>
                                                <th>Deliver Date</th>
                                                <th>Created Date</th>
                                                <th>Customer</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group form-material">
                                    <h4>Total COD Remittance Amount Is: <strong>RS.<span
                                                id="cod_remittance_total_amount">0.00</span></strong></h4>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-1 text-right">
                                <div class="form-group form-material">
                                    <label class="form-control-label">Note :</label>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="form-group form-material">
                                    <input type="text" name="cod_remittance_note" class="form-control" maxlength="250"
                                        required="required" placeholder="cod remittance note">
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="<?php echo base_url('export-cod-remmitance-data'); ?>">
                        <div class="form-actions right">
                            <button type="button" class="btn btn-primary" name="submit" value="Submit"
                                id="cod_remittance_save_button">Submit</button>
                            <input type="hidden" name="cod_remittance_detail_id" id="cod_remittance_detail_id">
                            <button type="submit" class="btn btn-success" name="export" value="Export"
                                style="display: none;">Export</button>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>