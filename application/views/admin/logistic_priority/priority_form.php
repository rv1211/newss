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
        <form action="<?= base_url('logistic-priority'); ?>" method="POST">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Add Logistic Priority
                        <hr>
                    </h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-5">
                            <div class="form-group form-material">
                                <h4 class="example-">Logistic Name</h4>
                                <select name="logistic_name" id="logistic" class="form-control select2">
                                    <option value="">Select Option</option>
                                    <?php foreach ($this->data['logistics'] as $logistic) : ?>
                                    <option value="<?= $logistic['id'] ?>" <?= (isset($_POST['logistic_name']) && $_POST['logistic_name'] == $logistic['id']) ? 'selected' : ''; ?>><?= $logistic['logistic_name'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if(isset($errors['logistic_name'])): ?>
                                <label class="text-danger"><?=$errors['logistic_name']; ?></label>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group form-material">
                                <h4 class="example-">Priority Set</h4>
                                <input type="text" name="priority_set" value="<?= isset($_POST['priority_set']) ? $_POST['priority_set'] : ''; ?>" id="priorityset" class="form-control"
                                    placeholder="Set priority here....">
                                <?php if(isset($errors['priority_set'])): ?>
                                <label class="text-danger"><?=$errors['priority_set']; ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-material">
                                <h4 class="example-">&nbsp;</h4>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Panel End -->
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12">
                            <div class="form-group form-material">
                                <h4 class="example-">Logistic Priority List</h4>
                                <table class="table table-striped table-borderd" id="logisctic_priority_table">
                                    <thead>
                                        <tr>
                                            <td><b>Logistic Name</b></td>
                                            <td><b>Priority</b></td>
                                            <td><b>Action</b></td>
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