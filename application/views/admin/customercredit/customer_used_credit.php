<div class="page">
    <div class="page-header">
        <h1 class="page-title">Customer Credit</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Customer</a></li>
            <li class="breadcrumb-item active">Customer Used Credit</li>
        </ol>
    </div>
    <div class="page-content">
        <div class="panel">
            <div class="panel-body">
                <div class="portlet-body form">
                    <div class="form-body">
                        <form class="horizontal-form" id="cod_remittance_form" method="POST" enctype="multipart/form-data" action="<?php echo base_url('customer-used-credit'); ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-material">
                                        <label class="form-control-label">Customers :</label>
                                        <select name="customer_id" id="credit_customer_id" class="form-control select2" required="required">
                                            <option value="" selected>Select Customer</option>
                                            <?php foreach ($customer_list as $single_customer) {
                                                if ($single_customer['id'] == @$customer_id) {
                                                    $selected = "selected";
                                                } else {
                                                    $selected = "";
                                                } ?>
                                                <option value="<?php echo $single_customer['id']; ?>" <?php echo $selected; ?>><?php echo $single_customer['name']; ?> -
                                                    <?php echo $single_customer['email']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-material">
                                        <label class="form-control-label">From Date</label>
                                        <input type="date" name="from_date" id="credit_used_from_date" class="form-control" required="required" value="<?php echo @$from_date; ?>" placeholder="Select From Date..">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-material">
                                        <label class="form-control-label">To Date</label>
                                        <input type="date" name="to_date" id="credit_used_to_date" class="form-control " required="required" value="<?php echo @$to_date; ?>" placeholder="Select To Date..">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group form-material">
                                        <button type="submit" name="submit" value="get_list" class="btn btn-primary" id="get_used_credit_list" style="margin-top: 22px">Get List</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php if (@$customer_id != "" && @$from_date != "" && @$to_date != "") { ?>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-material">
                                        <table class="table" id="customer_usedcredit_list" width="100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th><input type="checkbox" id="check_all_cod_remittance_order"></th> -->
                                                    <th>Customer Name</th>
                                                    <th>Customer Email</th>
                                                    <th>Used Credit Amount</th>
                                                    <th>Allow Credit Amount</th>
                                                    <!-- <th>Created Date</th>
                                                <th>Customer</th> -->
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>