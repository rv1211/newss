<div class="page">
    <div class="page-header">
        <h1 class="page-title">Assign Airwaybill Number</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Assign Airwaybill Nuber</li>
        </ol>

    </div>

    <div class="page-content">
        <form action="<?=base_url('get_airwaybill')?>" method="post" id="assign_awb" name="assingawb">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-4">
                            <div class="form-group form-material">
                                <h4 class="example-">Customers</h4>
                                <select name="sender_name" id="sender_name" class="form-control select2" required="">
                                    <option value="">Select Customer</option>
                                    <?php foreach ($this->data['sender_list'] as  $sender_list_value) { ?>
                                    <option value="<?php echo $sender_list_value['id'];?>">
                                        <?php echo $sender_list_value['email'];?></option>
                                    <?php } ?>
                                </select>
                                <label class="sender_error"></label>
                                <?php if (isset($errors['sender_name'])): ?>
                                <label class="error"><?php echo $errors['sender_name']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-material">
                                <h4 class="example-">Logistic type</h4>
                                <select name="logistic_type" id="logistic_type" class="form-control select2"
                                    required="">
                                    <option value="">Select Logistic Type</option>
                                    <?php foreach ($this->data['logistic'] as  $logisticvalue) { dd($logisticvalue);?>

                                    <option value="<?php echo $logisticvalue['id'];?>">
                                        <?php echo $logisticvalue['logistic_name'];?></option>
                                    <?php } ?>
                                </select>
                                <?php if (isset($errors['logistic_type'])): ?>
                                <label class="error"><?php echo $errors['logistic_type']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group form-material">
                                <h4 class="example-">&nbsp;</h4>
                                <button type="button" id="assign_awb_btn" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Panel end -->
            <div class="panel" id="awb_panel" style="display:none;">
                <div class="panel-body container-fluid">
                    <div class="awb_table">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>