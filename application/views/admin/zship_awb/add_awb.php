<div class="page">
    <div class="page-header">
        <h1 class="page-title">Generate Zship AWB</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Generate Zship AWB</li>
        </ol>

    </div>

    <div class="page-content">
        <form action="<?=base_url('generate-awb')?>" method="post" id="generate_awb">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-body container-fluid">
                    <label class="error" style="font-size: 18px;">Total Airwaybill: <span id="totalAwb">00</span></label>
                    <div class="row row-lg">
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Logistic</h4>
                                <select name="zship_logistic" id="zship_logistic" class="form-control select2" required="">
                                    <option value="">Select Logistic</option>
                                    <?php if(!empty($logisticDetail)){
                                        foreach($logisticDetail as $logisticVal){ ?>
                                            <option value="<?= $logisticVal['api_name']; ?>"><?= $logisticVal['logistic_name']; ?></option>
                                    <?php } } ?>
                                </select>
                                <?php if (isset($errors['zship_logistic'])): ?>
                                    <label class="error"><?php echo $errors['zship_logistic']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Order Type</h4>
                                <select name="order_type" id="order_type" class="form-control select2" required="">
                                    <option value="">Select Order Type</option>
                                    <option value="COD">COD</option>
                                    <option value="PREPAID">Prepaid</option>
                                </select>
                                <?php if (isset($errors['order_type'])): ?>
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