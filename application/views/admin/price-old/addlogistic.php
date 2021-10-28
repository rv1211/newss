
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Manage Logistic</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Create logistic</li>
        </ol>
    </div>
    <div class="page-content">
        <form action="<?= base_url('manage-logistic/add-logistic') ?>" method="post" id="addlogisticform">
            <!-- Panel Form Elements -->
            <div class="panel"> 
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Add Logistic
                        <hr>
                    </h3>
                </div>
                <input type="hidden" name="logistic_id" id="logistic_id" value="0">
                <div class="panel-body container-fluid">
                <!-- <label class="error" style="font-size: 15px;">Note :- Don't use space ,use  '_' (underscore) instead of space</label> -->
                    <div class="row row-lg">
                        <div class="col-md-6">
                            <div class="form-group form-material">
                                <h4 class="example-">Logistic Name</h4>
                                <input type="text" name="logisticname" value="<?= set_value('logisticname'); ?>" id="logisticname" class="form-control" placeholder="Logistic name">
                                
                                <?php if(isset($errors['logisticname'])): ?>
                                    <label class="error"><?php echo $errors['logisticname']; ?></label>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-material">
                                <h4 class="example-">API Name</h4>
                                <input type="text" name="api_name" value="<?= set_value('api_name'); ?>" id="api_name" class="form-control" placeholder="API Name">
                                <?php if(isset($errors['api_name'])): ?>
                                    <label class="error"><?php echo $errors['api_name']; ?></label>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <div class="row row-lg">
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Cod Price</h4>
                                <input type="number" name="codprice" value="<?= set_value('codprice'); ?>" id="codprice" class="form-control" placeholder="Cod Price">
                                <?php if(isset($errors['codprice'])): ?>
                                    <label class="error"><?php echo $errors['codprice']; ?></label>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-material">
                                <h4 class="example-">Cod Percentage</h4>
                                <input type="text" name="codpercentage" value="<?= set_value('codpercentage'); ?>" id="codpercentage" class="form-control" placeholder="Cod Percentage">
                                <?php if(isset($errors['codpercentage'])): ?>
                                    <label class="error"><?php echo $errors['codpercentage']; ?></label>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="col-md-3">
                        <div class="form-check form-group form-material" style="margin-top: 20px;margin-left:33px;">
                                <input type="checkbox" class="form-check-input" name="iszship" id="iszship" value="">
                                <label class="form-check-label" for="exampleCheck1" name="is_zship" <?= @$user_data->is_zship == '0'?"checked":''; ?> value="<?php echo set_checkbox('is_zship', '0'); ?>">Is Zship</label>
                        </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-material">
                                <h4 class="example-">&nbsp;</h4>
                                <button type="submit" class="btn btn-primary" id="add_logistic">Save</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-material">
                                <h4 class="example-">&nbsp;</h4>
                                <a href="<?= base_url('manage-logistic');?>"><button type="reset" class="btn btn-primary" style="margin-left: -105px;" id="cancelbtn">Cancel</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Panel End -->
            <!-- Panel Start -->
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            <div class="form-group form-material">
                                <h4 class="example-">Logistic List</h4>
                            <table class="table table-striped table-borderd" id="logisctic_table">
                                <thead>
                                    <tr>
                                        <td>Logistic Name</td>
                                        <td>API Name</td>
                                        <td>Cod Price</td>
                                        <td>Cod Percentage</td>
                                        <td>Status</td>
                                        <td>Is Zship</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Panel End -->
        </form>
    </div>
</div>