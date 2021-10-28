<div class="page">
    <div class="page-header">
        <h1 class="page-title">Manage Logistic Priority</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Create Order</a></li> -->
            <li class="breadcrumb-item active">Add logistic priority</li>
        </ol>
    </div>
    <div class="page-content">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Add Logistic Priority
                    <hr>
                </h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-md-12">
                        <div id="wallet_response"></div>
                        <div id="step3_div" style="display:block">
                            <div class="row">
                                <div class="form-wizard-title col-md-12">
                                </div>
                            </div>
                            <form id="import_pincode_form" method="POST" class="import_pincode_form" action="<?php echo base_url('pincode-import-submit') ?>" enctype="multipart/form-data">
                                <div class="col-md-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h4>
                                                <img src="<?php echo base_url(); ?>assets/admin/images/manifested.svg" style="width: 35px;" alt="High-end Tech Support" title="High-end Tech Support">
                                                Logistic
                                            </h4>
                                            <div class="form-group">
                                                <select name="logistic_name" id="logistic_name" data-placeholder="Logistic *" class="form-control" required>
                                                    <option value="">Select Logistic</option>
                                                    <?php foreach ($logistic_list as $single_logistic) { ?>
                                                        <option value="<?php echo $single_logistic->logistic_id; ?>">
                                                            <?php echo $single_logistic->logistic_name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <span class="error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>
                                                <img src="<?php echo base_url(); ?>assets/admin/images/manifested.svg" style="width: 35px;" alt="High-end Tech Support" title="High-end Tech Support">
                                                Option
                                            </h4>
                                            <div class="form-group">
                                                <select name="import_option" id="import_option" data-placeholder="Operation Options *" class="form-control" required>
                                                    <option selected="" value="">Select Option</option>
                                                    <option value="insert_new">Insert New</option>
                                                    <option value="insert_and_update">Insert and Update</option>
                                                    <option value="delete_and_insert">Delete and Insert</option>
                                                </select>
                                                <span class="error"></span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div id="file_upload_section">
                                            <div class="col-md-4">
                                                <h4>
                                                    <img src="<?php echo base_url(); ?>assets/admin/images/manifested.svg" style="width: 35px;" alt="Choose File for Import Pincode" title="Choose File for Import Pincode">
                                                    Choose File for Import Pincode
                                                </h4>
                                                <div class="form-group">
                                                    <input type="file" id="pincode_import_file" name="pincode_import_file" class="form-control" required accept=".xlsx,.xls">
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h4 class="text-success">
                                                        <a class="text-success import_link" id="common_import" href="<?php echo base_url('assets/pincode_import_sample/Pincode_import.xlsx'); ?>" download style="display:none;">
                                                            <i class="icon-file-excel"></i> Pincode_import_format.xlsx
                                                        </a>
                                                        <a class="text-success import_link" id="shadowfax_import" href="<?php echo base_url('assets/pincode_import_sample/ShadowFax_pincode_import.xlsx'); ?>" download style="display:none;">
                                                            <i class="icon-file-excel"></i> ShadowFax_import_format.xlsx
                                                        </a>
                                                        <a class="text-success import_link" id="xpressbees_import" href="<?php echo base_url('assets/pincode_import_sample/Xpressbees_pincode_import.xlsx'); ?>" download style="display:none;">
                                                            <i class="icon-file-excel"></i> Xpressbees_import_format.xlsx
                                                        </a>
                                                        <small id="import_note" style="display:none;color: #f44336">(Note: For import excel format given)</small>
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-4">
                                                <input type="submit" name="pincode_import_submit" id="pincode_import_submit" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
</form>
</div>