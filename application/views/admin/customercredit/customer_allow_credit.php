<!-- BEGIN CONTENT -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Customer Credit</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item active">Customer Credit</li>
        </ol>
    </div>
    <div class="page-content">
        <!-- Panel Form Elements -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Customer Credit
                    <hr>
                </h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="horizontal-form" id="customer_allow_credit_form" method="POST" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h4 class="example">Customers</h4>
                                                <select name="customer_id" id="customer_allow_credit_customer_id" class="form-control select2">
                                                    <option value="" selected>Select Customer</option>
                                                    <?php foreach ($customer_list as $single_customer) { ?>
                                                        <option value="<?php echo $single_customer['id']; ?>" data-allowcredit="<?php echo $single_customer['allow_credit']; ?>" data-allowcreditlimit="<?php echo $single_customer['allow_credit_limit']; ?>">
                                                            <?php echo $single_customer['name']; ?> -
                                                            <?php echo $single_customer['email']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="mt-checkbox"> Allow Credit ?
                                                    <input type="checkbox" value="1" id="customer_allow_credit_is_allow_credit" name="allow_credit">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="customer_allow_credit_limit_div" style="display: none;">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h4 class="example">Credit Limit</h4>
                                                <input type="text" name="allow_credit_limit" class="form-control" placeholder="Credit Limit">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                                <div class="form-actions right">
                                    <button type="button" id="customer_allow_credit_info_save" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
                <hr>
                <br> <br>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" id="customer_credit_list" width="100%">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Customer Email</th>
                                    <th>Allow Credit Amount</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>