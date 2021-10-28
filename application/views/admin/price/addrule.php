<div class="page">
    <div class="page-header">
        <h1 class="page-title">Manage Rule</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Create Rule</li>
        </ol>
    </div>

    <div class="page-content">
        <form action="<?= base_url('manage-logistic/insert-rule') ?>" method="post">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Add Rule
                        <hr>
                    </h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-3">
                            <div class="example-wrap-new">
                                <h4 class="example-">Rule </h4>
                                <input type="hidden" name="rule_id" id="rule_id" value="0">
                                <input type="text" name="rulename" value="<?= set_value('rulename'); ?>" id="rule_name" class="form-control" placeholder="Rule Name">
                                <?php if (isset($errors['rulename'])) : ?>
                                    <label class="error"><?php echo $errors['rulename']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h4 class="example-">From </h4>
                            <input type="text" name="from_kg" value="<?= set_value('from_kg'); ?>" id="rule_from" class="form-control" placeholder="From in Kg">
                            <?php if (isset($errors['from_kg'])) : ?>
                                    <label class="error"><?php echo $errors['from_kg']; ?></label>
                                <?php endif; ?>
                        </div>
                        <div class="col-md-3">
                            <h4 class="example-">TO </h4>
                            <input type="text" name="to_kg" value="<?= set_value('to_kg'); ?>" id="rule_to" class="form-control" placeholder="To in Kg">
                            <?php if (isset($errors['to_kg'])) : ?>
                                    <label class="error"><?php echo $errors['to_kg']; ?></label>
                                <?php endif; ?>
                        </div>
                        <div class="col-md-3">
                            <div class="example-wrap-new" style="margin-top: 30px;">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Panel end -->
            <!-- Panel start -->
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            <div class="example-wrap-new">
                                <h4 class="example-">Rule List</h4>
                                <table class="table table-hover dataTable table-striped" id="rule_table">
                                    <thead>
                                        <tr>
                                            <td>Rule Name</td>
                                            <td>From</td>
                                            <td>To</td>
                                            <td>Status</td>
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