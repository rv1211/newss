<div class="page">
    <div class="page-header">
        <h1 class="page-title">Manage Shipping Price</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Create Single Shipping Charge</li>
        </ol>

    </div>

    <div class="page-content">
        <form action="<?= base_url('shipping-price') ?>" method="post">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Add Single Shipping Price
                        <hr>
                    </h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-3">
                            <input type="hidden" name="manage_price_id" id="manage_price_id" value="0">
                            <div class="form-group form-material" id="logisticDiv">
                                <h4 class="example-">Logistic</h4>
                                <select name="logistic" id="logistic" class="form-control select2">
                                    <?php foreach ($logistics as $logistic) : ?>
                                        <option value="<?= $logistic['id'] ?>" <?php echo set_select('logistic', $logistic['id']) ?>><?= $logistic['logistic_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['logistic'])) : ?>
                                    <label class="error"><?php echo $errors['logistic']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-material" id="ruleDiv">
                                <h4 class="example-">Rule</h4>
                                <select name="rule" id="rule" class="form-control select2">
                                    <?php foreach ($rules as $rule) : ?>
                                        <option value="<?= $rule['id'] ?>" <?php echo set_select('rule', $rule['id']) ?>><?= $rule['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['rule'])) : ?>
                                    <label class="error"><?php echo $errors['rule']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-material" id="shipDiv">
                                <h4 class="example-">Shipment Type</h4>
                                <select name="shipment" id="shipment" class="form-control select2">
                                    <option value="0" <?php echo set_select('shipment', "0") ?>>Forward</option>
                                    <option value="1" <?php echo set_select('shipment', "1") ?>>Reverse</option>
                                </select>
                                <?php if (isset($errors['shipment'])) : ?>
                                    <label class="error"><?php echo $errors['shipment']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-material" id="shipDiv">
                                <h4 class="example-">Rule Index</h4>
                                <input type="number" id="rule_index" name="rule_index" class="form-control" value="<?= set_value('rule_index'); ?>" placeholder="Enter Rule Index">
                                <?php if (isset($errors['rule_index'])) : ?>
                                    <label class="error"><?php echo $errors['rule_index']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div><br>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Within Zone</h4>
                                <input type="text" name="withinzone" id="withinzone" placeholder="Within Zone" value="<?= set_value('withinzone'); ?>" class="form-control">
                                <?php if (isset($errors['withinzone'])) : ?>
                                    <label class="error"><?php echo $errors['withinzone']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Within City</h4>
                                <input type="text" name="withincity" id="withincity" placeholder="Within City" value="<?= set_value('withincity'); ?>" class="form-control">
                                <?php if (isset($errors['withincity'])) : ?>
                                    <label class="error"><?php echo $errors['withincity']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Within State</h4>
                                <input type="text" name="withinstate" id="withinstate" placeholder="Within State" value="<?= set_value('withinstate'); ?>" class="form-control">
                                <?php if (isset($errors['withinstate'])) : ?>
                                    <label class="error"><?php echo $errors['withinstate']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Metro</h4>
                                <input type="text" name="metro" id="metro" placeholder="Metro" value="<?= set_value('metro'); ?>" class="form-control">
                                <?php if (isset($errors['metro'])) : ?>
                                    <label class="error"><?php echo $errors['metro']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Metro 2</h4>
                                <input type="text" name="metro2" id="metro2" placeholder="Metro 2" value="<?= set_value('metro2'); ?>" class="form-control">
                                <?php if (isset($errors['metro2'])) : ?>
                                    <label class="error"><?php echo $errors['metro2']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Rest Of India</h4>
                                <input type="text" name="restofindia" id="restofindia" placeholder="Rest Of India" value="<?= set_value('restofindia'); ?>" class="form-control">
                                <?php if (isset($errors['restofindia'])) : ?>
                                    <label class="error"><?php echo $errors['restofindia']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Rest Of India 2</h4>
                                <input type="text" name="restofindia2" id="restofindia2" placeholder="Rest Of India 2" value="<?= set_value('restofindia2'); ?>" class="form-control">
                                <?php if (isset($errors['restofindia2'])) : ?>
                                    <label class="error"><?php echo $errors['restofindia2']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-material">
                                <h4 class="example-">Special Zone</h4>
                                <input type="text" name="specialzone" id="specialzone" placeholder="Special Zone" value="<?= set_value('specialzone'); ?>" class="form-control">
                                <?php if (isset($errors['specialzone'])) : ?>
                                    <label class="error"><?php echo $errors['specialzone']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group form-material">
                                <input type="checkbox" name="cod_return" id="cod_return" class="d-inline">
                                <h5 class="example-  d-inline">Cod Charge Return Or Not</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-material">
                            <h4 class="example-">&nbsp;</h4>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Panel end -->
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            <div class="form-group form-material">
                                <h4 class="example-">Shipping Price List</h4>
                                <table class="table table-striped table-borderd" id="shipping_price_table">
                                    <thead>
                                        <tr>
                                            <td>Logistic Name</td>
                                            <td>Rule</td>
                                            <td>Rule Index</td>
                                            <td>Shipment Type</td>
                                            <td>Within Zone</td>
                                            <td>Within City</td>
                                            <td>Within State</td>
                                            <td>Metro</td>
                                            <td>Metro 2</td>
                                            <td>Rest Of India</td>
                                            <td>Rest Of India 2</td>
                                            <td>Special Zone</td>
                                            <td>Is COD Return</td>
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
            <!-- Panel end -->
        </form>
    </div>
</div>