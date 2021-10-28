<!-- BEGIN CONTENT -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Customer Api setting</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item active">Customer Api setting</li>
        </ol>
    </div>
    <div class="page-content">
        <!-- Panel Form Elements -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Customer Api setting
                    <hr>
                </h3>
            </div>
            <div class="panel-body container-fluid">


                <div class="row">
                    <div class="col-md-12">

                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form class="horizontal-form" id="customer_api_setting_form" method="POST"
                                enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h4 class="example">Customers</h4>
                                                <select name="sender_id" id="customer_api_setting_customer_id"
                                                    class="form-control select2">
                                                    <option value="" selected>Select Customer</option>
                                                    <?php foreach ($customer_list as $single_customer) { ?>
                                                    <option value="<?php echo $single_customer['id']; ?>">
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
                                                <h4 class="example">Pickup Address</h4>
                                                <select name="api_pickup_address_id"
                                                    id="customer_api_setting_pickup_address_id"
                                                    class="form-control select2">
                                                    <option value="" selected>Select Option</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="checkbox" value="1" id="customer_api_setting_is_web_access"
                                                    name="api_is_web_access">
                                                <span></span>
                                                <label class="mt-checkbox"> Is Web Access ?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="customer_api_setting_key_and_id_div" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Api Key :</label>
                                                    <label id="customer_api_setting_api_key"></label>
                                                    <input type="hidden" name="api_key">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">User ID :</label>
                                                    <label id="customer_api_setting_api_user_id"></label>
                                                    <input type="hidden" name="api_user_id">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                                <div class="form-actions right">
                                    <button type="button" id="customer_api_setting_info_save"
                                        class="btn btn-primary">Save</button>
                                    <button class="btn btn-primary" id="customer_api_setting_info_pdf_button"
                                        type="button" style="display: none;">PDF</button>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>