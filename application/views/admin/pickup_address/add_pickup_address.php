<!-- Page -->
<div class="page">
    <div class="page-header">
        <h1 class="page-title">Add Pickup Address</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('dashboard');?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url('pickup-address');?>">Pickup Address</a></li>
            <li class="breadcrumb-item active">Add Address</li>
        </ol>
    </div>
    <?php //echo validation_errors('<li class="alert alert-danger alert-dismissible col-md-5" role="alert" ><b>', '</b></li>'); ?>
    <div class="page-content">
        <!-- Panel Form Elements -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Register your pickup address
                    <hr>
                </h3>
            </div>
            <form action="<?php echo base_url() ?>add-pickup-address" name="manage_pickup_address" method="POST"
                class="manage-pickup-form">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-6 col-lg-6">
                            <!-- Example Placeholder -->
                            <div class="form-group form-material">
                                <h4 class="example-title">Warehouse Name</h4>
                                <input type="text" name="warehouse_name" onkeypress=""
                                    class="form-control" id="warehouse_name" placeholder="Warehouse Name"
                                    value="<?= isset($_POST['warehouse_name']) ? $_POST['warehouse_name']: '' ?>">
                                <?php if (isset($errors['warehouse_name'])) {?>
                                <label class="error"><?=@$errors['warehouse_name']?></label>
                                <?php }?>
                            </div>
                            <!-- End Example Placeholder -->
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <!-- Example Placeholder -->
                            <div class="form-group form-material">
                                <h4 class="example-title">Contact Person Name</h4>
                                <input type="text" class="form-control" name="contact_person_name"
                                    onkeypress="" id="contact_person_name"
                                    placeholder="Contact Person Name"
                                    value="<?= isset($_POST['contact_person_name']) ? $_POST['contact_person_name']: '' ?>">
                                <?php if (isset($errors['contact_person_name'])) {?>
                                <label class="error"><?=@$errors['contact_person_name']?></label>
                                <?php }?>
                            </div>
                            <!-- End Example Placeholder -->
                        </div>


                        <div class="col-md-6 col-lg-4">
                            <!-- Example Placeholder -->
                            <div class="form-group form-material">
                                <h4 class="example-title">Contact No</h4>
                                <input type="text" class="form-control" onkeypress="return isNumber(event)"
                                    name="contact_no" id="contact_no" placeholder="Contact No"
                                    value="<?= isset($_POST['contact_no']) ? $_POST['contact_no']: '' ?>">
                                <?php if (isset($errors['contact_no'])) {?>
                                <label class="error"><?=@$errors['contact_no']?></label>
                                <?php }?>
                            </div>
                            <!-- End Example Placeholder -->
                        </div>


                        <div class="col-md-6 col-lg-4">
                            <!-- Example Placeholder -->
                            <div class="form-group form-material">
                                <h4 class="example-title">Contact Email</h4>
                                <input type="text" class="form-control" name="contact_email" id="contact_email"
                                    placeholder="Contact Email"
                                    value="<?= isset($_POST['contact_email']) ? $_POST['contact_email']: '' ?>">
                                <?php if (isset($errors['contact_email'])) {?>
                                <label class="error"><?=@$errors['contact_email']?></label>
                                <?php }?>
                            </div>
                            <!-- End Example Placeholder -->
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <!-- Example Placeholder -->
                            <div class="form-group form-material">
                                <h4 class="example-title">Website</h4>
                                <input type="text" class="form-control" name="website" id="website"
                                    placeholder="Website"
                                    value="<?= isset($_POST['website']) ? $_POST['website']: '' ?>">
                                <?php if (isset($errors['website'])) {?>
                                <label class="error"><?=@$errors['website']?></label>
                                <?php }?>
                            </div>
                            <!-- End Example Placeholder -->
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <!-- Example Textarea -->
                            <div class="form-group form-material">
                                <h4 class="example-title">Address Line 1</h4>
                                <textarea class="form-control" id="address_line_1" name="address_line_1"
                                    rows="3"><?= isset($_POST['address_line_1']) ? $_POST['address_line_1']: '' ?></textarea>
                                <?php if (isset($errors['address_line_1'])) {?>
                                <label class="error"><?=@$errors['address_line_1']?></label>
                                <?php }?>
                            </div>
                            <!-- End Example Textarea -->
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <!-- Example Textarea -->
                            <div class="form-group form-material">
                                <h4 class="example-title">Address Line 2</h4>
                                <textarea class="form-control" name="address_line_2" id="address_line_2"
                                    rows="3"><?= isset($_POST['address_line_2']) ? $_POST['address_line_2']: '' ?></textarea>
                            </div>
                            <!-- End Example Textarea -->
                        </div>


                        <div class="col-md-6 col-lg-4">
                            <div class="form-group form-material">
                                <h4 class="example-title">Pincode</h4>
                                <input type="text" class="form-control" name="pincode" class="pickup_add_pincode"
                                    id="pickup_pincode" placeholder="Pincode"
                                    value="<?= isset($_POST['pincode']) ? $_POST['pincode']: '' ?>">
                                <?php if (isset($errors['pincode'])) {?>
                                <label class="error"><?=@$errors['pincode']?></label>
                                <?php }?>
                            </div>
                        </div>


                        <div class="col-md-6 col-lg-4">
                            <div class="form-group form-material">
                                <h4 class="example-title">State</h4>
                                <input type="text" class="form-control" name="state" id="state" placeholder="State"
                                    value="<?= isset($_POST['state']) ? $_POST['state']: '' ?>">
                                <?php if (isset($errors['state'])) {?>
                                <label class="error"><?=@$errors['state']?></label>
                                <?php }?>
                            </div>
                        </div>


                        <div class="col-md-6 col-lg-4">
                            <div class="form-group form-material">
                                <h4 class="example-title">City</h4>
                                <input type="text" class="form-control" name="city" id="city" placeholder="City"
                                    value="<?= isset($_POST['city']) ? $_POST['city']: '' ?>">
                                <?php if (isset($errors['city'])) {?>
                                <label class="error"><?=@$errors['city']?></label>
                                <?php }?>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-12 text-center">
                            <div class="form-group form-material">
                                <button type="submit" name="Save" id="pickup_address_btn"
                                    class="btn btn-primary waves-effect waves-classic">Submit</button>
                                <!-- <input type="submit" name="Save" id="pickup_address_btn" class="btn btn-primary waves-effect waves-classic"> -->
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        <!-- End Panel Form Elements -->

    </div>
</div>
<!-- End Page -->