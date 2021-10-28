<div class="page">
    <div class="page-header">
        <h1 class="page-title">Generate Ecom AWB</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Generate Ecom AWB</li>
        </ol>

    </div>

    <div class="page-content">
        <form action="<?= base_url('ecom-generate-awb') ?>" method="post" id="">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-body container-fluid">
                    <label class="text-primary" style="font-size: 18px;">
                        <h3 class="text-primary" style="font-style:bold;">Total Airwaybill: <span id="totalAwbecom">00</span> </h3>
                    </label>
                    <div class="row row-lg">
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Order Type</h4>
                                <select name="order_type" id="order_type_ecom" class="form-control select2" required="">
                                    <option value="">Select Order Type</option>
                                    <option value="COD">COD</option>
                                    <option value="PPD">Prepaid</option>
                                    <option value="REV">Reverse Pickup</option>
                                </select>
                                <?php if (isset($errors['order_type'])) : ?>
                                    <label class="error"><?php echo $errors['order_type']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-material">
                                <h4 class="example-">&nbsp;</h4>
                                <button type="submit" id="awb_btn" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Panel end -->
        </form>
    </div>
</div>