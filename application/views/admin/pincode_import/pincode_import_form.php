
<div class="page">
    <!-- start page header -->
    <div class="page-header">
        <h1 class="page-title">Pincode Import</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
                <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Create Order</a></li> -->
                <li class="breadcrumb-item active">Pincode Import</li>
            </ol>
    </div>
    <!-- end page header -->
    <!-- start page content -->
    <div class="page-content">
        <form action="<?= base_url('import-pincode'); ?>" name="pincode_import_form" method="POST" id="pincode_import_form" autocomplete="off" enctype="multipart/form-data">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Import Pincode
                        <hr>
                    </h3>
                </div>
                <!-- end panel heading -->
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-4">
                            <div class="form-group form-material">
                                <h5 class="example-">Logistic</h5>
                                    <select name="logistic" id="logistic_type" class="form-control select2 logistic">
                                        <option value="">Select Logistic</option>
                                        <?php foreach ($this->data['logistic_name'] as $single_logistic) {?>
                                            <option value="<?php echo $single_logistic['id']; ?>">
                                                <?php echo $single_logistic['logistic_name']; ?>
                                            </option> 
                                        <?php } ?>
                                    </select>
                                    <?php if(isset($errors['logistic'])): ?>
                                    <label class="text-danger"><?=$errors['logistic']; ?></label>
                                    <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-material">
                                <h5 class="example-">Option</h5>
                                    <select name="option" class="form-control select2 option">
                                        <option value="">Select option</option>
                                        <option value="1">Insert New</option>
                                        <option value="2">Insert & Update</option>
                                        <option value="3">Delete & Insert</option>
                                    </select>
                                    <?php if(isset($errors['option'])): ?>
                                    <label class="text-danger"><?=$errors['option']; ?></label>
                                    <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row row-lg">
                        <div class="col-md-4">
                            <div class="form-group form-material">
                                <div class="example-wrap">
                                    <h5 class="">Choose file for import pincode</h5>
                                        <div class="example">
                                            <input type="file" name="pincode_excel" class="dropify-event" id="pincode_excel" data-plugin="dropify" data-default-file="" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                                            
                                             <!-- <input type="file" name="pincode_excel" id="input-file-events" class="dropify-event" data-default-file="../../../global/photos/placeholder.png"> -->
                                        </div>
                                </div>
                                <?php if(isset($errors['pincode_excel'])): ?>
                                    <label class="text-danger"><?=$errors['pincode_excel']; ?></label>
                                    <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-material" style="margin-top: 98px;">
                                <a class="text-success import_link" id="common_import" href="<?php echo base_url('assets/pincode_import_sample/Pincode_import.xlsx'); ?>" download style="display:none;">
                                    <i class="icon-file-excel"></i> Pincode_import_format.xlsx
                                </a>  
                                <a class="text-success import_link" id="shadowfax_import" href="<?php echo base_url('assets/pincode_import_sample/ShadowFax_pincode_import.xlsx'); ?>" download style="display:none;">
                                    <i class="icon-file-excel"></i> ShadowFax_import_format.xlsx
                                </a>  
                                <a class="text-success import_link" id="xpressbees_import" href="<?php echo base_url('assets/pincode_import_sample/Xpressbees_pincode_import.xlsx'); ?>" download style="display:none;">
                                    <i class="icon-file-excel"></i> Xpressbees_import_format.xlsx
                                </a><br>  
                                <small id="import_note" style="display:none;color: #f44336">(Note: For import excel format given)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row row-lg">
                        <div class="col-md-1">
                            <div class="form-group form-material">
                                <button type="submit" id="import_btn"class="btn btn-primary waves-effect waves-classic waves-effect waves-classic excel">Import Excel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end panel body -->
        </form>
    </div>
    <!-- end page content -->
</div>